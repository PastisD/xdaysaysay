<?php

namespace Xdaysaysay\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class IRCServerType extends AbstractType
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
            'label'       => 'admin.irc_server.form.label.name',
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);
        $builder->add('host', null, [
            'label'       => 'admin.irc_server.form.label.host',
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);
        $builder->add('port', null, [
            'label'       => 'admin.irc_server.form.label.port',
            'constraints' => [
                new Assert\NotBlank(),
            ],
        ]);
        $builder->add('port_ssl', null, [
            'label' => 'admin.irc_server.form.label.port_ssl',
        ]);
        $builder->add('website', null, [
            'label' => 'admin.irc_server.form.label.website',
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
            'data_class'         => 'Xdaysaysay\CoreBundle\Entity\IRCServer',
            'translation_domain' => 'admin',
        ]);
    }
}
