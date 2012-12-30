<?php

namespace Lrt\TeamBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PrizeListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('year')
            ->add('position')
            ->add('name')
            ->add('user')
            ->add('team')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\TeamBundle\Entity\PrizeList'
        ));
    }

    public function getName()
    {
        return 'lrt_teambundle_prizelisttype';
    }
}
