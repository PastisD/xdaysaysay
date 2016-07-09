<?php

namespace Xdaysaysay\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Xdaysaysay\CoreBundle\Form\Type\XdaysaysayTextType;

/**
 * Class TeamType
 * @package Xdaysaysay\AdminBundle\Form\Type
 */
class TeamType extends AbstractType
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
        $builder->add('name', null, [
            'label'       => 'admin.team.form.label.name',
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);
        $builder->add('logoFile', VichImageType::class, array(
            'required' => false,
        ));
        $builder->add('ircServer', null, [
            'label' => 'admin.team.form.label.ircServer',
        ]);
        $builder->add('chan_name', null, [
            'label'       => 'admin.team.form.label.chan_name',
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\Regex([
                    'pattern' => '/^#(.*)/',
                    'message' => 'must_start_with_hashtag'
                ]),
            ],
        ]);
        $builder->add('chan_name_password', null, [
            'label' => 'admin.team.form.label.chan_name_password',
            'required' => false,
        ]);
        $builder->add('chan_name_staff', null, [
            'label' => 'admin.team.form.label.chan_name_staff',
            'required' => false,
            'constraints' => [
                new Assert\Regex([
                    'pattern' => '/^#(.*)/',
                    'message' => 'must_start_with_hashtag'
                ]),
            ],
        ]);
        $builder->add('chan_name_staff_password', null, [
            'label' => 'admin.team.form.label.chan_name_staff_password',
            'required' => false,
        ]);
        $builder->add('bot_name', null, [
            'label' => 'admin.team.form.label.bot_name',
            'required' => false,
            'label_attr' => [
                'help' => 'admin.team.form.label.bot_name_help'
            ],
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws \Symfony\Component\OptionsResolver\Exception\AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'Xdaysaysay\CoreBundle\Entity\Team',
            'translation_domain' => 'admin',
        ]);
    }
}
