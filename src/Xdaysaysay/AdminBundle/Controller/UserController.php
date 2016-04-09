<?php

namespace Xdaysaysay\AdminBundle\Controller;

use FOS\UserBundle\Model\UserInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Xdaysaysay\AdminBundle\Form\Type\UserType;
use Xdaysaysay\AdminBundle\FormTrait\FormTrait;
use Xdaysaysay\UserBundle\Entity\User;

/**
 * Class UserController
 * @package Xdaysaysay\AdminBundle\Controller
 */
class UserController extends Controller
{
    use FormTrait;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->entityClassName = 'Xdaysaysay\UserBundle\Entity\User';
        $this->repositoryName = 'XdaysaysayUserBundle:User';
        $this->twigFormDirectory = 'XdaysaysayAdminBundle:User';
        $this->formRoute = 'user';
        $this->translation = 'user';
        $this->formType = 'Xdaysaysay\AdminBundle\Form\Type\UserType';
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

        $user = $this->getDoctrine()->getRepository('XdaysaysayUserBundle:User')->findOneBy([
            'username' => $form->get('username')->getData(),
        ]);

        if ($user) {
            $form->get('username')->addError(new FormError($this->get('translator')->trans('admin.user.flash.username_already_exists', [], 'admin')));
        }

        $user = $this->getDoctrine()->getRepository('XdaysaysayUserBundle:User')->findOneBy([
            'email' => $form->get('email')->getData(),
        ]);

        if ($user) {
            $form->get('email')->addError(new FormError($this->get('translator')->trans('admin.user.flash.email_already_exists', [], 'admin')));
        }

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
        $action = $this->generateUrl('xdaysaysay_admin_user_new');
        $submitText = $this->get('translator')->trans('admin.common.form.create', [], 'admin');

        if ($entity->getId() !== null) {
            $action = $this->generateUrl('xdaysaysay_admin_user_edit', ['id' => $entity->getId()]);
            $submitText = $this->get('translator')->trans('admin.common.form.update', [], 'admin');
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
}