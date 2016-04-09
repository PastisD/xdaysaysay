<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\Form\Type\XdccType;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;
use Xdaysaysay\CoreBundle\Entity\Xdcc;

class XdccController extends Controller
{
    use FormTrait;

    public $entityClassName = 'Xdaysaysay\CoreBundle\Entity\Xdcc';
    public $repositoryName = 'XdaysaysayCoreBundle:Xdcc';
    public $twigFormDirectory = 'XdaysaysayAdminBundle:Xdcc';
    public $formRoute = 'xdcc';
    public $translation = 'xdcc';
    public $formType = 'Xdaysaysay\AdminBundle\Form\Type\XdccType';
}