<?php

class xdcc_update_mod extends module
{

 public $title = "Xdcc Update Mod";
 public $author = "PastisD";
 public $version = "0.0.1";

 public function priv_xdcc_update( $line, $args )
 {
  if( $line['to'] == $this->ircClass->getNick() )
  {
   return;
  }

  if( $args['nargs'] == 0 )
  {
   $this->ircClass->notice( $line['fromNick'], "Vous n'avez pas défini de xdcc à mettre à jour." );
  }
  else
  {
   $this->update( $args['query'], $line );
  }
 }

 private function update( $xdcc, $line )
 {
  if( $this->ircClass->hasModeSet( $line['to'], $line['fromNick'], 'qoa' ) )
  {
   $servers = array( );
   $query = 'SELECT s.`host`,
                    s.`http_port`,
                    x.`url`,
                    x.`id`
             FROM `xdccs` x
             LEFT JOIN `servers` s ON ( s.`id` = x.`id_server` )
             LEFT JOIN team_xdcc tx ON ( tx.`id_xdcc` = x.`id` )
             LEFT JOIN teams t ON ( x.`id` = x.`id` )
             LEFT JOIN xdcc_irc_server xis ON ( xis.`id_xdcc` = x.`id` )
             WHERE xis.`id_ircserver` = t.`id_ircserver` 
             AND t.chan_name = \'' . $line['to'] . '\' ';
   if( $xdcc != "all" )
    $query .= " AND xis.`name_xdcc` = '" . $xdcc . "'";
//   echo $query;
   if( ( $result = $this->db->query( $query ) ) !== FALSE )
   {
    while( $ligne = $this->db->fetchObject( $result ) )
    {
     if( !isset( $servers[$ligne->host] ) )
     {
      $servers[$ligne->host] = array( );
     }
     if( !isset( $servers[$ligne->host][$ligne->http_port] ) )
     {
      $servers[$ligne->host][$ligne->http_port] = array( );
     }
     $servers[$ligne->host][$ligne->http_port][$ligne->id] = $ligne->url;
    }
    if( !empty( $servers ) )
    {
//     echo '<pre>', var_dump( $this->db ), '</pre>';
     $con = new mysqli( $this->db->host, $this->db->user, $this->db->pass, $this->db->database );
     $xdcc = new xdcc( $con, $this->ircClass, $line );
     $xdcc->update( $servers );
    }
    else
    {
     $this->ircClass->notice( $line['fromNick'], "Aucun xdcc trouvé à ce nom." );
    }
   }
   else
   {
    $this->ircClass->notice( $line['fromNick'], "Une erreur est survenue : " . $this->db->getError() );
   }   
  }
  else
  {
   $this->ircClass->notice( $line['fromNick'], "Vous n'avez pas les accès nécessaire." );
  }
 }

}

class xdcc
{

 private $con;
 private $ircClass;
 private $line;
 private static $irc_servers;
 private static $prepare_insert_xdcc_chan = array( );
 private static $leveinstein = array( );

 public function __construct( $con, $ircClass, $line )
 {
  $this->con = $con;
  $this->ircClass = $ircClass;
  $this->line = $line;
 }

 /**
  *
  * @param <type> $servers
  */
 public function update( $servers )
 {

  $this->get_irc_server_list();

  foreach( $servers as $host => $ports )
  {
   foreach( $ports as $port => $xdccs )
   {
    $file = @fsockopen( $host, $port, $errno, $errstr, 10 );
    if( $file !== false )
    {
     foreach( $xdccs as $id_xdcc => $url )
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
  $this->ircClass->notice( $this->line['fromNick'], "Mise à jour terminée" );
//  $this->insert_leveinstein();
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
  if( ($ch = curl_init( $url )) === false )
  {
   echo "erreur curl\n";
  }
  else
  {
   curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

   if( ($xdcc_file = curl_exec( $ch )) === false )
   {
    curl_close( $ch );
    die( 'erreur curl_exec' );
   }
   else
   {
    try
    {
     $dom = new SimpleXMLElement( $xdcc_file );
     $this->insert_xdcc_info( $dom, $id_xdcc );
     $this->insert_xdcc_packs( $dom, $id_xdcc );
     $this->prepare_insert_xdcc_chan( $dom, $id_xdcc );
     $this->insert_xdcc_chan( $id_xdcc );
    }
    catch( Exception $e )
    {
     echo $e->getMessage();
    }
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
  if( $rpq = $this->con->prepare( 'UPDATE `xdccs` SET
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
   $this->ircClass->notice( $this->line['fromNick'], "Ne peux pas mettre à jour les informations du xdcc : " . $this->con->error );
  }
  $rpq->close();
 }

 private function insert_xdcc_packs( $dom, $id_xdcc )
 {
  $i = 0;
  $query = "INSERT INTO packs (id_xdcc, id_pack, name, size, gets, adddate, md5sum, crc32) VALUES ";
  $queries = array( );
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
  foreach( $packs as $node )
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
  // $this->insert_leveinstein( $id_xdcc );
  if( ( $rpq = $this->con->prepare( 'DELETE FROM packs WHERE id_xdcc = ?' ) ) !== FALSE )
  {
   $rpq->bind_param( 'i', $id_xdcc );
   $rpq->execute();
   $rpq->close();
  }
  else
  {
   $this->ircClass->notice( $this->line['fromNick'], "Erreur de supression des packs : " . $this->con->error );
  }
  if( !empty( $queries ) )
  {
   $query = $query . implode( ',', $queries );

   if( $this->con->query( $query ) === FALSE )
   {
    $this->ircClass->notice( $this->line['fromNick'], "Erreur d'insertion des packs : " . $this->con->error );
   }
  }
  else
  {
//   $this->ircClass->notice( $this->line['fromNick'], "Aucun packs" );
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
   if( ( $result = $this->con->query( 'SELECT *
                                       FROM `irc_servers`' ) ) !== FALSE )
   {
    while( $ligne = $result->fetch_object() )
    {
     $host = $this->getbaseUrl( $ligne->host );
     self::$irc_servers[$host] = $ligne->id;
    }
   }
   else
   {
    $this->ircClass->notice( $this->line['fromNick'], "Erreur get_irc_server_list() : " . $this->con->error );
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
   if( isset( self::$irc_servers[$host] ) )
   {
    self::$prepare_insert_xdcc_chan[] = "(" . (int) self::$irc_servers[$host] . ", "
            . (int) $id_xdcc . ", '"
            . $this->con->escape_string( $currentNick ) . "')";
   }
  }
 }

 private function multi_explode( $pattern, $string, $standardDelimiter = ':' )
 {
  // replace delimiters with standard delimiter, also removing redundant delimiters
  $string = preg_replace( array( $pattern, "/{$standardDelimiter}+/s" ), $standardDelimiter, $string );

  // return the results of explode
  return explode( $standardDelimiter, $string );
 }

 private function insert_xdcc_chan( $id_xdcc )
 {
  if( ( $rpq = $this->con->prepare( 'DELETE FROM xdcc_irc_server WHERE id_xdcc = ?' ) ) !== FALSE )
  {
   $rpq->bind_param( 'i', $id_xdcc );
   $rpq->execute();
   $rpq->close();
  }
  else
  {
   $this->ircClass->notice( $this->line['fromNick'], "Erreur de supression des liaisons xdcc/irc serveur : " . $this->con->error );
  }

  $query = 'INSERT INTO `xdcc_irc_server` (id_ircserver, id_xdcc, name_xdcc ) VALUES ';
  if( !empty( self::$prepare_insert_xdcc_chan ) )
  {
   $query = $query . implode( ',', self::$prepare_insert_xdcc_chan );

   if( $this->con->query( $query ) === FALSE )
   {
    $this->ircClass->notice( $this->line['fromNick'], "Erreur insert_xdcc_chan() : " . $this->con->error );
//    echo $query . "\n";
   }
  }
  self::$prepare_insert_xdcc_chan = array();
 }

 private function prepare_leveinstein( array $words, $id_xdcc )
 {
  foreach( $words as $word )
  {
   $query = "('" . $this->con->escape_string( $word ) . "', " . $id_xdcc . ")";
   if( !in_array( $query, self::$leveinstein ) )
    self::$leveinstein[] = $query;
  }
 }

 private function insert_leveinstein( $id_xdcc )
 {
  if( ( $rpq = $this->con->prepare( 'DELETE FROM levenstein where id_xdcc = ?' ) ) !== FALSE )
  {
   $rpq->bind_param( 'i', $id_xdcc );
   $rpq->execute();
   $rpq->close();
  }
  else
  {
   $this->ircClass->notice( $this->line['fromNick'], "Erreur de supression des levenstein : " . $this->con->error );
  }

  if( !empty( self::$leveinstein ) )
  {
   $query = 'INSERT INTO `levenstein` ( name, id_xdcc ) VALUES ' . implode( ',', self::$leveinstein );
   if( $this->con->query( $query ) === FALSE )
   {
    $this->ircClass->notice( $this->line['fromNick'], "Erreur insert_leveinstein() : " . $this->con->error );
//    echo $query . "\n" . $this->con->error;
   }
  }
 }

}

?>
