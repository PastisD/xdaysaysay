<?php

namespace Xdaysaysay\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, [
            'label' => 'admin.server.form.label.name',
        ]);
        $builder->add('host', null, [
            'label' => 'admin.server.form.label.host',
        ]);
        $builder->add('ssl', null, [
            'label' => 'admin.server.form.label.ssl',
        ]);
        $builder->add('http_port', null, [
            'label' => 'admin.server.form.label.http_port',
        ]);
    }

    /**
     * @param OptionsResolver $resolver
     *
     * @throws AccessException
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Xdaysaysay\CoreBundle\Entity\Server',
            'translation_domain' => 'admin',
        ));
    }
}
