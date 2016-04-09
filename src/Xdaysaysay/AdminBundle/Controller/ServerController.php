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

    /**
     * ServerController constructor.
     */
    public function __construct()
    {
        $this->entityClassName = 'Xdaysaysay\CoreBundle\Entity\Server';
        $this->repositoryName = 'XdaysaysayCoreBundle:Server';
        $this->twigFormDirectory = 'XdaysaysayAdminBundle:Server';
        $this->formRoute = 'server';
        $this->translation = 'server';
        $this->formType = 'Xdaysaysay\AdminBundle\Form\Type\ServerType';
    }
}