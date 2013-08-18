<?php

class xdcc_update_topic_mod extends module
{

 public $title = "Xdcc Update Topic Mod";
 public $author = "PastisD";
 public $version = "0.0.1";
 
 private $configDB;

 public function init()
 {
  $this->configDB = new ini("modules/xdcc_update_topic/config.ini");
 }
 
 public function priv_xdcc_update_topic( $line, $args )
 {
  if( $line['to'] == $this->ircClass->getNick() )
  {
   return;
  }
  
  if( $this->ircClass->hasModeSet( $line['to'], $line['fromNick'], 'qoa' ) )
  {
   if( $args['nargs'] == 0 )
   {
    $this->ircClass->notice( $line['fromNick'], "Commandes possible : !topic get/set xdcc <xdcc> (Définir quel xdcc sera utilisé pour définir le topic), !topic get/set topic <topic> (Définir le topic - {NEWS} sera l'endoit où les news seront mise dans le topic), !topic update (Mettre à jour le topic)." );
   }
   else
   {
    $this->update( $args['query'], $line );
   }
  }
  else
  {
   $this->ircClass->notice( $line['fromNick'], "Vous n'avez pas les accès nécessaire." );
  }
 }

 private function update( $query, $line )
 {
  $args = explode( " ", $query );
  switch( $args[0] )
  {
   case "set" :
   {
    $channel = $line['to'];
    switch( $args[1] )
    {
     case "xdcc":
     {
      
      $this->configDB->setIniVal( $channel, "xdcc", $args[2] );
      $this->configDB->writeIni();
      $this->ircClass->notice( $line['fromNick'], "Xdcc mis à jour" );
      break;
     }
     case "topic":
     {
      array_shift( $args );
      array_shift( $args );
      $this->configDB->setIniVal( $channel, "topic", implode( " ", $args ) );
      $this->configDB->writeIni();
      $this->ircClass->notice($line['fromNick'], "Topic défini" );
      break;
     }
     default:
     {
      $this->ircClass->notice($line['fromNick'], "Commandes possible : !topic get/set xdcc <xdcc> (Définir quel xdcc sera utilisé pour définir le topic), !topic get/set topic <topic> (Définir le topic - {NEWS} sera l'endoit où les news seront mise dans le topic), !topic update (Mettre à jour le topic).");
     }
    }
    break;
   }
   case "get" :
   {
    $channel = $line['to'];
    switch( $args[1] )
    {
     case "xdcc":
     {
      $xdcc = $this->configDB->getIniVal( $channel, "xdcc" );
      $this->ircClass->notice($line['fromNick'], "Xdcc utilisé pour la mise à jour du topic : " . $xdcc );
      break;
     }
     case "topic":
     {
      $topic = $this->configDB->getIniVal( $channel, "topic" );
      $this->ircClass->notice($line['fromNick'], "Topic utilisé : " . $topic );
      break;
     }
     default:
     {
      $this->ircClass->notice($line['fromNick'], "Commandes possibles : !topic get xdcc <xdcc> (Afficher le xdcc utilisé pour la mise à jour du topic, !topic get topic (Afficher le topic défini pour la mise à jour du topic)");
     }
    }
    break;
   }
   case "update" :
   {
    $this->update_topic( $line );
    break;
   }
   default:
   {
    $this->ircClass->notice( $line['fromNick'], "Commandes possibles : !topic get xdcc <xdcc> (Afficher le xdcc utilisé pour la mise à jour du topic, !topic get topic (Afficher le topic défini pour la mise à jour du topic)" );
   }
  }
 }
 
 private function update_topic( $line )
 {
  $topic = $this->configDB->getIniVal( $line["to"], "topic" );
  $xdcc = $this->configDB->getIniVal( $line["to"], "xdcc" );
  $date_from = strtotime( date( "Y-m-d 00:00:00" ) );
  $date_to = strtotime( date( "Y-m-d 23:59:59" ) );
  // var_dump( $date_from );
  // var_dump( $date_to );
  if( $xdcc == FALSE || empty( $xdcc ) )
  {
   $this->ircClass->notice( $line['fromNick'], "Vous devez définir un xdcc à utiliser pour la mise à jour du topic" );
   return;
  }
  if( $topic == FALSE || empty( $topic ) )
  {
   $this->ircClass->notice( $line['fromNick'], "Vous devez définir un topic à utiliser pour la mise à jour du topic" );
   return;
  }

  $query = 'SELECT p.*
            FROM `packs` p
            LEFT JOIN `xdccs` x ON ( x.`id`  = p.`id_xdcc` )
            LEFT JOIN `xdcc_irc_server` xis ON (xis.`id_xdcc` = x.`id` )
            WHERE xis.`name_xdcc` = "' . $xdcc . '"
              AND p.adddate > ' . $date_from . '
              AND p.adddate <= ' . $date_to . '
            GROUP BY p.id_pack';
  if( ( $result = $this->db->query( $query ) ) !== FALSE )
  {
   $news = array();
   while( $ligne = $this->db->fetchObject( $result ) )
   {
    $info = pathinfo( $ligne->name );
    $name = basename( $ligne->name, '.' . $info['extension']);
    preg_match( "/(.*)S([0-9]+)E([0-9]+)/", $name, $matches );
    $news[] = $matches[0];
   }
   if( empty( $news ) )
    $news = "Aucune";
   else
    $news = implode( ", ", $news );
   
   $this->ircClass->sendRaw( "TOPIC " . $line["to"] . " :" . str_replace( "{NEWS}", $news, $topic ) );
  }
  else
  {
   $this->ircClass->notice( $line['fromNick'], "Une erreur est survenue : " . $this->db->getError() );
  }
 }

}
?>
