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

    /**
     * XdccController constructor.
     */
    public function __construct()
    {
        $this->entityClassName = 'Xdaysaysay\CoreBundle\Entity\Xdcc';
        $this->repositoryName = 'XdaysaysayCoreBundle:Xdcc';
        $this->twigFormDirectory = 'XdaysaysayAdminBundle:Xdcc';
        $this->formRoute = 'xdcc';
        $this->translation = 'xdcc';
        $this->formType = 'Xdaysaysay\AdminBundle\Form\Type\XdccType';
    }
}