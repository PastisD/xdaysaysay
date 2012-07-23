<?php
include_once('../../../system/config/config.php');
include_once(PATH . '/user/ircservers.class.php');

if (!isset($_SESSION['intranet_listing_xdcc']) && !$_SESSION['intranet_listing_xdcc']['is_admin'])
{
    header("HTTP/1.1 404 Not Found");
    exit();
}

if (!empty($_POST) && isset($_POST['action_form'])) {
    $ircservers = new ircservers(false);
    switch ($_POST['action_form']) {
        case 'list':
            $breturn = array();

            $options = array( "page" => 1, "order_by" => NULL, "order" => NULL, "search" => NULL );
            // Contrôle des paramètres
            if( isset( $_POST['page'] ) && !empty( $_POST['page'] ) )         $options["page"] = $_POST['page'];
            if( isset( $_POST['order_by'] ) && !empty( $_POST['order_by'] ) ) $options["order_by"] = $_POST['order_by'];
            if( isset( $_POST['order'] ) && !empty( $_POST['order'] ) )       $options["order"] = $_POST['order'];
            if( isset( $_POST['search'] ) && !empty( $_POST['search'] ) )     $options["search"] = $_POST['search'];

            $breturn['status'] = true;
            $return = $ircservers->get_list_irc_servers_table($options);
            $breturn['html'] = $return['html'];
            $breturn['navPages'] = $return['pagination'];
            $breturn['nbTotal'] = $return['nbTotal'];
            echo json_encode($breturn);
            exit();
            break;
        case 'edit':
            $breturn = array('status' => false);
            if (isset($_POST['id'])
             && isset($_POST['name'])
             && isset($_POST['host'])
             && isset($_POST['port'])
             && isset($_POST['port_ssl'])
             && isset($_POST['website'])) {
                $breturn['status'] = $ircservers->editIrcServer(
                    $_POST['id'],
                    $_POST['name'],
                    $_POST['host'],
                    $_POST['port'],
                    $_POST['port_ssl'],
                    $_POST['website']
                );
                echo json_encode($breturn);
            }
            else {
                echo json_encode($breturn);
            }
            exit();
            break;
        case 'add':
            $breturn = array('status' => false);
            if (isset($_POST['name'])
             && isset($_POST['host'])
             && isset($_POST['port'])
             && isset($_POST['port_ssl'])
             && isset($_POST['website'])) {
                $breturn['status'] = $ircservers->addIrcServer(
                    $_POST['name'],
                    $_POST['host'],
                    $_POST['port'],
                    $_POST['port_ssl'],
                    $_POST['website']
                );
                echo json_encode($breturn);
            }
            else {
                echo json_encode($breturn);
            }
            exit();
            break;
        case 'del':
            $breturn = array('status' => false);
            if (isset($_POST['id'])) {
                $breturn['status'] = $ircservers->delIrcServer($_POST['id']);
                echo json_encode($breturn);
            }
            else {
                echo json_encode($breturn);
            }
            exit();
            break;
        default:
            header("HTTP/1.1 404 Not Found");
            exit();
    }
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}

?>
