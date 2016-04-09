<?php

namespace Xdaysaysay\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class XdccType
 * @package Xdaysaysay\AdminBundle\Form\Type
 */
class XdccType extends AbstractType
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
        $builder->add('server', null, [
            'label' => 'admin.xdcc.form.label.server',
        ]);
        $builder->add('url', null, [
            'label'       => 'admin.xdcc.form.label.url',
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);
        $builder->add('teams', null, [
            'label' => 'admin.xdcc.form.label.teams',
        ]);
        $builder->add('visible', null, [
            'label' => 'admin.xdcc.form.label.visible',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'         => 'Xdaysaysay\CoreBundle\Entity\Xdcc',
            'translation_domain' => 'admin',
        ]);
    }
}
