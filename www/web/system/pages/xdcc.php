<?php

$template->set_filenames( array(
 'xdcc' => 'xdcc.tpl'
) );

//$id_xdcc = (int) $_GET['id_xdcc'];
//$id_team = (int) $_GET['id_team'];

$team = $teams[ $id_team ];
$template->assign_block_vars( 'team', array(
 'NAME' => $team->chan_name . "@" . $team->host,
 'IRC' => "irc://" . $team->host . ":" . $team->port . "/" . str_replace( "#", "", $team->chan_name),
) );

$adddate = 0;
$query = 'SELECT p.*, xis.name_xdcc FROM packs p
          LEFT JOIN xdccs x ON ( p.id_xdcc = x.id )
          LEFT JOIN team_xdcc tx ON ( tx.id_xdcc = x.id )
          LEFT JOIN teams t ON ( x.id = x.id )
          LEFT JOIN xdcc_irc_server xis ON ( xis.id_xdcc = x.id )
          WHERE x.show_on_listing = 1
            AND t.id = ' . $id_team . '
            AND x.id = ' . $id_xdcc . '
            AND xis.id_ircserver = t.id_ircserver
          ORDER BY p.id_pack';
if ( $result = $mysqli->query( $query ) )
{
 $i = 0;
 while ( $obj = $result->fetch_object() )
 {
//  echo $obj->id_pack . " : " . mb_detect_encoding($obj->name) . "<br />";
  $adddate = ($obj->adddate > $adddate) ? $obj->adddate : $adddate;
  $template->assign_block_vars( 'packs', array(
   'ID' => $obj->id_pack,
   'NAME' => $obj->name,
   'NAME_XDCC' => $obj->name_xdcc,
   'CUT_NAME' => truncate( $obj->name, 60 ),
   'GETS' => $obj->gets,
   'SIZE' => $obj->size,
   'CLASS' => ($i%2) ? "even" : ""
  ) );
  $i++;
//  $packs[ $obj->id_pack ] = $obj;
 }
}

$xdcc = $xdccs[ $id_team ][ $id_xdcc ];
//echo '<pre>', var_dump( $xdcc ), '</pre>';
$template->assign_block_vars( 'xdcc', array(
 'NAME' => $xdcc->name_xdcc,
 'PACK_SUM' => $xdcc->packsum,
 'LAST_UPDATE' => date( 'd/m/Y h:i', $adddate ),
 'TOTAL_TRANSFERED' => $xdcc->transferedtotal,
 'DISK_SPACE' => $xdcc->diskspace,
 'TRANSFERED_TOTAL' => $xdcc->transferedtotal
) );

$template->pparse( 'xdcc' );

//echo '<pre>', var_dump( $packs ), '</pre>';

?>
