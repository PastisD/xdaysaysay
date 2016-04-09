<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;

/**
 * Class ServerController
 * @package Xdaysaysay\AdminBundle\Controller
 */
class ServerController extends Controller
{
    use FormTrait;

    public $entityClassName = 'Xdaysaysay\CoreBundle\Entity\Server';
    public $repositoryName = 'XdaysaysayCoreBundle:Server';
    public $twigFormDirectory = 'XdaysaysayAdminBundle:Server';
    public $formRoute = 'server';
    public $translation = 'server';
    public $formType = 'Xdaysaysay\AdminBundle\Form\Type\ServerType';
}