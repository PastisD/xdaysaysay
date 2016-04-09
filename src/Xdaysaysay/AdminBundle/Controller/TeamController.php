<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\Form\Type\TeamType;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;
use Xdaysaysay\CoreBundle\Entity\Team;

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