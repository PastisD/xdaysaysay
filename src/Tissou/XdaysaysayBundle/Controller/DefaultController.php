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
        if(empty(self::$teams)) {
            self::$teams = $this->getDoctrine()
                ->getRepository('TissouXdaysaysayBundle:Team')
                ->findAll();
        }
        if(empty(self::$xdccNames)) {
            self::$xdccNames = $this->getDoctrine()
                ->getRepository('TissouXdaysaysayBundle:XdccName')
                ->findAll();
        }
    }

    public function setContainer(ContainerInterface $container = NULL)
    {
        parent::setContainer($container);
        $this->initialize();
    }

    public function getXdccNameAction($xdcc, $team)
    {
        $finalXdccName = new XdccName;
        foreach (self::$xdccNames as $xdccName) {
            if ($xdccName->getIrcServer() == $team->getIrcServer() && $xdccName->getXdcc() == $xdcc)
                $finalXdccName = $xdccName;
        }

        return $this->render("TissouXdaysaysayBundle:Default:xdccName.html.twig", ['xdccName' => $finalXdccName, 'xdcc' => $xdcc, 'team' => $team]);
    }

    /**
     * @Route("/", name="tissou_xdaysaysay_homepage")
     * @Template()
     */
    public function indexAction()
    {
        return ["teams" => self::$teams];
    }


    /**
     * @Route("/xdcc/{team_name},{id_team}/{xdcc_name},{id_xdcc}", name="tissou_xdaysaysay_xdcc", requirements={"id_team" = "\d+", "id_xdcc" = "\d+"}, defaults={"foo" = "bar"})
     * @Template()
     */
    public function xdccAction($id_team, $id_xdcc)
    {
        return ["teams" => self::$teams];
    }
}
