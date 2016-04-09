<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;

/**
 * Class IRCServerController
 * @package Xdaysaysay\AdminBundle\Controller
 */
class IRCServerController extends Controller
{
    use FormTrait;

    /**
     * IRCServerController constructor.
     */
    public function __construct()
    {
        $this->entityClassName = 'Xdaysaysay\CoreBundle\Entity\IRCServer';
        $this->repositoryName = 'XdaysaysayCoreBundle:IRCServer';
        $this->twigFormDirectory = 'XdaysaysayAdminBundle:IRCServer';
        $this->formRoute = 'irc_server';
        $this->translation = 'irc_server';
        $this->formType = 'Xdaysaysay\AdminBundle\Form\Type\IRCServerType';
    }
}