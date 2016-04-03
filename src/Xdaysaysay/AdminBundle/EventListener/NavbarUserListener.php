<?php
namespace Xdaysaysay\AdminBundle\EventListener;

// ...

use Avanzu\AdminThemeBundle\Event\ShowUserEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Translation\TranslatorInterface;

class NavbarUserListener
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }

    public function onShowUser(ShowUserEvent $event)
    {
        $event->setUser($this->tokenStorage->getToken()->getUser());
    }

}