<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\Form\Type\ServerType;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;
use Xdaysaysay\CoreBundle\Entity\Server;

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