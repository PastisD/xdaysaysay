<?php

namespace Tissou\XdaysaysayBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Tissou\XdaysaysayBundle\Entity\IRCServer;
use Tissou\XdaysaysayBundle\Entity\Xdcc;
use Tissou\XdaysaysayBundle\Entity\XdccName;

class DefaultController extends Controller
{
    private static $teams = [];
    private static $xdccNames = [];
    private function initialize()
    {
        if(empty(self::$teams))
        {
            self::$teams = $this->getDoctrine()
                ->getRepository('TissouXdaysaysayBundle:Team')
                ->findAll();
        }
        if(empty(self::$xdccNames))
        {
            self::$xdccNames = $this->getDoctrine()
                ->getRepository('TissouXdaysaysayBundle:XdccName')
                ->findAll();
        }
    }

    public function setContainer(ContainerInterface $container = NULL) {
        parent::setContainer($container);
        $this->initialize();
    }

    public function getXdccNameAction($ircServer, $xdcc)
    {
        $finalXdccName = new XdccName();
        foreach(self::$xdccNames as $xdccName)
        {
            if($xdccName->getIrcServer() == $ircServer && $xdccName->getXdcc() == $xdcc)
                $finalXdccName = $xdccName;
        }

        return $this->render("TissouXdaysaysayBundle:Default:xdccName.html.twig", array('xdccName' => $finalXdccName));
    }

    /**
     * @Route("/", name="home")
     * @Template()
     */
    public function indexAction()
    {
        return ["teams" => self::$teams];
    }
}
