<?php
namespace Xdaysaysay\AdminBundle\EventListener;

// ...

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;

class NavbarUserListener
{

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TranslatorInterface $translator, TokenStorageInterface $tokenStorage)
    {
        $this->translator = $translator;
        $this->tokenStorage = $tokenStorage;
    }

    public function onShowUser(ShowUserEvent $event)
    {
        $event->setUser($this->tokenStorage->getToken()->getUser());
    }

}