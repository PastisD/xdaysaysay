<?php

include_once(PATH . '/user/NavPages.class.php');
include_once(PATH . '/user/teams.class.php');

/**
 * Description of usersclass
 *
 * @author PastisD
 */
class users
{

 private $teams = null;
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
  $this->teams = new teams( false );

  $this->template->assign( 'USERS_SELECTED', ' class="selected"' );
  if( $show )
  {
   // $this->template->assign('USERS_SELECTED', ' class="selected"');

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
      $this->template->assign( 'HEAD', 'Editer un utilisateur' );
      $this->template->assign( 'ID_USER', $_GET['id'] );
//      $this->template->assign( 'TEAMS', $this->teams->get_list_teams_for_users() );
//      $this->template->assign( 'TEAMSSELECTED', $this->teams->get_list_teams_for_users_selected( $_GET['id'] ) );
      $this->get_user( $_GET['id'] );
      $return = $this->addEditUser();
      break;
     case 'add':
      $this->template->assign( 'MODE', 'add' );
      $this->template->assign( 'HEAD', 'Ajouter un nouvel utilisateur' );
//      $this->template->assign( 'TEAMS', $this->teams->get_list_teams_for_users() );
      $return = $this->addEditUser();
      break;
     default:
      $return = $this->showListUsers( $options );
    }
   }
   else
   {
    $return = $this->showListUsers( $options );
   }

   $this->template->display( 'intranet/header.tpl' );
   echo $return;
   $this->template->display( 'intranet/footer.tpl' );
  }
 }

 private function showListUsers( $options )
 {
  $return = $this->get_list_users_table( $options );
  $this->template->assign( 'LIST_USERS', $return['html'] );
  return $this->template->fetch( 'intranet/users/index.tpl' );
 }

 public function get_user( $id )
 {
  $query = 'SELECT `id`, `username`, `password`, `email`, `is_admin` FROM `user` WHERE `id` = ?';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( "i", $id );
   $rpq->bind_result( $id_user, $username, $password, $email, $is_admin );
   $rpq->execute();
   if( $rpq->fetch() )
   {
    $this->template->assign( 'USERNAME', $username );
    $this->template->assign( 'EMAIL', $email );
    $this->template->assign( 'ISADMIN', ($is_admin == '1') ? ' checked=\'checked\'' : '' );
   }
  }
 }

 public function get_list_users( $options = array( ), &$nbTotal )
 {
  $query = 'SELECT SQL_CALC_FOUND_ROWS `id`, `username`, `is_admin`, `email`
                  FROM user '
          . ( $options["search-final"] !== NULL ? "WHERE CONCAT( `login`, ' ', `email` ) LIKE '%" . $options["search-final"] . "%' " : '' )
          . ' ORDER BY ' . (isset( $options['order_by-final'] ) ? $options['order_by-final'] : 'id') . ' ' . (isset( $options['order-final'] ) ? $options['order-final'] : 'DESC')
          . ' LIMIT ' . (isset( $options['page-final'] ) ? (($options['page-final'] * NB_ELEMENTS_PER_PAGE - NB_ELEMENTS_PER_PAGE) . ', ' . ($options['page-final'] * NB_ELEMENTS_PER_PAGE)) : '0, ' . NB_ELEMENTS_PER_PAGE);
  $return = array( );
  if( $result = $this->mysqli->query( $query ) )
  {
   while( $array = $result->fetch_object() )
   {
    $return[] = array(
        'id' => $array->id,
        'username' => $array->username,
        'email' => $array->email,
        'is_admin' => $array->is_admin
    );
   }

   $query = "SELECT FOUND_ROWS() AS `nbRows`;";
   if( ( $result2 = $this->mysqli->query( $query ) ) !== FALSE && $ligne = $result2->fetch_object() )
    $nbTotal = $ligne->nbRows;
   else
    $nbTotal = 0;

//            echo '<pre>', print_r($return), '</pre>';
   return $return;
  } else
  {
   echo $this->mysqli->error;
   return false;
  }
 }

 public function get_list_users_table( $options = array( ) )
 {
  $this->controlOptionsForList( $options );
  $info_users = $this->get_list_users( $options, $nbTotal );
  $pagination = $this->getNavPages( $options, $nbTotal );
  $this->template->assign( 'INFOS_USER', $info_users );
  $this->template->assign( 'PAGINATION', $pagination );
  $this->template->assign( 'TOTAL_USERS', $nbTotal );
  return array( 'html' => $this->template->fetch( 'intranet/users/listusers.tpl' ), 'pagination' => $pagination, 'nbTotal' => $nbTotal );
 }

 private function addEditUser()
 {
  return $this->template->fetch( 'intranet/users/addedituser.tpl' );
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
    $options["order-final"] = "DESC";
  }

  // Order by
  switch( $options["order_by"] )
  {
   case 'login':
    $options["order_by-final"] = "`username`";
    break;
   case 'id_user':
    $options["order_by-final"] = "`id`";
    break;
   case 'email':
    $options["order_by-final"] = "`email`";
    break;
   case 'is_admin':
    $options["order_by-final"] = "`is_admin`";
    break;
   default:
    $options["order_by-final"] = "`id`";
  }

  // Recherche
  if( empty( $options["search"] ) || strlen( $options["search"] ) < 3 )
   $options["search-final"] = NULL;
  else
   $options["search-final"] = trim( $options["search"] );
 }

// public function editUser( $id_user, $username, $email, $is_admin, $password, Array $teams )
 public function editUser( $id_user, $username, $email, $is_admin, $password )
 {
  if( !empty( $password ) )
  {
   $query = 'UPDATE `user`SET
                             `username` = ?,
                             `email` = ?,
                             `is_admin` = ?,
                             `password` = ?
                       WHERE `id`= ?;';

   if( $rpq = $this->mysqli->prepare( $query ) )
   {
    $password = md5($password);
    $rpq->bind_param( 'ssssi', $username, $email, $is_admin, $password, $id_user );
    if( !$rpq->execute() )
     return $this->mysqli->error;
    else
    {
     return true;
    }
   }
   else
    return $this->mysqli->error;
   return true;
  }
  else
  {
   $query = 'UPDATE `user`SET
                             `username` = ?,
                             `email` = ?,
                             `is_admin` = ?
                       WHERE `id`= ?;';

   if( $rpq = $this->mysqli->prepare( $query ) )
   {
    $rpq->bind_param( 'sssi', $username, $email, $is_admin, $id_user );
    if( !$rpq->execute() )
     return $this->mysqli->error;
    else
    {
     return true;
    }
   }
   else
    return $this->mysqli->error;
   return true;
  }
 }

 public function delUser( $id_user )
 {
  $query = 'DELETE FROM `user` WHERE `id` = ?;';

  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'i', $id_user );
   if( !$rpq->execute() )
    return false;
   else
    return true;
  }
  else
   return false;
 }

// public function addUser( $username, $email, $is_admin, $password, Array $teams )
 public function addUser( $username, $email, $is_admin, $password )
 {
  $query = 'INSERT INTO `user`
            (`username`, `email`, `is_admin`, `password` )VALUES
            ( ?, ?, ?, ?);';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $password = md5($password);
   $rpq->bind_param( 'ssss', $username, $email, $is_admin, $password );
   if( !$rpq->execute() )
   {
    return false;
   }
   else
   {
//    $this->insert_user_team( $this->mysqli->insert_id, $teams );
    return true;
   }
  }
  else
  {
   return false;
  }
 }

// private function insert_user_team( $id_user, Array $teams )
// {
//  $query = 'DELETE FROM xdcc_team_user WHERE id_user = ?';
//  if( $rpq = $this->mysqli->prepare( $query ) )
//  {
//   $rpq->bind_param( "i", $id_user );
//   if( $rpq->execute() === FALSE )
//   {
//    return $this->mysqli->error;
//   }
//  }
//  else
//  {
//   return $this->mysqli->error;
//   ;
//  }
//
//  $query = 'INSERT INTO `xdcc_team_user`
//            (`id_user`, `id_team`)VALUES
//            (?, ?);';
//  if( $rpq = $this->mysqli->prepare( $query ) )
//  {
//   foreach( $teams as $team )
//   {
//    $rpq->bind_param( "ii", $id_user, $team );
//    if( $rpq->execute() === FALSE )
//    {
//     return $this->mysqli->error;
//    }
//   }
//  }
//  else
//  {
//   return $this->mysqli->error;
//   ;
//  }
// }

}

?>
