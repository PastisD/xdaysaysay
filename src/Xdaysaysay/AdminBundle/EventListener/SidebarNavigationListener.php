<?php
namespace Xdaysaysay\AdminBundle\EventListener;

// ...

use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\TranslatorInterface;

class SidebarNavigationListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    public function onSetupMenu(SidebarMenuEvent $event)
    {
        $request = $event->getRequest();

        foreach ($this->getMenu($request) as $item) {
            $event->addItem($item);
        }

    }

    protected function getMenu(Request $request)
    {
        // Build your menu here by constructing a MenuItemModel array
        $menuItems = [
            new MenuItemModel('xdcc_index', $this->translator->trans('admin.xdcc.menu_title', [], 'admin'), 'xdaysaysay_admin_xdcc_index', [], 'iconclasses fa fa-plane'),
            new MenuItemModel('irc_server_index', $this->translator->trans('admin.irc_server.menu_title', [], 'admin'), 'xdaysaysay_admin_irc_server_index', [], 'iconclasses fa fa-plane'),
            new MenuItemModel('server_index', $this->translator->trans('admin.server.menu_title', [], 'admin'), 'xdaysaysay_admin_server_index', [], 'iconclasses fa fa-server'),
            new MenuItemModel('team_index', $this->translator->trans('admin.team.menu_title', [], 'admin'), 'xdaysaysay_admin_team_index', [], 'iconclasses fa fa-plane'),
            new MenuItemModel('user_index', $this->translator->trans('admin.user.menu_title', [], 'admin'), 'xdaysaysay_admin_user_index', [], 'iconclasses fa fa-plane'),
        ];

        return $this->activateByRoute($request->get('_route'), $menuItems);
    }

    /**
     * @param $route
     * @param MenuItemModel[] $items
     *
     * @return MenuItemModel[] mixed
     */
    protected function activateByRoute($route, $items)
    {
        foreach ($items as $item) {
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else if ($item->getRoute() == $route) {
                $item->setIsActive(true);
            }
        }

        return $items;
    }

}