<?php

namespace Xdaysaysay\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('XdaysaysayCoreBundle:Default:index.html.twig');
    }
}
