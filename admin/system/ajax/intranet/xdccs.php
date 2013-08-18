<?php

include_once('../../../system/config/config.php');
include_once(PATH . '/user/xdccs.class.php');

if( !isset( $_SESSION['intranet_listing_xdcc'] ) )
{
 header( "HTTP/1.1 404 Not Found" );
 exit();
}

if( !empty( $_POST ) && isset( $_POST['action_form'] ) )
{
 $xdccs = new xdccs( false );
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
   $return = $xdccs->get_list_xdccs_table( $options );
   $breturn['html'] = $return['html'];
   $breturn['navPages'] = $return['pagination'];
   $breturn['nbTotal'] = $return['nbTotal'];
   echo json_encode( $breturn );
   exit();
   break;
  case 'edit':
   $breturn = array( 'status' => false );
   if( isset( $_POST['id'] )
    && isset( $_POST['url'] )
    && isset( $_POST['id_server'] ) )
   {
    $breturn['status'] = $xdccs->editXdcc( $_POST['id'], $_POST['id_server'], $_POST['url'], isset( $_POST['show_on_listing'] ) ? '1' : '0', isset( $_POST['teams'] ) ? explode( ',', $_POST['teams'] ) : array( )  );
    echo json_encode( $breturn );
   }
   else
   {
    echo json_encode( $breturn );
   }
   exit();
   break;
  case 'add':
   $breturn = array( 'status' => false );
   if( isset( $_POST['url'] )
    && isset( $_POST['id_server'] ) )
   {
    $breturn['status'] = $xdccs->addXdcc( $_POST['id_server'], $_POST['url'], isset( $_POST['show_on_listing'] ) ? '1' : '0', isset( $_POST['teams'] ) ? explode( ',', $_POST['teams'] ) : array( ) );
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
   if( isset( $_POST['id_xdcc'] ) )
   {
    $breturn['status'] = $xdccs->delXdcc( $_POST['id_xdcc'] );
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
