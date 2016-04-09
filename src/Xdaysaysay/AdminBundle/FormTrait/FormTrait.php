<?php

namespace Xdaysaysay\AdminBundle\FormTrait;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

trait FormTrait
{
    /**
     * Displays list of existing entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function indexAction()
    {
        $this->get('avanzu_admin_theme.theme_manager')->registerScript('datatble', 'bundles/xdaysaysayadmin/js/datatable.js');

        $entities = $this->getDoctrine()->getRepository($this->entityClassName)->findBy([], ['id' => 'DESC']);

        return $this->render(
            $this->twigFormDirectory.':index.html.twig', [
                'entities' => $entities,
            ]
        );
    }


    /**
     * Displays a form to edit an existing entity.
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

        $entity = $em->getRepository($this->entityClassName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $form = $this->createNewEditForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.'.$this->translation.'.flash.edit', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_'.$this->formRoute.'_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            $this->twigFormDirectory.':edit.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }


    /**
     * Displays a form to edit an existing entity.
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

        $entity = new $this->entityClassName;

        $form = $this->createNewEditForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.'.$this->translation.'.flash.create', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_'.$this->formRoute.'_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            $this->twigFormDirectory.':new.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }


    /**
     * Creates a form to create a entity.
     *
     * @param $entity
     *
     * @return \Symfony\Component\Form\Form The form
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    private function createNewEditForm($entity)
    {
        $action = $this->generateUrl('xdaysaysay_admin_'.$this->formRoute.'_new');
        $submitText = $this->get('translator')->trans('admin.common.form.create', [], 'admin');

        if ($entity->getId() !== null) {
            $action = $this->generateUrl('xdaysaysay_admin_'.$this->formRoute.'_edit', ['id' => $entity->getId()]);
            $submitText = $this->get('translator')->trans('admin.common.form.update', [], 'admin');
        }

        $form = $this->createForm(
            $this->formType, $entity, [
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

        $entity = $em->getRepository($this->entityClassName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        return $this->render(
            $this->twigFormDirectory.':confirm_delete.html.twig', [
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

        $entity = $em->getRepository($this->entityClassName)->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find entity.');
        }

        $form = $this->createDeleteForm($entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.'.$this->translation.'.flash.delete', [], 'admin'));

            return $this->redirectToRoute('xdaysaysay_admin_'.$this->formRoute.'_index');
        } else {
            return $this->redirectToRoute('xdaysaysay_admin_'.$this->formRoute.'_delete_confirm', ['id' => $id]);
        }
    }

    /**
     * @param $entity
     *
     * @return \Symfony\Component\Form\Form
     *
     * @throws \InvalidArgumentException
     */
    private function createDeleteForm($entity)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('xdaysaysay_admin_'.$this->formRoute.'_delete', ['id' => $entity->getId()]))
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