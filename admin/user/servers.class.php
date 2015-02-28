<?php

include_once(PATH . '/user/NavPages.class.php');

/**
 * Description of serversclass
 *
 * @author PastisD
 */
class servers
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

  if( $show )
  {
   $this->template->assign( 'SERVERS_SELECTED', ' class="selected"' );
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
      $this->template->assign( 'HEAD', 'Editer un serveur' );
      $this->template->assign( 'ID', $_GET['id'] );
      $this->get_server( $_GET['id'] );
      $return = $this->addEditServer();
      break;
     case 'add':
      $this->template->assign( 'MODE', 'add' );
      $this->template->assign( 'HEAD', 'Ajouter un nouveau serveur' );
      $return = $this->addEditServer();
      break;
     default:
      $return = $this->showListServers( $options );
    }
   }
   else
   {
    $return = $this->showListServers( $options );
   }

   $this->template->display( 'intranet/header.tpl' );
   echo $return;
   $this->template->display( 'intranet/footer.tpl' );
  }
 }

 private function showListServers( $options )
 {
  $return = $this->get_list_servers_table( $options );
  $this->template->assign( 'LIST_SERVERS', $return['html'] );
  return $this->template->fetch( 'intranet/servers/index.tpl' );
 }

 public function get_server( $id )
 {
  $query = 'SELECT `id`, `alias`, `host`, `http_port`, `ssl` FROM `servers` WHERE `id` = ?';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( "i", $id );
   $rpq->bind_result( $id, $alias, $host, $http_port, $ssl );
   $rpq->execute();
   if( $rpq->fetch() )
   {
    $this->template->assign( 'ALIAS', $alias );
    $this->template->assign( 'HOST', $host );
    $this->template->assign( 'HTTP_PORT', $http_port );
    $this->template->assign( 'SSL_YES', ( $ssl == "yes" ? " checked=\"checked\"" : "" ) );
    $this->template->assign( 'SSL_NO', ( $ssl != "yes" ? " checked=\"checked\"" : "" ) );
   }
  }
 }

 public function get_list_servers( $options = array( ), &$nbTotal )
 {
  $query = 'SELECT SQL_CALC_FOUND_ROWS `id`, `alias`, `host`, `http_port`, `ssl`
                   FROM servers '
          . ( $options["search-final"] !== NULL ? "WHERE CONCAT( `host`, ' ', `alias` ) LIKE '%" . $options["search-final"] . "%' " : '' )
          . ' ORDER BY ' . (isset( $options['order_by-final'] ) ? $options['order_by-final'] : 'id') . ' ' . (isset( $options['order-final'] ) ? $options['order-final'] : 'DESC')
          . ' LIMIT ' . (isset( $options['page-final'] ) ? (($options['page-final'] * NB_ELEMENTS_PER_PAGE - NB_ELEMENTS_PER_PAGE) . ', ' . ($options['page-final'] * NB_ELEMENTS_PER_PAGE)) : '0, ' . NB_ELEMENTS_PER_PAGE);

  $return = array( );
  if( $result = $this->mysqli->query( $query ) )
  {
   while( $array = $result->fetch_object() )
   {
    $return[] = array(
        'id' => $array->id,
        'alias' => $array->alias,
        'host' => $array->host,
        'http_port' => $array->http_port,
        'ssl' => $array->ssl,
    );
   }

   $query = "SELECT FOUND_ROWS() AS `nbRows`;";
   if( ( $result2 = $this->mysqli->query( $query ) ) !== FALSE && $ligne = $result2->fetch_object() )
    $nbTotal = $ligne->nbRows;
   else
    $nbTotal = 0;

   return $return;
  } else
  {
   return false;
  }
 }

 public function get_list_servers_table( $options = array( ) )
 {
  $this->controlOptionsForList( $options );
  $info_servers = $this->get_list_servers( $options, $nbTotal );
  $pagination = $this->getNavPages( $options, $nbTotal );
  $this->template->assign( 'INFOS_SERVERS', $info_servers );
  $this->template->assign( 'PAGINATION', $pagination );
  $this->template->assign( 'TOTAL_SERVERS', $nbTotal );
  return array( 'html' => $this->template->fetch( 'intranet/servers/listservers.tpl' ), 'pagination' => $pagination, 'nbTotal' => $nbTotal );
 }

 private function addEditServer()
 {
  return $this->template->fetch( 'intranet/servers/addeditserver.tpl' );
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
   case 'alias':
    $options["order_by-final"] = "`alias`";
    break;
   case 'host':
    $options["order_by-final"] = "`host`";
    break;
   case 'http_port':
    $options["order_by-final"] = "`http_port`";
    break;
   case 'ssl':
    $options["order_by-final"] = "`ssl`";
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

 public function editServer( $id, $alias, $host, $http_port, $ssl )
 {
  $query = 'UPDATE `servers` SET
                         `alias` = ?,
                         `host` = ?,
                         `http_port` = ?,
                         `ssl` = ?
                   WHERE `id`= ?;';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'ssisi', $alias, $host, $http_port, $ssl, $id );
   if( !$rpq->execute() )
   {
    return false;
   }
   else
   {
    return true;
   }
  }
  else
  {
   return false;
  }
  return true;
 }

 public function delServer( $id )
 {
  $query = 'DELETE FROM `servers` WHERE `id` = ?;';

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

 public function addServer( $alias, $host, $http_port, $ssl )
 {
  $query = 'INSERT INTO `servers`
            (`alias`, `host`, `http_port`, `ssl` ) VALUES
            ( ?, ?, ?, ?);';
  if( $rpq = $this->mysqli->prepare( $query ) )
  {
   $rpq->bind_param( 'ssii', $alias, $host, $http_port, $ssl );
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
 
 public function get_list_servers_for_xdccs()
 {
  $query = 'SELECT id, alias, host
                  FROM servers
                  ORDER BY alias, host';
  $return = array( );
  if( $result = $this->mysqli->query( $query ) )
  {
   while( $array = $result->fetch_object() )
   {
    $return[$array->id] = $array->alias . " (" . $array->host . ")";
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
