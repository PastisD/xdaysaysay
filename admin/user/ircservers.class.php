<?php

include_once(PATH . '/user/NavPages.class.php');

/**
 * Description of ircserversclass
 *
 * @author PastisD
 */
class ircservers
{

    private $template = null;
    private $mysqli = null;

    private function haveAccess()
    {
        return (isset($_SESSION['intranet_listing_xdcc']) && $_SESSION['intranet_listing_xdcc']['is_admin']);
    }

    public function __construct($show = true)
    {
        global $template;
        global $mysqli;

        if( !$this->haveAccess() )
            header('Location: ' . URI);

        $this->template = &$template;
        $this->mysqli = &$mysqli;

        if( $show )
        {
            $this->template->assign('IRC_SERVERS_SELECTED', ' class="selected"');
            $options = array("page" => 1, "order_by" => NULL, "order" => NULL, "search" => NULL);
            // Contrôle des paramètres
            if( isset($_GET['p']) && !empty($_GET['p']) )
                $options["page"] = $_GET['p'];
            if( isset($_GET['ob']) && !empty($_GET['ob']) )
                $options["order_by"] = $_GET['ob'];
            if( isset($_GET['o']) && !empty($_GET['o']) )
                $options["order"] = $_GET['o'];
            if( isset($_GET['search']) && !empty($_GET['search']) )
                $options["search"] = $_GET['search'];

            if( isset($_GET['action']) )
            {
                switch( $_GET['action'] )
                {
                    case 'edit':
                        $this->template->assign('MODE', 'edit');
                        $this->template->assign('HEAD', 'Editer un serveur IRC');
                        $this->template->assign('ID', $_GET['id']);
                        $this->get_irc_server($_GET['id']);
                        $return = $this->addEditIrcServer();
                        break;
                    case 'add':
                        $this->template->assign('MODE', 'add');
                        $this->template->assign('HEAD', 'Ajouter un nouveau serveur IRC');
                        $return = $this->addEditIrcServer();
                        break;
                    default:
                        $return = $this->showListIrcServers($options);
                }
            }
            else
            {
                $return = $this->showListIrcServers($options);
            }

            $this->template->display('intranet/header.tpl');
            echo $return;
            $this->template->display('intranet/footer.tpl');
        }
    }

    private function showListIrcServers($options)
    {
        $return = $this->get_list_irc_servers_table($options);
        $this->template->assign('LIST_IRC_SERVERS', $return['html']);
        return $this->template->fetch('intranet/ircservers/index.tpl');
    }

    public function get_irc_server($id)
    {
        $query = 'SELECT `id`, `name`, `host`, `port`, `port_ssl`, `website` FROM `irc_servers` WHERE `id` = ?';
        if( $rpq = $this->mysqli->prepare($query) )
        {
            $rpq->bind_param("i", $id);
            $rpq->bind_result($id, $name, $host, $port, $port_ssl, $website);
            $rpq->execute();
            if( $rpq->fetch() )
            {
                $this->template->assign('HOST', $host);
                $this->template->assign('NAME', $name);
                $this->template->assign('PORT', $port);
                $this->template->assign('PORT_SSL', $port_ssl);
                $this->template->assign('WEBSITE', $website);
            }
        }
    }

    public function get_list_irc_servers($options = array(), &$nbTotal)
    {
        $query = 'SELECT SQL_CALC_FOUND_ROWS `id`, `name`, `host`, `port`, `port_ssl`, `website`
                  FROM irc_servers '
                . ( $options["search-final"] !== NULL ? "WHERE CONCAT( `host`, ' ', `name`  ) LIKE '%" . $options["search-final"] . "%' " : '' )
                . ' ORDER BY ' . (isset($options['order_by-final']) ? $options['order_by-final'] : 'name') . ' ' . (isset($options['order-final']) ? $options['order-final'] : 'DESC')
                . ' LIMIT ' . (isset($options['page-final']) ? (($options['page-final'] * NB_ELEMENTS_PER_PAGE - NB_ELEMENTS_PER_PAGE) . ', ' . ($options['page-final'] * NB_ELEMENTS_PER_PAGE)) : '0, ' . NB_ELEMENTS_PER_PAGE);
//        echo $query;
        $return = array();
        if( $result = $this->mysqli->query($query) )
        {
            while( $array = $result->fetch_object() )
            {
                $return[] = array(
                    'id' => $array->id,
                    'name' => $array->name,
                    'host' => $array->host,
                    'port' => $array->port,
                    'port_ssl' => $array->port_ssl,
                    'website' => $array->website,
                );
            }

            $query = "SELECT FOUND_ROWS() AS `nbRows`;";
            if( ( $result2 = $this->mysqli->query($query) ) !== FALSE && $ligne = $result2->fetch_object() )
                $nbTotal = $ligne->nbRows;
            else
                $nbTotal = 0;

            return $return;
        } else
        {
            return false;
        }
    }

    public function get_list_irc_servers_table($options = array())
    {
        $this->controlOptionsForList($options);
        $info_irc_servers = $this->get_list_irc_servers($options, $nbTotal);
        $pagination = $this->getNavPages($options, $nbTotal);
        $this->template->assign('INFOS_IRC_SERVER', $info_irc_servers);
        $this->template->assign('PAGINATION', $pagination);
        $this->template->assign('TOTAL_IRC_SERVERS', $nbTotal);
        return array('html' => $this->template->fetch('intranet/ircservers/listircservers.tpl'), 'pagination' => $pagination, 'nbTotal' => $nbTotal);
    }

    private function addEditIrcServer()
    {
        return $this->template->fetch('intranet/ircservers/addeditircserver.tpl');
    }

    public function getNavPages(array $options, $nbTotal)
    {
        return NavPages::getNavPages($nbTotal, NB_ELEMENTS_PER_PAGE, "./index-%i" . (!empty($options["order_by-final"]) ? "-" . $options["order_by-final"] : "" ) . (!empty($options["order-final"]) ? "-" . $options["order-final"] : "" ) . ".html" . (!is_null($options["search-final"]) ? "?search=" . urlencode($options["search-final"]) : "" ), $options["page-final"], "movePage(%i); return false;");
    }

    private function controlOptionsForList(array &$options)
    {
        // Page

        if( !is_numeric($options["page"]) || $options["page"] < 1 )
            $options["page-final"] = 1;
        else
            $options["page-final"] = intval($options["page"]);

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
            case 'id':
                $options["order_by-final"] = "`id`";
                break;
            case 'name':
                $options["order_by-final"] = "`name`";
                break;
            case 'host':
                $options["order_by-final"] = "`host`";
                break;
            case 'port':
                $options["order_by-final"] = "`port`";
                break;
            case 'port_ssl':
                $options["order_by-final"] = "`port_ssl`";
                break;
            case 'website':
                $options["order_by-final"] = "`website`";
                break;
            default:
                $options["order_by-final"] = "`name`";
        }

        // Recherche
        if( empty($options["search"]) || strlen($options["search"]) < 3 )
            $options["search-final"] = NULL;
        else
            $options["search-final"] = trim($options["search"]);
    }

    public function editIrcServer($irc_idserver, $name, $host, $port, $port_ssl, $website)
    {
        $query = 'UPDATE `irc_servers` SET
                         `name` = ?,
                         `host` = ?,
                         `port` = ?,
                         `port_ssl` = ?,
                         `website` = ?
                   WHERE `id`= ?;';
        if( $rpq = $this->mysqli->prepare($query) )
        {
            $rpq->bind_param('ssiisi', $name, $host, $port, $port_ssl, $website, $irc_idserver);
            if( !$rpq->execute() )
                return false;
            else
                return true;
        }
        else
            return false;
        return true;
    }

    public function delIrcServer($id)
    {
        $query = 'DELETE FROM `irc_servers` WHERE `id` = ?;';

        if( $rpq = $this->mysqli->prepare($query) )
        {
            $rpq->bind_param('i', $id);
            if( !$rpq->execute() )
                return false;
            else
                return true;
        }
        else
            return false;
    }

    public function addIrcServer($name, $host, $port, $port_ssl, $website)
    {
        $query = 'INSERT INTO `irc_servers`
            (`name`, `host`, `port`, `port_ssl`, `website` ) VALUES
            ( ?, ?, ?, ?, ?);';
        if( $rpq = $this->mysqli->prepare($query) )
        {
            $rpq->bind_param('ssiis', $name, $host, $port, $port_ssl, $website);
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

    public function get_list_irc_servers_for_teams()
    {
        $query = 'SELECT `id`, `name`
                  FROM `irc_servers`
                  ORDER BY name';
        $return = array();
        if( $result = $this->mysqli->query($query) )
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

}

?>
