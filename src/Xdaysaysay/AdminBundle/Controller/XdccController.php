<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;

/**
 * Class XdccController
 * @package Xdaysaysay\AdminBundle\Controller
 */
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