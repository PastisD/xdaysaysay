<?php

namespace Xdaysaysay\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class UserType
 * @package Xdaysaysay\AdminBundle\Form\Type
 */
class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * @throws \Symfony\Component\Validator\Exception\ConstraintDefinitionException
     * @throws \Symfony\Component\Validator\Exception\InvalidOptionsException
     * @throws \Symfony\Component\Validator\Exception\MissingOptionsException
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('username', null, [
            'label'       => 'admin.user.form.label.username',
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);
        $builder->add('email', null, [
            'label'       => 'admin.user.form.label.email',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Email(['checkMX' => true]),
            ],
        ]);
        $passwordConstraints = [];
        if ($options['new_user']) {
            $passwordConstraints = [
                new Assert\NotBlank(),
            ];
        }
        $builder->add('password', RepeatedType::class, [
            'first_name'     => 'password',
            'second_name'    => 'password_repeat',
            'first_options'  => [
                'label' => 'admin.user.form.label.password',
            ],
            'second_options' => [
                'label' => 'admin.user.form.label.password_repeat',
            ],
            'type'           => PasswordType::class,
            'mapped'         => false,
            'required'       => $options['new_user'],
            'constraints'    => $passwordConstraints,
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined('new_user');
        $resolver->setDefaults([
            'new_user'           => false,
            'data_class'         => 'Xdaysaysay\UserBundle\Entity\User',
            'translation_domain' => 'admin',
        ]);
    }
}
