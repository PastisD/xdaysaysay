<?php

include_once('../../../system/config/config.php');
include_once(PATH . '/user/users.class.php');

if( !isset( $_SESSION['intranet_listing_xdcc'] ) && !$_SESSION['intranet_listing_xdcc']['is_admin'] )
{
 header( "HTTP/1.1 404 Not Found" );
 exit();
}

if( !empty( $_POST ) && isset( $_POST['action_form'] ) )
{
 $user = new users( false );
 switch( $_POST['action_form'] )
 {
  case 'list':
   $breturn = array( );

   $options = array( "page" => 1, "order_by" => NULL, "order" => NULL, "search" => NULL );
   // Contrôle des paramètres
   if( isset( $_POST['page'] ) && !empty( $_POST['page'] ) )
    $options["page"] = $_POST['page'];
   if( isset( $_POST['order_by'] ) && !empty( $_POST['order_by'] ) )
    $options["order_by"] = $_POST['order_by'];
   if( isset( $_POST['order'] ) && !empty( $_POST['order'] ) )
    $options["order"] = $_POST['order'];
   if( isset( $_POST['search'] ) && !empty( $_POST['search'] ) )
    $options["search"] = $_POST['search'];

   $breturn['status'] = true;
   $return = $user->get_list_users_table( $options );
   $breturn['html'] = $return['html'];
   $breturn['navPages'] = $return['pagination'];
   $breturn['nbTotal'] = $return['nbTotal'];
   echo json_encode( $breturn );
   exit();
   break;
  case 'edit':
   $breturn = array( 'status' => false );
   if( isset( $_POST['id_user'] )
           && isset( $_POST['username'] )
           && isset( $_POST['email'] )
           && isset( $_POST['password'] ) )
   {
//    $breturn['status'] = $user->editUser($_POST['id_user'], $_POST['username'], $_POST['email'], isset( $_POST['isadmin'] ) ? $_POST['isadmin'] : '0', $_POST['password'], isset( $_POST['teams'] ) ? explode( ',', $_POST['teams'] ) : array( ) );
    $breturn['status'] = $user->editUser($_POST['id_user'], $_POST['username'], $_POST['email'], isset( $_POST['isadmin'] ) ? '1' : '0', $_POST['password'] );
    echo json_encode( $breturn );
   }
   else
   {
    echo json_encode( array_merge( $breturn, array( "message" => "erreur POST" ) ) );
   }
   exit();
   break;
  case 'add':
   $breturn = array( 'status' => false );
   if( isset( $_POST['username'] )
    && isset( $_POST['email'] )
    && isset( $_POST['password'] )
    && ( $_POST['password'] === $_POST['password_bis'] ))
   {
//    $breturn['status'] = $user->addUser( $_POST['username'], $_POST['email'], isset( $_POST['isadmin'] ) ? $_POST['isadmin'] : '0', $_POST['password'], isset( $_POST['teams'] ) ? explode( ',', $_POST['teams'] ) : array( ) );
    $breturn['status'] = $user->addUser( $_POST['username'], $_POST['email'], isset( $_POST['isadmin'] ) ? '1' : '0', $_POST['password'] );
    echo json_encode( $breturn );
   }
   else
   {
    echo json_encode( $breturn );
   }
   exit();
   break;
  case 'del':
   $breturn = array( 'status' => false );
   if( isset( $_POST['id_user'] ) )
   {
    $breturn['status'] = $user->delUser( $_POST['id_user'] );
    echo json_encode( $breturn );
   }
   else
   {
    echo json_encode( $breturn );
   }
   exit();
   break;
  default:
   header( "HTTP/1.1 404 Not Found" );
   exit();
 }
}
else
{
 header( "HTTP/1.1 404 Not Found" );
 exit();
}
?>
