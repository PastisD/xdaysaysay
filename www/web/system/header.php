<?php

include('./system/config.php');
include('./system/template.php');
include('./system/functions.php');

date_default_timezone_set( 'Europe/Paris' );

$mysqli = new mysqli( $config['mysql_host'], $config['mysql_user'], $config['mysql_password'], $config['mysql_dbname'] );
if ( mysqli_connect_errno ( ) )
{
 printf( "Ehec de la connexion à la base de donnée : %s\n", mysqli_connect_error() );
 exit();
}

$query = 'SET NAMES UTF8;';
$mysqli->query( $query );

$template = new Template( './templates/tpls/' );
$template->set_filenames( array(
 'header' => 'header.tpl',
 'footer' => 'footer.tpl',
) );

$template->assign_vars( array(
 'URL' => $config['url'],
 'DATE' => date_french( 'l j F Y' ),
) );

$xdccs = array( );
$query = 'SELECT DISTINCT x.*, xis.name_xdcc, tx.id_team FROM xdccs x
          LEFT JOIN team_xdcc tx ON ( x.id = tx.id_xdcc )
          LEFT JOIN teams t ON ( tx.id_team = t.id )
          LEFT JOIN xdcc_irc_server xis ON ( xis.id_xdcc = x.id )
          WHERE x.show_on_listing = "1"
            AND t.show_on_listing = "1"
            AND t.id_ircserver = xis.id_ircserver
          ORDER BY xis.name_xdcc';
//echo $query;
if ( $result = $mysqli->query( $query ) )
{
 while ( $obj = $result->fetch_object() )
 {
  $xdccs[ $obj->id_team ][ $obj->id ] = $obj;
 }
}

$id_xdcc = isset( $_GET['id_xdcc'] ) ? (int) $_GET['id_xdcc'] : NULL;
$id_team = isset( $_GET['id_team'] ) ? (int) $_GET['id_team'] : NULL;
$pattern = isset( $_GET['pattern'] ) ? (string) $_GET['pattern'] : NULL;

$template->assign_vars( array(
 'SEARCH' => $pattern
) );

$teams = array();
$query = 'SELECT `is`.*,
                 t.*,
                 t.name AS team_name
          FROM teams t
          LEFT JOIN irc_servers `is` ON ( t.id_ircserver = is.id )
          WHERE show_on_listing = "1"
          ORDER BY t.name';
if ( $result = $mysqli->query( $query ) )
{
 while ( $obj = $result->fetch_object() )
 {
  $template->assign_block_vars( 'teams', array(
   'ID' => $obj->id,
   'NAME' => $obj->name,
   'URI_NAME' => strtouri( $obj->name ),
   'SELECTED' => ( $id_team == $obj->id ? " selected=\"selected\"" : "" )
  ) );
  $teams[$obj->id] = $obj;
  if ( isset( $xdccs[$obj->id] ) )
  {
   foreach ( $xdccs[$obj->id] as $xdcc )
   {
    $template->assign_block_vars( 'teams.xdccs', array(
     'ID' => $xdcc->id,
     'NAME' => $xdcc->name_xdcc,
     'URI_NAME' => strtouri( $xdcc->name_xdcc ),
     'SELECTED' => ( $id_xdcc == $xdcc->id ? "selected" : "" )
    ) );
   }
  }
 }
}
//echo '<pre>', var_dump($teams), '</pre>';

$template->pparse( 'header' );
?>
