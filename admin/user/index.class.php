<?php

class index {

    private $template = null;

    public function __construct() {
        global $template;
        $this->template = &$template;
        $this->show();
    }

    private function show() {
    //$this->template->set_filenames(array('index' => 'intranet/index/index.tpl'));
	
//        if ($_SESSION['intranet_listing_xdcc']['is_admin']) {
//            $this->template->assign('REDIRECTOPTIONS', array(
//                'accueil' => 'Accueil',
//                'xdccs' => 'Xdccs',
//                'teams' => 'Teams',
//                'servers' => 'Serveurs',
//                'users' => 'Utilisateurs')
//            );
//        } else {
//            $this->template->assign('REDIRECTOPTIONS', array(
//                'accueil' => 'Accueil',
//                'xdccs' => 'Xdccs')
//            );
//        }
//        $this->template->assign('REDIRECTSELECTED',  $_SESSION['intranet_listing_xdcc']['redirect']);
        $this->template->assign('INDEX_SELECTED', ' class="selected"');
        $this->template->display('intranet/header.tpl');
        $this->template->display('intranet/index/index.tpl');
        $this->template->display('intranet/footer.tpl');
    }
}

?>
