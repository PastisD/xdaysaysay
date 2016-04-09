<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\Form\Type\IRCServerType;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;
use Xdaysaysay\CoreBundle\Entity\IRCServer;

class IRCServerController extends Controller
{
    use FormTrait;

    public $entityClassName = 'Xdaysaysay\CoreBundle\Entity\IRCServer';
    public $repositoryName = 'XdaysaysayCoreBundle:IRCServer';
    public $twigFormDirectory = 'XdaysaysayAdminBundle:IRCServer';
    public $formRoute = 'irc_server';
    public $translation = 'irc_server';
    public $formType = 'Xdaysaysay\AdminBundle\Form\Type\IRCServerType';
}