<?php
namespace Xdaysaysay\AdminBundle\EventListener;

// ...

use Avanzu\AdminThemeBundle\Model\MenuItemModel;
use Avanzu\AdminThemeBundle\Event\SidebarMenuEvent;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;

class BreadcrumbListener
{
    /**
     * @var TranslatorInterface
     */
    private $translator;
    /**
     * @var Request
     */
    private $request;

    public function __construct(TranslatorInterface $translator, RequestStack $request)
    {
        $this->translator = $translator;
        $this->request = $request->getMasterRequest();
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
            $xdcc = new MenuItemModel('xdcc_index', $this->translator->trans('admin.xdcc.breadcrumb.main', [], 'admin'), 'xdaysaysay_admin_xdcc_index'),
            $ircServer = new MenuItemModel('irc_server_index', $this->translator->trans('admin.irc_server.menu_title', [], 'admin'), 'xdaysaysay_admin_irc_server_index'),
            $server = new MenuItemModel('server_index', $this->translator->trans('admin.server.menu_title', [], 'admin'), 'xdaysaysay_admin_server_index'),
            $team = new MenuItemModel('team_index', $this->translator->trans('admin.team.menu_title', [], 'admin'), 'xdaysaysay_admin_team_index'),
            $user = new MenuItemModel('user_index', $this->translator->trans('admin.user.menu_title', [], 'admin'), 'xdaysaysay_admin_user_index'),
        ];
        $xdcc->addChild(new MenuItemModel('xdcc_new', $this->translator->trans('admin.xdcc.breadcrumb.new', [], 'admin'), 'xdaysaysay_admin_xdcc_new'));
        $xdcc->addChild(new MenuItemModel('xdcc_edit', $this->translator->trans('admin.xdcc.breadcrumb.edit', [], 'admin'), 'xdaysaysay_admin_xdcc_edit'));

        $ircServer->addChild(new MenuItemModel('irc_server_new', $this->translator->trans('admin.irc_server.breadcrumb.new', [], 'admin'), 'xdaysaysay_admin_irc_server_new'));
        $ircServer->addChild(new MenuItemModel('irc_server_edit', $this->translator->trans('admin.irc_server.breadcrumb.edit', [], 'admin'), 'xdaysaysay_admin_irc_server_edit'));

        $server->addChild(new MenuItemModel('server_new', $this->translator->trans('admin.server.breadcrumb.new', [], 'admin'), 'xdaysaysay_admin_server_new'));
        $server->addChild(new MenuItemModel('server_edit', $this->translator->trans('admin.server.breadcrumb.edit', [], 'admin'), 'xdaysaysay_admin_server_edit'));

        $team->addChild(new MenuItemModel('team_new', $this->translator->trans('admin.team.breadcrumb.new', [], 'admin'), 'xdaysaysay_admin_team_new'));
        $team->addChild(new MenuItemModel('team_edit', $this->translator->trans('admin.team.breadcrumb.edit', [], 'admin'), 'xdaysaysay_admin_team_edit'));

        $user->addChild(new MenuItemModel('user_new', $this->translator->trans('admin.user.breadcrumb.new', [], 'admin'), 'xdaysaysay_admin_user_new'));
        $user->addChild(new MenuItemModel('user_edit', $this->translator->trans('admin.user.breadcrumb.edit', [], 'admin'), 'xdaysaysay_admin_user_edit'));

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
            if (in_array($item->getRoute(), ['xdaysaysay_admin_irc_server_edit', 'xdaysaysay_admin_server_edit', 'xdaysaysay_admin_team_edit', 'xdaysaysay_admin_user_edit', 'xdaysaysay_admin_xdcc_edit'], true)) {
                $item->setRouteArgs(['id' => $this->request->get('id')]);
            }
            if ($item->hasChildren()) {
                $this->activateByRoute($route, $item->getChildren());
            } else if ($item->getRoute() === $route) {
                $item->setIsActive(true);
            }
        }

        return $items;
    }

}