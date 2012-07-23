<?php
$hostname = 'localhost';
$user = 'root';
$pass = 'root';
$database = 'xdaysaysay';

define('PATH', 'D:\UwAmp\www\xdaysaysay\admin');
define('URI', 'http://127.0.0.1/xdaysaysay/admin');
define('NB_ELEMENTS_PER_PAGE', 30 );

include(PATH . '/system/smarty/Smarty.class.php');

$template = new Smarty;
$template->compile_check = true;
//$template->debugging = true;
$template->template_dir = PATH . '/system/templates/tpls/';
$template->compile_dir = PATH . '/system/cache/';

$template->assign(array(
    'URI' => URI,
    'INDEX_SELECTED' => '',
    'XDCCS_SELECTED' => '',
    'TEAMS_SELECTED' => '',
    'USERS_SELECTED' => '')
);

$mysqli = new mysqli($hostname, $user, $pass, $database);
if ($mysqli->errno) {
    printf("Echec de la connexion à la base de donnée : %s\n", $mysqli->error());
    exit();
}

session_start();

if (isset($_SESSION['intranet_listing_xdcc']['is_admin']) && $_SESSION['intranet_listing_xdcc']['is_admin'] == '1') {
    $template->assign('is_admin', isset($_SESSION['intranet_listing_xdcc']['is_admin']) ? $_SESSION['intranet_listing_xdcc']['is_admin'] : false);
}

?>
