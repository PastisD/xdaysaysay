<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;
use Xdaysaysay\CoreBundle\Entity\Xdcc;

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


    /**
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function datatableDataAction(Request $request)
    {
        $params = $request->query->all();

        $draw = $params['draw'];
        $limit = $params['length'];
        $offset = $params['start'];
        $orderBy = [$params['columns'][$params['order'][0]['column']]['name'], $params['order'][0]['dir']];
        $criteria = explode(' ', $params['search']['value']);

        $columnSearch = [];
        foreach ($params['columns'] as $column) {
            if (!empty($column['search']['value'])) {
                $columnSearch[$column['name']] = $column['search'];
            }
        }

        $em = $this->getDoctrine()->getManager();

        $items = $em->getRepository('XdaysaysayCoreBundle:Xdcc')->findLike($criteria, $orderBy, $limit, $offset, false, $columnSearch);

        $datas = [];
        $translator = $this->get('translator');
        foreach ($items as $item) {
            $teams = $item->getTeams();
            $teamFinalNames = [];
            foreach($teams as $team) {
                $teamFinalNames[] = $team->getName();
            }

            $xdccNames = $item->getXdccnames();
            $xdccFinalNames = [];
            foreach($xdccNames as $xdccName) {
                $xdccFinalNames[] = $xdccName->getName();
            }

            $datas[] = [
                $item->getId(),
                implode('<br>', $teamFinalNames),
                $item->getServer()->getName(),
                implode('<br>', $xdccFinalNames),
                count($item->getPacks()),
                $item->getVisible() ? $translator->trans('admin.common.yes', [], 'admin') : $translator->trans('admin.common.no', [], 'admin'),
                '<a href="'.$this->generateUrl('xdaysaysay_admin_xdcc_edit', ['id' => $item->getId()]).'" class="btn btn-primary">'.$translator->trans('admin.common.action.edit', [], 'admin').'</a>
                 <a href="'.$this->generateUrl('xdaysaysay_admin_xdcc_delete_confirm', ['id' => $item->getId()]).'" class="btn btn-danger">'.$translator->trans('admin.common.action.delete', [], 'admin').'</a>',
            ];
        }

        $totalFiltered = $em->getRepository('XdaysaysayCoreBundle:Xdcc')->findLike($criteria, $orderBy, $limit, $offset, true, $columnSearch);

        $total = $em->getRepository('XdaysaysayCoreBundle:Xdcc')->countAll();

        return new JsonResponse(['data' => $datas, "draw" => $draw, "recordsTotal" => $total, "recordsFiltered" => $totalFiltered]);
    }
}