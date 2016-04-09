<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;

/**
 * Class TeamController
 * @package Xdaysaysay\AdminBundle\Controller
 */
class TeamController extends Controller
{
    use FormTrait;

    /**
     * TeamController constructor.
     */
    public function __construct()
    {
        $this->entityClassName = 'Xdaysaysay\CoreBundle\Entity\Team';
        $this->repositoryName = 'XdaysaysayCoreBundle:Team';
        $this->twigFormDirectory = 'XdaysaysayAdminBundle:Team';
        $this->formRoute = 'team';
        $this->translation = 'team';
        $this->formType = 'Xdaysaysay\AdminBundle\Form\Type\TeamType';
    }
}