<?php

namespace Lrt\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('vimeoId')
            ->add('isAutoPlay')
            ->add('isPublished')
            ->add('isPublic')
            ->add('isHighlighted')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\SiteBundle\Entity\Video'
        ));
    }

    public function getName()
    {
        return 'lrt_sitebundle_videotype';
    }
}
