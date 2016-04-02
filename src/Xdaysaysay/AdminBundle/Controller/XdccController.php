<?php

namespace Xdaysaysay\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\Form\Type\XdccType;
use Xdaysaysay\CoreBundle\Entity\Xdcc;

class XdccController extends Controller
{
    /**
     * Displays list of existing Xdcc entities.
     *
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function indexAction(Request $request)
    {
        $this->get('avanzu_admin_theme.theme_manager')->registerScript('datatble', 'bundles/xdaysaysayadmin/js/datatable.js');

        $xdccs = $this->getDoctrine()->getRepository('XdaysaysayCoreBundle:Xdcc')->findBy([], ['id' => 'DESC']);

        return $this->render(
            'XdaysaysayAdminBundle:Xdcc:index.html.twig', [
                'xdccs' => $xdccs,
            ]
        );
    }

    /**
     * Displays a form to edit an existing Xdcc entity.
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

        $entity = $em->getRepository('XdaysaysayCoreBundle:Xdcc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Xdcc entity.');
        }

        $form = $this->createNewEditForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.xdcc.flash.edit', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_xdcc_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            '@XdaysaysayAdmin/Xdcc/edit.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing Xdcc entity.
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

        $entity = new Xdcc;

        $form = $this->createNewEditForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.xdcc.flash.create', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_xdcc_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            '@XdaysaysayAdmin/Xdcc/new.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }


    /**
     * Creates a form to create a Xdcc entity.
     *
     * @param Xdcc $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    private function createNewEditForm(Xdcc $entity)
    {
        if ($entity->getId() !== null) {
            $action = $this->generateUrl('xdaysaysay_admin_xdcc_edit', ['id' => $entity->getId()]);
            $submitText = $this->get('translator')->trans('admin.common.form.update', [], 'admin');
        } else {
            $action = $this->generateUrl('xdaysaysay_admin_xdcc_new');
            $submitText = $this->get('translator')->trans('admin.common.form.create', [], 'admin');
        }

        $form = $this->createForm(
            XdccType::class, $entity, [
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
     * @param Request $request
     * @param $id
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function deleteConfirmAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('XdaysaysayCoreBundle:Xdcc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Xdcc entity.');
        }

        return $this->render(
            '@XdaysaysayAdmin/Xdcc/confirm_delete.html.twig', [
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

        $entity = $em->getRepository('XdaysaysayCoreBundle:Xdcc')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Xdcc entity.');
        }

        $form = $this->createDeleteForm($entity);

        $form->handleRequest($request);
        if($form->isValid()) {
            $em->remove($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.xdcc.flash.delete', [], 'admin'));

            return $this->redirectToRoute('xdaysaysay_admin_xdcc_index');
        } else {
            return $this->redirectToRoute('xdaysaysay_admin_xdcc_delete_confirm', ['id' => $id]);
        }
    }

    /**
     * @param Xdcc $entity
     *
     * @return \Symfony\Component\Form\Form
     *
     * @throws \InvalidArgumentException
     */
    private function createDeleteForm(Xdcc $entity)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('xdaysaysay_admin_xdcc_delete', ['id' => $entity->getId()]))
            ->setMethod('DELETE')
            ->add('submit', SubmitType::class, [
                'label' => $this->get('translator')->trans('admin.common.action.delete', [], 'admin'),
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ])
            ->getForm();

        return $form;
    }
}