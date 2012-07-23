<?php
include_once('../../../system/config/config.php');

if (!empty($_POST)) {
    if (isset($_POST['redirect'])
        && !empty($_POST['redirect'])
        && isset($_SESSION['intranet_listing_xdcc']['id_user'])) {
        if ($rpq = $mysqli->prepare('UPDATE `users` SET `redirect` = ? WHERE `id_user` = ?')) {
            $rpq->bind_param("si", $_POST['redirect'], $_SESSION['intranet_listing_xdcc']['id_user']);
            if (!$rpq->execute()) {
                echo json_encode(array("status" => false));
            } else{
                $_SESSION['intranet_listing_xdcc']['redirect'] = $_POST['redirect'];
                echo json_encode(array("status" => true));
            }
        }
    }
    else {
        echo json_encode(array("status" => false));
    }
} else {
    header("HTTP/1.1 404 Not Found");
    exit();
}

?>
