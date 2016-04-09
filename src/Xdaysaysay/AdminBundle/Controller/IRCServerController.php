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

    public $entityClassName = 'Xdaysaysay\CoreBundle\Entity\IRCServer';
    public $repositoryName = 'XdaysaysayCoreBundle:IRCServer';
    public $twigFormDirectory = 'XdaysaysayAdminBundle:IRCServer';
    public $formRoute = 'irc_server';
    public $translation = 'irc_server';
    public $formType = 'Xdaysaysay\AdminBundle\Form\Type\IRCServerType';
}