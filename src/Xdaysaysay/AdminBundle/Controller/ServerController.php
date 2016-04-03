<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\Form\Type\ServerType;
use Xdaysaysay\CoreBundle\Entity\Server;

class ServerController extends Controller
{
    /**
     * Displays list of existing Server entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function indexAction()
    {
        $this->get('avanzu_admin_theme.theme_manager')->registerScript('datatble', 'bundles/xdaysaysayadmin/js/datatable.js');

        $servers = $this->getDoctrine()->getRepository('XdaysaysayCoreBundle:Server')->findBy([], ['id' => 'DESC']);

        return $this->render(
            'XdaysaysayAdminBundle:Server:index.html.twig', [
                'servers' => $servers,
            ]
        );
    }

    /**
     * Displays a form to edit an existing Server entity.
     *
     * @param Request $request
     * @param int $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('XdaysaysayCoreBundle:Server')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Server entity.');
        }

        $form = $this->createNewEditForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.server.flash.edit', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_server_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            '@XdaysaysayAdmin/Server/edit.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing Server entity.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = new Server;

        $form = $this->createNewEditForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.server.flash.create', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_server_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            '@XdaysaysayAdmin/Server/new.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }


    /**
     * Creates a form to create a Server entity.
     *
     * @param Server $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    private function createNewEditForm(Server $entity)
    {
        if ($entity->getId() !== null) {
            $action = $this->generateUrl('xdaysaysay_admin_server_edit', ['id' => $entity->getId()]);
            $submitText = $this->get('translator')->trans('admin.common.form.update', [], 'admin');
        } else {
            $action = $this->generateUrl('xdaysaysay_admin_server_new');
            $submitText = $this->get('translator')->trans('admin.common.form.create', [], 'admin');
        }

        $form = $this->createForm(
            ServerType::class, $entity, [
                'action' => $action,
                'method' => 'PUT',
            ]
        );

        $form->add(
            'submit', SubmitType::class, [
                'label' => $submitText,
                'attr'  => [
                    'class' => 'btn btn-primary',
                ],
            ]
        );

        return $form;
    }

    /**
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteConfirmAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('XdaysaysayCoreBundle:Server')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Server entity.');
        }

        return $this->render(
            '@XdaysaysayAdmin/Server/confirm_delete.html.twig', [
                'entity' => $entity,
                'form'   => $this->createDeleteForm($entity)->createView(),
            ]
        );
    }

    /**
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @throws \LogicException
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('XdaysaysayCoreBundle:Server')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Server entity.');
        }

        $form = $this->createDeleteForm($entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.server.flash.delete', [], 'admin'));

            return $this->redirectToRoute('xdaysaysay_admin_server_index');
        } else {
            return $this->redirectToRoute('xdaysaysay_admin_server_delete_confirm', ['id' => $id]);
        }
    }

    /**
     * @param Server $entity
     *
     * @return \Symfony\Component\Form\Form
     *
     * @throws \InvalidArgumentException
     */
    private function createDeleteForm(Server $entity)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('xdaysaysay_admin_server_delete', ['id' => $entity->getId()]))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('admin.common.action.delete', [], 'admin'),
                'attr'  => [
                    'class' => 'btn btn-danger',
                ],
            ])
            ->getForm();

        return $form;
    }
}