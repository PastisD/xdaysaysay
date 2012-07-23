<?php

class xdcc
{

 private $con;
 private static $irc_servers;
 private static $prepare_insert_xdcc_chan = array();
 private static $leveinstein = array();

 public function __construct( mysqli $con )
 {
  $this->con = $con;
 }

 /**
  *
  * @param <type> $servers
  */
 public function update( $servers )
 {

  $this->get_irc_server_list();

  foreach ( $servers as $host => $ports )
  {
   foreach ( $ports as $port => $xdccs )
   {
    $file = @fsockopen( $host, $port, $errno, $errstr, 10 );
    if ( $file !== false )
    {
     foreach ( $xdccs as $id_xdcc => $url )
     {
      $this->register_file_http( $host, $port, $url, $id_xdcc );
     }
    }
    else
    {
     echo "L'hôte " . $host . ":" . $port . " n'est pas disponible\n";
     echo "---------------------------------------\n";
    }
   }
  }
  $this->insert_xdcc_chan();
  $this->insert_leveinstein();
 }

 /**
  *
  * @param string $host
  * @param int $port
  * @param string $url
  * @param int $id_xdcc
  */
 private function register_file_http( $host, $port, $url, $id_xdcc )
 {
  $xdcc_file = '';
  $url = 'http://' . $host . ':' . $port . $url;
  echo $url . " ----- \n";
  if ( ($ch = curl_init( $url )) === false )
  {
   echo "erreur curl\n";
  }
  else
  {
//   curl_setopt( $ch, CURLOPT_HEADER, 0 );
   curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

   if ( ($xdcc_file = curl_exec( $ch )) === false )
   {
    curl_close( $ch );
    echo "erreur curl_exec\n";
   }
   else
   {
//    echo $xdcc_file;
//    $encoding = mb_detect_encoding( $xdcc_file ) . " --- ";
//    $xdcc_file = str_replace("<?xml version=\"1.0\" encoding=\"UTF-8\">", "<?xml version=\"1.0\" encoding=\"ISO-8859-1\">", $xdcc_file);
    try
    {
     $dom = new SimpleXMLElement( $xdcc_file );
     $this->insert_xdcc_info( $dom, $id_xdcc );
     $this->insert_xdcc_packs( $dom, $id_xdcc );
     $this->prepare_insert_xdcc_chan( $dom, $id_xdcc );
    }
    catch( Exception $e)
    {
     echo $e->getMessage();
    }
//    if ( $dom->loadXML( $xdcc_file ) )
//    {
//     $this->insert_xdcc_info( $dom, $id_xdcc );
//     $this->insert_xdcc_packs( $dom, $id_xdcc );
//    }
   }
  }
  echo "---------------------------------------\n";
 }

 /**
  *
  * @param SimpleXMLElement $dom
  * @param int $id_xdcc
  */
 private function insert_xdcc_info( SimpleXMLElement $dom, $id_xdcc )
 {
  if ( $rpq = $this->con->prepare( 'UPDATE `xdccs` SET
			`packsum` = ?,
			`diskspace` = ?,
			`transferedtotal` = ?,
			`totaluptime` = ?,
			`lastupdate` = ? 
			WHERE `id` = ?' ) )
  {
   $rpq->bind_param( 'isssii', $dom->sysinfo->quota->packsum, $dom->sysinfo->quota->diskspace, $dom->sysinfo->quota->transferedtotal, $dom->sysinfo->stats->totaluptime, $dom->sysinfo->stats->lastupdate, $id_xdcc );
   $rpq->execute();
  }
  else
  {
   echo "Ne peux pas mettre à jour les informations du xdcc : " . $this->con->error . "\n";
  }
  $rpq->close();
 }

 private function insert_xdcc_packs( $dom, $id_xdcc )
 {
  $i = 0;
  $query = "INSERT INTO packs (id_xdcc, id_pack, name, size, gets, adddate, md5sum, crc32) VALUES ";
  $queries = array();
  if( $dom->packlist )
  {
//   echo '<pre>', var_dump($dom->packlist), '</pre>';
//   die();
   $packs = $dom->packlist->pack;
  }
  else
  {
   $packs = $dom->pack;
  }
  foreach ( $packs as $node )
  {
   $packnr = (int) $node->packnr;
   $packname = $node->packname;
   $packsize = $node->packsize;
   $packgets = (int) $node->packgets;
   $adddate = ( $node->adddate ) ? $node->adddate : $node->added;
   $md5sum = $node->md5sum;
   $crc32 = $node->crc32;
   $queries[] = "('" . $this->con->escape_string( $id_xdcc ) . "', '"
                     . $this->con->escape_string( $packnr ) . "', '"
                     . $this->con->escape_string( $packname ) . "', '"
                     . $this->con->escape_string( $packsize ) . "', '"
                     . $this->con->escape_string( $packgets ) . "', '"
                     . $this->con->escape_string( $adddate ) . "', '"
                     . $this->con->escape_string( $md5sum ) . "', '"
                     . $this->con->escape_string( $crc32 ) . "') ";
   $this->prepare_leveinstein( $this->multi_explode( '/[-.\s\_]/', $node->packname ), $id_xdcc );
  }
  if ( $rpq = $this->con->prepare( 'DELETE FROM packs WHERE id_xdcc = ?' ) )
  {
   $rpq->bind_param( 'i', $id_xdcc );
   $rpq->execute();
   $rpq->close();
  }
  else
  {
   echo "Erreur de supression des packs\n";
  }
  if( !empty( $queries ) )
  {
   $query =  $query . implode(',', $queries );

   if ( $this->con->query( $query ) === FALSE )
   {
    echo $query . "\n";
   }
  }
  else
  {
   echo "Aucun packs\n";
  }
 }

 private function getbaseUrl( $url )
 {
  $hostParts = explode( '.', $url );
  $hostParts = array_reverse( $hostParts );
  return $hostParts[1] . '.' . $hostParts[0];
 }

 /**
  *
  */
 private function get_irc_server_list()
 {
  if( is_null( self::$irc_servers ) )
  {
   if ( $result = $this->con->query( 'SELECT *
                                      FROM `irc_servers`' ) )
   {
    while ( $ligne = $result->fetch_object() )
    {
     $host = $this->getbaseUrl( $ligne->host );
     self::$irc_servers[ $host ] = $ligne->id;
    }
   }
  }
 }

 /**
  *
  * @param SimpleXMLElement $dom
  * @param int $id_xdcc
  */
 private function prepare_insert_xdcc_chan( SimpleXMLElement $dom, $id_xdcc )
 {
  foreach( $dom->sysinfo->network as $network )
  {
    $currentNick = (string) $network->currentnick;
    $host = $this->getbaseUrl( (string) $network->servername );
    if( isset( self::$irc_servers[ $host ] ) )
    {
     self::$prepare_insert_xdcc_chan[] = "(" . (int) self::$irc_servers[ $host ] . ", "
                                              . (int) $id_xdcc . ", '"
                                              . $this->con->escape_string( $currentNick ) . "')";
    }
  }
 }

 private function multi_explode($pattern, $string, $standardDelimiter = ':')
 {
  // replace delimiters with standard delimiter, also removing redundant delimiters
  $string = preg_replace(array($pattern, "/{$standardDelimiter}+/s"), $standardDelimiter, $string);

  // return the results of explode
  return explode($standardDelimiter, $string);
 }

 private function insert_xdcc_chan()
 {
  if ( $rpq = $this->con->prepare( 'DELETE FROM xdcc_irc_server' ) )
  {
   $rpq->execute();
   $rpq->close();
  }
  else
  {
   echo "Erreur de supression des liaisons xdcc/irc serveur\n";
  }

  $query = 'INSERT INTO `xdcc_irc_server` (id_ircserver, id_xdcc, name_xdcc ) VALUES ';
  if( !empty( self::$prepare_insert_xdcc_chan ) )
  {
   $query =  $query . implode(',',  self::$prepare_insert_xdcc_chan );

   if ( $this->con->query( $query ) === FALSE )
   {
    echo $query . "\n";
   }
  }
 }

 private function prepare_leveinstein( array $words, $id_xdcc )
 {
  foreach( $words as $word )
  {
   $query = "('" . $this->con->escape_string ( $word ) . "', " . $id_xdcc . ")";
   if( !in_array($query, self::$leveinstein ) )
    self::$leveinstein[] = $query;
  }
 }

 private function insert_leveinstein()
 {
  if ( $rpq = $this->con->prepare( 'DELETE FROM levenstein' ) )
  {
   $rpq->execute();
   $rpq->close();
  }
  else
  {
   echo "Erreur de supression des levenstein\n";
  }
  
  if( !empty( self::$leveinstein ) )
  {
   $query =  'INSERT INTO `levenstein` ( name, id_xdcc ) VALUES ' . implode(',',  self::$leveinstein );
   if ( $this->con->query( $query ) === FALSE )
   {
    echo $query . "\n" . $this->con->error;
   }
  }
 }
}
?>
