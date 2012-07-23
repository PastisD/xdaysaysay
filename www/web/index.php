<?php
 include('./system/header.php');

 $mode = isset( $_GET['mode'] ) ? $_GET['mode'] : NULL;
// echo '<pre>', print_r($mode), '</pre>';
 switch( $mode )
 {
  case 'xdcc':
   include('./system/pages/xdcc.php');
   break;
  case 'search':
   include('./system/pages/search.php');
   break;
  case 'index':
  default:
   include('./system/pages/index.php');
   break;
 }

 include('./system/footer.php');
?>
