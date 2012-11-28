<?php

namespace Lrt\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('enabled', null, array('required' => false))
            ->add('password')
            ->add('locked', null, array('required' => false))
            ->add('roles')
            ->add('credentialsExpired', null, array('required' => false))
            ->add('firstName')
            ->add('lastName')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'lrt_userbundle_usertype';
    }
}
