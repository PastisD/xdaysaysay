<?php

class xdcc_find_mod extends module
{

 public $title = "Xdcc List Mod";
 public $author = "PastisD";
 public $version = "0.0.1";

 public function priv_xdcc_find( $line, $args )
 {
  if( $line['to'] == $this->ircClass->getNick() )
  {
   return;
  }
//  echo '<pre>', var_dump( $line ), '</pre>';
//  echo '<pre>', var_dump( $args ), '</pre>';

  if( $args['nargs'] == 0 )
  {
   $this->ircClass->notice( $line['fromNick'], "Vous n'avez pas défini de recherche." );
  }
  else
  {
   $this->find( $args['query'], $line );
  }
 }

 private function find( $pattern, $line )
 {
  $query = "SELECT DISTINCT
                   p.id_pack,
                   p.id_xdcc,
                   p.name,
                   p.size,
                   xis.name_xdcc
            FROM packs p
            JOIN xdccs x ON ( x.id = p.id_xdcc )
            JOIN team_xdcc tx ON ( tx.id_xdcc = x.id )
            JOIN xdcc_irc_server xis ON ( xis.id_xdcc = x.id )
            JOIN teams t ON ( t.id = tx.id_team )
            WHERE p.name LIKE ('%" . str_replace( " ", "%", $pattern ) . "%')
              AND t.chan_name = '" . $line['to'] . "'
              AND x.show_on_listing = '1'
            ORDER BY t.name, xis.name_xdcc, p.id_pack;";
  
  $teams_search = array( );
  if( $result = $this->db->query( $query ) )
  {
   while( $obj = $this->db->fetchObject( $result ) )
   {
    $teams_search[$obj->id_xdcc][$obj->id_pack] = $obj;
   }
   if( !empty( $teams_search ) )
   {
    $chat = new send_result( $teams_search );

    $port = $this->dccClass->addChat( $line['fromNick'], null, null, true, $chat );
    if( $port === false )
    {
     $this->ircClass->notice( $line['fromNick'], "Error starting chat, please try again.", 1 );
    }
   }
   else
   {
    $this->ircClass->notice( $line['fromNick'], "Aucun résultat", 1 );
   }
  }
  else
  {
   $this->ircClass->notice( $line['fromNick'], "Une erreur est survenue : " . $this->db->getError() );
  }
 }

}

class send_result
{

 private $teams_search = array( );

 public function __construct( $teams_search )
 {
  $this->teams_search = $teams_search;
 }

 public function main( $line, $args )
 {
  $port = $this->dccClass->addChat( $line['fromNick'], null, null, false, $this );

  if( $port === false )
  {
   $this->ircClass->notice( $line['fromNick'], "Error starting chat, please try again.", 1 );
  }
 }

 public function handle( $chat, $args )
 {
  
 }

 public function connected( $chat )
 {
  foreach( $this->teams_search as $xdcc )
  {
   $first = reset( $xdcc );
   $count = count( $xdcc );
   $id_packs = array();
   foreach( $xdcc as $pack )
   {
    $id_packs[] = strlen( $pack->id_pack );
   }
   $max = max( $id_packs );
   $chat->dccSend( RED . $count . " résultats trouvés pour le bot " . $first->name_xdcc );
   foreach( $xdcc as $pack )
   {
    $strlen = strlen( $pack->id_pack );
    $chat->dccSend( "  #" . $pack->id_pack . str_repeat( " ", ($max - $strlen ) ) . " - [" . $pack->size . "] - " . $pack->name . " -> " . OLIVE . "/msg " . $pack->name_xdcc . " send #" . $pack->id_pack );
   }
   $chat->dccSend( "---" );
  }
 }

 //Following function added for 2.2.1
 public function disconnected( $chat )
 {
  
 }

}

?>
