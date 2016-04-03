<?php

namespace Xdaysaysay\AdminBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\Exception\AccessException;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TeamType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, [
            'label' => 'admin.team.form.label.name',
        ]);
        $builder->add('ircServer', null, [
            'label' => 'admin.team.form.label.ircServer',
        ]);
        $builder->add('chan_name', null, [
            'label' => 'admin.team.form.label.chan_name',
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
            'data_class'         => 'Xdaysaysay\CoreBundle\Entity\Team',
            'translation_domain' => 'admin',
        ]);
    }
}
