<?php

include_once(PATH . '/user/NavPages.class.php');
include_once(PATH . '/user/ircservers.class.php');

/**
 * Description of teamsclass
 *
 * @author PastisD
 */
class teams
{

 private $template = null;
 private $mysqli = null;

 private function haveAccess()
 {
  return (isset( $_SESSION['intranet_listing_xdcc'] ) && $_SESSION['intranet_listing_xdcc']['is_admin']);
 }

 public function __construct( $show = true )
 {
  global $template;
  global $mysqli;

  if( !$this->haveAccess() )
   header( 'Location: ' . URI );

  $this->template = &$template;
  $this->mysqli = &$mysqli;
  $this->irc_servers = new ircservers( false );

  if( $show )
  {
   $this->template->assign( 'TEAMS_SELECTED', ' class="selected"' );
   $options = array( "page" => 1, "order_by" => NULL, "order" => NULL, "search" => NULL );
   // Contrôle des paramètres
   if( isset( $_GET['p'] ) && !empty( $_GET['p'] ) )
    $options["page"] = $_GET['p'];
   if( isset( $_GET['ob'] ) && !empty( $_GET['ob'] ) )
    $options["order_by"] = $_GET['ob'];
   if( isset( $_GET['o'] ) && !empty( $_GET['o'] ) )
    $options["order"] = $_GET['o'];
   if( isset( $_GET['search'] ) && !empty( $_GET['search'] ) )
    $options["search"] = $_GET['search'];

   if( isset( $_GET['action'] ) )
   {
    switch( $_GET['action'] )
    {
     case 'edit':
      $this->template->assign( 'MODE', 'edit' );
      $this->template->assign( 'HEAD', 'Editer une team' );
      $this->template->assign( 'ID', $_GET['id'] );
      $this->get_team( $_GET['id'] );
      $this->template->assign( 'IRC_SERVERS', $this->irc_servers->get_list_irc_servers_for_teams() );
      $return = $this->addEditTeam();
      break;
     case 'add':
      $this->template->assign( 'MODE', 'add' );
      $this->template->assign( 'HEAD', 'Ajouter une nouvelle team' );
      $this->template->assign( 'IRC_SERVERS', $this->irc_servers->get_list_irc_servers_for_teams() );
      $return = $this->addEditTeam();
      break;
     default:
      $return = $this->showListTeams( $options );
    }
   }
   else
   {
    $return = $this->showListTeams( $options );
   }

   $this->template->display( 'intranet/header.tpl' );
   echo $return;
   $this->template->display( 'intranet/footer.tpl' );
  }
 }

 private function showListTeams( $options )
 {
  $return = $this->get_list_teams_table( $options );
  $this->template->assign( 'LIST_TEAMS', $return['html'] );
  return $this->template->fetch( 'intranet/teams/index.tpl' );
 }

 public function get_team( $id )
 {
  $query = 'SELECT `id`, `name`, `id_ircserver`, `chan_name` FROM `teams` WHERE `id` = ?';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( "i", $id );
   $rpq->bind_result( $id, $name, $id_ircserver, $chan_name );
   $rpq->execute();
   if( $rpq->fetch() )
   {
    $this->template->assign( 'NAME', $name );
    $this->template->assign( 'IRC_SERVERSSELECTED', $id_ircserver );
    $this->template->assign( 'IRC_CHAN', $chan_name );
   }
  }
 }

 public function get_list_teams( $options = array( ), &$nbTotal )
 {
  $query = 'SELECT SQL_CALC_FOUND_ROWS
                         t.`id`,
                         t.`name`,
                         irc.`name` as irc_name,
                         t.`chan_name`
                  FROM `teams` t
                  LEFT JOIN `irc_servers` `irc` ON ( t.`id_ircserver` = irc.`id` )  '
          . ( $options["search-final"] !== NULL ? "WHERE CONCAT( t.`name`, ' ', irc.`name`, ' ', t.`chan_name` ) LIKE '%" . $options["search-final"] . "%' " : '' )
          . ' ORDER BY ' . (isset( $options['order_by-final'] ) ? $options['order_by-final'] : 't.`name`') . ' ' . (isset( $options['order-final'] ) ? $options['order-final'] : 'ASC')
          . ' LIMIT ' . (isset( $options['page-final'] ) ? (($options['page-final'] * NB_ELEMENTS_PER_PAGE - NB_ELEMENTS_PER_PAGE) . ', ' . ($options['page-final'] * NB_ELEMENTS_PER_PAGE)) : '0, ' . NB_ELEMENTS_PER_PAGE);

  $return = array( );
  if( $result = $this->mysqli->query( $query ) )
  {
   while( $array = $result->fetch_object() )
   {
    $return[] = array(
        'id' => $array->id,
        'name' => $array->name,
        'irc_name' => $array->irc_name,
        'chan_name' => $array->chan_name
    );
   }

   $query = "SELECT FOUND_ROWS() AS `nbRows`;";
   if( ( $result2 = $this->mysqli->query( $query ) ) !== FALSE && $ligne = $result2->fetch_object() )
    $nbTotal = $ligne->nbRows;
   else
    $nbTotal = 0;

   return $return;
  }
  else
  {
   echo $this->mysqli->error;
   return false;
  }
 }

 public function get_list_teams_table( $options = array( ) )
 {
  $this->controlOptionsForList( $options );
  $info_teams = $this->get_list_teams( $options, $nbTotal );
  $pagination = $this->getNavPages( $options, $nbTotal );
  $this->template->assign( 'INFOS_TEAM', $info_teams );
  $this->template->assign( 'PAGINATION', $pagination );
  $this->template->assign( 'TOTAL_TEAMS', $nbTotal );
  return array( 'html' => $this->template->fetch( 'intranet/teams/listteams.tpl' ), 'pagination' => $pagination, 'nbTotal' => $nbTotal );
 }

 private function addEditTeam()
 {
  return $this->template->fetch( 'intranet/teams/addeditteam.tpl' );
 }

 public function getNavPages( array $options, $nbTotal )
 {
  return NavPages::getNavPages( $nbTotal, NB_ELEMENTS_PER_PAGE, "./index-%i" . (!empty( $options["order_by-final"] ) ? "-" . $options["order_by-final"] : "" ) . (!empty( $options["order-final"] ) ? "-" . $options["order-final"] : "" ) . ".html" . (!is_null( $options["search-final"] ) ? "?search=" . urlencode( $options["search-final"] ) : "" ), $options["page-final"], "movePage(%i); return false;" );
 }

 private function controlOptionsForList( array &$options )
 {
  // Page

  if( !is_numeric( $options["page"] ) || $options["page"] < 1 )
   $options["page-final"] = 1;
  else
   $options["page-final"] = intval( $options["page"] );

  // Order
  switch( $options["order"] )
  {
   case 'asc':
    $options["order-final"] = "ASC";
    break;
   case 'desc':
    $options["order-final"] = "DESC";
    break;
   default:
    $options["order-final"] = "ASC";
  }

  // Order by
  switch( $options["order_by"] )
  {
   case 'name':
    $options["order_by-final"] = "t.`name`";
    break;
   case 'irc_server':
    $options["order_by-final"] = "irc.`name`";
    break;
   case 'chan':
    $options["order_by-final"] = "t.`chan_name`";
    break;
   default:
    $options["order_by-final"] = "t.`name`";
  }

  // Recherche
  if( empty( $options["search"] ) || strlen( $options["search"] ) < 3 )
   $options["search-final"] = NULL;
  else
   $options["search-final"] = trim( $options["search"] );
 }

 public function editTeam( $id, $name, $id_ircserver, $chan_name )
 {
  $query = 'UPDATE `teams`SET
                         `name` = ?,
                         `id_ircserver` = ?,
                         `chan_name` = ?
                   WHERE `id`= ?;';

  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'sisi', $name, $id_ircserver, $chan_name, $id );
   if( !$rpq->execute() )
    return false;
   else
    return true;
  }
  else
   return false;
  return true;
 }

 public function delTeam( $id )
 {
  $query = 'DELETE FROM `teams` WHERE `id` = ?;';

  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'i', $id );
   if( !$rpq->execute() )
    return false;
   else
    return true;
  }
  else
   return false;
 }

 public function addTeam( $name, $irc_server, $irc_chan )
 {
  $query = 'INSERT INTO `teams`
            (`name`, `irc_server`, `irc_chan` ) VALUES
            ( ?, ?, ?);';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'sis', $name, $irc_server, $irc_chan );
   if( !$rpq->execute() )
   {
    return false;
   } else
    return true;
  } else
  {
   return false;
  }
 }

 public function get_list_teams_for_users()
 {
  $query = 'SELECT id, name
                  FROM teams
                  ORDER BY name';
  $return = array( );
  if( $result = $this->mysqli->query( $query ) )
  {
   while( $array = $result->fetch_object() )
   {
    $return[$array->id] = $array->name;
   }
   return $return;
  }
  else
  {
   return false;
  }
 }

// public function get_list_teams_for_users_selected( $id_user )
// {
//  $query = 'SELECT id
//                  FROM xdcc_team_user
//                  WHERE id_user = ?';
//  $return = array( );
//  if( $rpq = $this->mysqli->prepare( $query ) )
//  {
//   $rpq->bind_param( 'i', $id_user );
//   $rpq->bind_result( $id );
//   $rpq->execute();
//   while( $rpq->fetch() )
//   {
//    $return[] = $id;
//   }
//   return $return;
//  }
//  else
//  {
//   return false;
//  }
// }
 
 public function get_list_teams_for_xdccs_selected( $id_xdcc )
 {
  $query = 'SELECT id_team
            FROM `team_xdcc`
            WHERE id_xdcc = ?';
  $return = array( );
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'i', $id_xdcc );
   $rpq->bind_result( $id_team );
   $rpq->execute();
   while( $rpq->fetch() )
   {
    $return[] = $id_team;
   }
   return $return;
  }
  else
  {
   return false;
  }
 }

}

?>
