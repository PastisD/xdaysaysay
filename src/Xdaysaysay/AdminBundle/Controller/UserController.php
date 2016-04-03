<?php

namespace Xdaysaysay\AdminBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\Form\Type\UserType;
use Xdaysaysay\UserBundle\Entity\User;

class UserController extends Controller
{
    /**
     * Displays list of existing User entities.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \LogicException
     * @throws \UnexpectedValueException
     */
    public function indexAction()
    {
        $this->get('avanzu_admin_theme.theme_manager')->registerScript('datatble', 'bundles/xdaysaysayadmin/js/datatable.js');

        $users = $this->getDoctrine()->getRepository('XdaysaysayUserBundle:User')->findBy([], ['id' => 'DESC']);

        return $this->render(
            'XdaysaysayAdminBundle:User:index.html.twig', [
                'users' => $users,
            ]
        );
    }

    /**
     * Displays a form to edit an existing User entity.
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
     * @throws \OutOfBoundsException
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('XdaysaysayUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createNewEditForm($entity);

        $form->handleRequest($request);

        if ($form->isValid()) {
            if ($form->get('password')->getData() !== '') {
                $entity->setPlainPassword($form->get('password')->getData());
            }
            $this->get('fos_user.user_manager')->updateUser($entity);

            $this->addFlash('success', $this->get('translator')->trans('admin.user.flash.edit', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_user_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            '@XdaysaysayAdmin/User/edit.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }

    /**
     * Displays a form to edit an existing User entity.
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
     * @throws \OutOfBoundsException
     */
    public function newAction(Request $request)
    {
        $entity = $this->get('fos_user.user_manager')->createUser();

        $form = $this->createNewEditForm($entity, true);

        $form->handleRequest($request);

        if ($form->isValid()) {
            $entity->setPlainPassword($form->get('password')->getData());
            $this->get('fos_user.user_manager')->updateUser($entity);

            $this->addFlash('success', $this->get('translator')->trans('admin.user.flash.create', [], 'admin'));

            return $this->redirect($this->generateUrl('xdaysaysay_admin_user_edit', ['id' => $entity->getId()]));
        }

        return $this->render(
            '@XdaysaysayAdmin/User/new.html.twig', [
                'entity' => $entity,
                'form'   => $form->createView(),
            ]
        );
    }


    /**
     * Creates a form to create a User entity.
     *
     * @param UserInterface $entity The entity
     * @param boolean $newUser      Define if the for is for a new user entity
     *
     * @return \Symfony\Component\Form\Form The form
     *
     * @throws \InvalidArgumentException
     * @throws \Symfony\Component\Form\Exception\AlreadySubmittedException
     * @throws \Symfony\Component\Form\Exception\LogicException
     * @throws \Symfony\Component\Form\Exception\UnexpectedTypeException
     */
    private function createNewEditForm(UserInterface $entity, $newUser = false)
    {
        if ($entity->getId() !== null) {
            $action = $this->generateUrl('xdaysaysay_admin_user_edit', ['id' => $entity->getId()]);
            $submitText = $this->get('translator')->trans('admin.common.form.update', [], 'admin');
        } else {
            $action = $this->generateUrl('xdaysaysay_admin_user_new');
            $submitText = $this->get('translator')->trans('admin.common.form.create', [], 'admin');
        }

        $form = $this->createForm(
            UserType::class, $entity, [
                'action'   => $action,
                'method'   => 'PUT',
                'new_user' => $newUser,
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

        $entity = $em->getRepository('XdaysaysayUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render(
            '@XdaysaysayAdmin/User/confirm_delete.html.twig', [
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

        $entity = $em->getRepository('XdaysaysayUserBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $form = $this->createDeleteForm($entity);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $em->remove($entity);
            $em->flush();

            $this->addFlash('success', $this->get('translator')->trans('admin.user.flash.delete', [], 'admin'));

            return $this->redirectToRoute('xdaysaysay_admin_user_index');
        } else {
            return $this->redirectToRoute('xdaysaysay_admin_user_delete_confirm', ['id' => $id]);
        }
    }

    /**
     * @param User $entity
     *
     * @return \Symfony\Component\Form\Form
     *
     * @throws \InvalidArgumentException
     */
    private function createDeleteForm(User $entity)
    {
        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('xdaysaysay_admin_user_delete', ['id' => $entity->getId()]))
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