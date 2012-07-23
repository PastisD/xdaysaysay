<?php

include_once('../../../system/config/config.php');


if( !empty($_POST) )
{
    if( isset($_POST['login'])
            && isset($_POST['password']) )
    {
        if( $rpq = $mysqli->prepare('SELECT `id`, `username`, `password`, `is_admin` FROM `user` WHERE `username` = ? AND `password` = MD5(?) AND is_active= "1"') )
        {
            $rpq->bind_param("ss", $_POST['login'], $_POST['password']);
            $rpq->bind_result($id_user, $username, $password, $is_admin);
            $rpq->execute();
            if( $rpq->fetch() )
            {
                if( !empty($id_user) && !empty($username) && !empty($password) )
                {
                    $_SESSION['intranet_listing_xdcc']['id_user'] = $id_user;
                    $_SESSION['intranet_listing_xdcc']['login'] = $username;
                    $_SESSION['intranet_listing_xdcc']['password'] = $password;
                    $_SESSION['intranet_listing_xdcc']['is_admin'] = ($is_admin = '1') ? true : false;
//                    $_SESSION['intranet_listing_xdcc']['redirect'] = $redirect;
                    echo json_encode(array('status' => true));
                }
                else
                {
                    echo json_encode(array('status' => false, 'error' => 'VIDE'));
                }
            }
            else
            {
                session_destroy();
                echo $mysqli->error;
                echo json_encode(array('status' => false, 'error' => 'problème fetch : ' . $mysqli->error));
            }
        }
        else
        {
            echo json_encode(array('status' => false, 'error' => 'problème prepare : ' . $mysqli->error));
        }
    }
    else
    {
        echo json_encode(array('status' => false, 'error' => 'problème POST'));
    }
}
else
{
    header('HTTP/1.1 404 Not Found');
    exit();
}
?>
