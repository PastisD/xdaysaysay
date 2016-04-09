<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;

class TeamController extends Controller
{
    use FormTrait;

    public $entityClassName = 'Xdaysaysay\CoreBundle\Entity\Team';
    public $repositoryName = 'XdaysaysayCoreBundle:Team';
    public $twigFormDirectory = 'XdaysaysayAdminBundle:Team';
    public $formRoute = 'team';
    public $translation = 'team';
    public $formType = 'Xdaysaysay\AdminBundle\Form\Type\TeamType';
}