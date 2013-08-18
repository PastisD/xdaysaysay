<?php
include_once(PATH . '/user/NavPages.class.php');
include_once(PATH . '/user/teams.class.php');
include_once(PATH . '/user/servers.class.php');

/**
 * Description of xdccsclass
 *
 * @author PastisD
 */
class xdccs
{

 private $template = null;
 private $mysqli = null;
 private $teams = null;
 private $servers = null;

 public function haveAccess( $mustBeAdmin = FALSE )
 {
  if( $mustBeAdmin )
   return (isset( $_SESSION['intranet_listing_xdcc'] ) && $_SESSION['intranet_listing_xdcc']['is_admin']);
  else
   return isset( $_SESSION['intranet_listing_xdcc'] );
 }

 public function __construct( $show = TRUE )
 {
  global $template;
  global $mysqli;

  if( !$this->haveAccess() )
   header( 'Location: ' . URI );

  $this->template = &$template;
  $this->mysqli = &$mysqli;
  $this->teams = new teams(FALSE);
  $this->servers = new servers(FALSE);

  if( $show )
  {
   $this->template->assign( 'XDCCS_SELECTED', ' class="selected"' );
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
      $this->template->assign( 'HEAD', 'Editer un xdcc' );
      $this->template->assign( 'ID', $_GET['id'] );
      $this->template->assign('TEAMS', $this->teams->get_list_teams_for_users());
      $this->template->assign('SERVERS', $this->servers->get_list_servers_for_xdccs());
      $this->template->assign('TEAMSSELECTED', $this->teams->get_list_teams_for_xdccs_selected($_GET['id']));
      $this->get_xdcc( $_GET['id'] );
      $return = $this->addEditXdcc();
      break;
     case 'add':
      $this->template->assign( 'MODE', 'add' );
      $this->template->assign( 'HEAD', 'Ajouter un nouveau xdcc' );
      $this->template->assign('TEAMS', $this->teams->get_list_teams_for_users());
      $this->template->assign('SERVERS', $this->servers->get_list_servers_for_xdccs());
      $return = $this->addEditXdcc();
      break;
     default:
      $return = $this->showListXdccs( $options );
    }
   }
   else
   {
    $return = $this->showListXdccs( $options );
   }

   $this->template->display( 'intranet/header.tpl' );
   echo $return;
   $this->template->display( 'intranet/footer.tpl' );
  }
 }
 
 private function showListXdccs( $options )
 {
  $return = $this->get_list_xdccs_table( $options );
  $this->template->assign( 'LIST_XDCCS', $return['html'] );
  return $this->template->fetch( 'intranet/xdccs/index.tpl' );
 }

 public function get_xdcc( $id )
 {
  $query = 'SELECT `id`, `id_server`, `url`, `show_on_listing` FROM `xdccs` WHERE `id` = ?';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( "i", $id );
   $rpq->bind_result( $id, $id_server, $url, $show_on_listing );
   $rpq->execute();
   if( $rpq->fetch() )
   {
    $this->template->assign( 'URL', $url );
    $this->template->assign( 'SHOW_ON_LISTING', ($show_on_listing == '1') ? ' checked=\'checked\'' : '' );
    $this->template->assign( 'SERVERSSELECTED', $id_server );
   }
  }
 }

 private function get_list_xdccs( $options = array( ), &$nbTotal )
 {
  $query = 'SELECT SQL_CALC_FOUND_ROWS DISTINCT x.*, xis.name_xdcc, t.name AS team_name, COUNT( p.id_pack ) AS nb_pack
                   FROM xdccs x
            LEFT JOIN team_xdcc tx ON ( x.id = tx.id_xdcc )
            LEFT JOIN teams t ON ( tx.id_team = t.id )
            LEFT JOIN xdcc_irc_server xis ON ( xis.id_xdcc = x.id )
            LEFT JOIN packs p ON ( p.id_xdcc = x.id )
            WHERE ( t.id_ircserver = xis.id_ircserver 
              OR xis.id_ircserver IS NULL ) '
          . ( $options["search-final"] !== NULL ? "AND CONCAT( xis.name_xdcc, ' ', t.name, ' ', x.url ) LIKE '%" . $options["search-final"] . "%' " : '' )
          . ' GROUP BY x.id'
          . ' ORDER BY ' . (isset( $options['order_by-final'] ) ? $options['order_by-final'] : 'id') . ' ' . (isset( $options['order-final'] ) ? $options['order-final'] : 'DESC')
          . ' LIMIT ' . (isset( $options['page-final'] ) ? (($options['page-final'] * NB_ELEMENTS_PER_PAGE - NB_ELEMENTS_PER_PAGE) . ', ' . NB_ELEMENTS_PER_PAGE) : '0, ' . NB_ELEMENTS_PER_PAGE);
//  echo $query;
  $return = array( );
  if( $result = $this->mysqli->query( $query ) )
  {
   while( $array = $result->fetch_object() )
   {
    $return[] = array(
        'id' => $array->id,
        'name' => $array->name_xdcc,
        'team_name' => $array->team_name,
        'nb_pack' => $array->nb_pack
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
   return FALSE;
  }
 }
 
 public function get_list_xdccs_table( $options = array( ) )
 {
  $this->controlOptionsForList( $options );
  $info_xdccs = $this->get_list_xdccs( $options, $nbTotal );
  $pagination = $this->getNavPages( $options, $nbTotal );
  $this->template->assign( 'INFOS_XDCCS', $info_xdccs );
  $this->template->assign( 'PAGINATION', $pagination );
  $this->template->assign( 'TOTAL_XDCCS', $nbTotal );
  return array( 'html' => $this->template->fetch( 'intranet/xdccs/listxdccs.tpl' ), 'pagination' => $pagination, 'nbTotal' => $nbTotal );
 }
 
 private function addEditXdcc()
 {
  return $this->template->fetch( 'intranet/xdccs/addeditxdcc.tpl' );
 }

 public function getNavPages( array $options, $nbTotal )
 {
//  echo '<pre>', print_r($options), '</pre>';
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
   case 'id':
    $options["order_by-final"] = "`id`";
    break;
   case 'nb_pack':
    $options["order_by-final"] = "`nb_pack`";
    break;
   case 'team':
    $options["order_by-final"] = "`team_name`";
    break;
   case 'xdcc':
    $options["order_by-final"] = "`name_xdcc`";
    break;
   default:
    $options["order_by-final"] = "`team_name` ASC, xis.name_xdcc";
  }

  // Recherche
  if( empty( $options["search"] ) || strlen( $options["search"] ) < 3 )
   $options["search-final"] = NULL;
  else
   $options["search-final"] = trim( $options["search"] );
 }
 
 public function editXdcc( $id, $id_server, $url, $show_on_listing, $teams )
 {
  $query = 'UPDATE `xdccs` SET `url` = ?,
                               `id_server` = ?,
                               `show_on_listing` = ?
                         WHERE `id`= ?;';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'sisi', $url, $id_server, $show_on_listing, $id );
   if( $rpq->execute() !== FALSE )
   {
    $query = 'DELETE FROM `team_xdcc` WHERE `id_xdcc` = ?;';
    if( $rpq = $this->mysqli->prepare( $query ) )
    {
     $rpq->bind_param( 'i', $id );
     if( $rpq->execute() !== FALSE )
     {
      $query = 'INSERT INTO `team_xdcc`
                (`id_xdcc`, `id_team` ) VALUES
                ( ?, ?);';
      if( $rpq = $this->mysqli->prepare( $query ) )
      {
       foreach( $teams as $team )
       {
        $rpq->bind_param( 'ii', $id, $team );
        $rpq->execute();
       }
       return TRUE;
      }
      else
       return TRUE;
     }
     else
       return FALSE;
    }
    else
     return FALSE;
   }
   else
    return TRUE;
  }
  else
   return FALSE;
  return TRUE;
 }
 
 public function delXdcc( $id )
 {
  $query = 'DELETE FROM `xdccs` WHERE `id` = ?;';

  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'i', $id );
   if( !$rpq->execute() )
    return FALSE;
   else
    return TRUE;
  }
  else
   return FALSE;
 }
 
 public function addXdcc( $id_server, $url, $show_on_listing, $teams )
 {
  $query = 'INSERT INTO `xdccs`
            (`id_server`, `url`, `show_on_listing` ) VALUES
            ( ?, ?, ?);';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'iss', $id_server, $url, $show_on_listing );
   if( $rpq->execute() !== FALSE )
   {
    $id = $rpq->insert_id;
    $query = 'INSERT INTO `team_xdcc`
              (`id_xdcc`, `id_team` ) VALUES
              ( ?, ?);';
    if( $rpq = $this->mysqli->prepare( $query ) )
    {
     foreach( $teams as $team )
     {
      $rpq->bind_param( 'ii', $id, $team );
      $rpq->execute();
     }
     return TRUE;
    }
    else
     return TRUE;
   }
   else
    return FALSE;
  }
  else
  {
   return FALSE;
  }
 }

}

?>
