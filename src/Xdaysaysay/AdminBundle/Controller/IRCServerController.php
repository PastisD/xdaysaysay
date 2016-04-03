<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\Form\Type\IRCServerType;
use Xdaysaysay\CoreBundle\Entity\IRCServer;

class IRCServerController extends Controller
{
    /**
     * Displays list of existing IRCServer entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function indexAction()
    {
        $this->get('avanzu_admin_theme.theme_manager')->registerScript('datatble', 'bundles/xdaysaysayadmin/js/datatable.js');

        $ircServers = $this->getDoctrine()->getRepository('XdaysaysayCoreBundle:IRCServer')->findBy([], ['id' => 'DESC']);

        return $this->render(
            'XdaysaysayAdminBundle:IRCServer:index.html.twig', [
                'irc_servers' => $ircServers,
            ]
        );
    }

    /**
     * Displays a form to edit an existing IRCServer entity.
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

        $entity = $em->getRepository('XdaysaysayCoreBundle:IRCServer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IRCServer entity.');
        }

        $form = $this->createNewEditForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.irc_server.flash.edit', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_irc_server_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            '@XdaysaysayAdmin/IRCServer/edit.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing IRCServer entity.
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

        $entity = new IRCServer;

        $form = $this->createNewEditForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.irc_server.flash.create', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_irc_server_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            '@XdaysaysayAdmin/IRCServer/new.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }


    /**
     * Creates a form to create a IRCServer entity.
     *
     * @param IRCServer $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    private function createNewEditForm(IRCServer $entity)
    {
        if ($entity->getId() !== null) {
            $action = $this->generateUrl('xdaysaysay_admin_irc_server_edit', ['id' => $entity->getId()]);
            $submitText = $this->get('translator')->trans('admin.common.form.update', [], 'admin');
        } else {
            $action = $this->generateUrl('xdaysaysay_admin_irc_server_new');
            $submitText = $this->get('translator')->trans('admin.common.form.create', [], 'admin');
        }

        $form = $this->createForm(
            IRCServerType::class, $entity, [
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

        $entity = $em->getRepository('XdaysaysayCoreBundle:IRCServer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IRCServer entity.');
        }

        return $this->render(
            '@XdaysaysayAdmin/IRCServer/confirm_delete.html.twig', [
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

        $entity = $em->getRepository('XdaysaysayCoreBundle:IRCServer')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find IRCServer entity.');
        }

        $form = $this->createDeleteForm($entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.irc_server.flash.delete', [], 'admin'));

            return $this->redirectToRoute('xdaysaysay_admin_irc_server_index');
        } else {
            return $this->redirectToRoute('xdaysaysay_admin_irc_server_delete_confirm', ['id' => $id]);
        }
    }

    /**
     * @param IRCServer $entity
     *
     * @return \Symfony\Component\Form\Form
     *
     * @throws \InvalidArgumentException
     */
    private function createDeleteForm(IRCServer $entity)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('xdaysaysay_admin_irc_server_delete', ['id' => $entity->getId()]))
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