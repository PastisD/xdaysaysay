<?php

$template->set_filenames( array(
 'search' => 'search.tpl'
) );

$levenstein = array();
$query = "SELECT DISTINCT *
          FROM levenstein;";
 if ( $result = $mysqli->query( $query ) )
 {
  while ( $obj = $result->fetch_object() )
  {
   foreach( explode(' ', $pattern) as $word)
   {
    $number = levenshtein($obj->name, $word);
    if( $number <= 3 )
    {
     $levenstein[] = $obj->name;
    }
   }
  }
 }


if( !is_null( $pattern ) && !empty( $pattern ))
{
 $query = "SELECT DISTINCT
                  p.id_pack,
                  p.id_xdcc,
                  p.name,
                  p.size,
                  p.gets,
                  xis.name_xdcc,
                  t.name AS team_name,
                  t.id AS id_team
           FROM packs p
           LEFT JOIN xdccs x ON ( x.id = p.id_xdcc )
           LEFT JOIN xdcc_irc_server xis ON ( xis.id_xdcc = x.id )
           LEFT JOIN team_xdcc tx ON (tx.id_xdcc = x.id) 
           LEFT JOIN teams t ON ( t.id = tx.id_team )
           WHERE p.name LIKE ('%" . str_replace(" ", "%", $pattern ) . "%')
             AND t.show_on_listing = '1'
             AND x.show_on_listing = '1'";
 $query .= ( !is_null( $id_team ) && isset( $teams[ $id_team ] ) ) ? "  AND t.id = " . $id_team . " " : " ";
 $query .= "ORDER BY t.name, xis.name_xdcc, p.id_pack;";
 $teams_search = array();
 if ( $result = $mysqli->query( $query ) )
 {
  while ( $obj = $result->fetch_object() )
  {
   $teams_search[ $obj->id_team ][ $obj->id_xdcc ][ $obj->id_pack ] = $obj;
  }
 }
 foreach( $teams_search as $id_team => $team_search )
 {
  $team = $teams[ $id_team ];
  $template->assign_block_vars( 'teams_search', array(
   'NAME' => $team->chan_name . "@" . $team->host,
   'IRC' => "irc://" . $team->host . ":" . $team->port . "/" . str_replace( "#", "", $team->chan_name),
  ) );
  foreach( $team_search as $id_xdcc => $xdcc_search )
  {
   $xdcc = $xdccs[ $id_team ][ $id_xdcc ];
   $template->assign_block_vars( 'teams_search.xdccs_search', array(
    'NAME' => $xdcc->name_xdcc,
   ) );
   $i = 0;
   foreach( $xdcc_search as $pack )
   {
    $template->assign_block_vars( 'teams_search.xdccs_search.packs_search', array(
     'ID' => $pack->id_pack,
     'NAME' => $pack->name,
     'CUT_NAME' => truncate( $pack->name, 60 ),
     'GETS' => $pack->gets,
     'SIZE' => $pack->size,
     'CLASS' => ($i%2) ? "even" : ""
    ) );
    $i++;
   }
  }
 }
 if( empty( $teams_search ) )
 {
  $template->assign_block_vars( 'no_result', array() );
  if( !empty( $levenstein ) )
  {
   $template->assign_block_vars( 'no_result.leveinstein', array() );
   foreach( $levenstein as $word )
   {
    $template->assign_block_vars( 'no_result.leveinstein.words', array(
     'URL' => "./?id_team=" . $id_team . "&pattern=" . $word,
     'WORD' => $word
    ) );
   }
  }
 }
}

$template->pparse( 'search' );

?>
