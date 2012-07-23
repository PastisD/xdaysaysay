<?php
include_once('./system/config/config.php');

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['intranet_listing_xdcc']);
}

if (!isset($_SESSION['intranet_listing_xdcc'])) {
    $template->display('login/login.tpl');
} else {
    //$template->set_filenames(array('header' => 'intranet/header.tpl', 'footer' => 'intranet/footer.tpl'));

    if (isset($_GET['mode']) && file_exists(PATH . '/user/' . $_GET['mode'] . '.class.php')) {
        include_once(PATH . '/user/' . $_GET['mode'] . '.class.php');
        $class = new $_GET['mode'];
    } else {
        include_once(PATH . '/user/index.class.php');
        $class = new index;
    }
}

?>
