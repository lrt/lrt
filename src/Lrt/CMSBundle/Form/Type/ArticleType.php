<?php

namespace Lrt\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Lrt\SiteBundle\Enum\StatusArticleEnum;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $statusArticleEnum = new StatusArticleEnum();

        $builder
            ->add('title', 'text', array(
            'attr' => array(
                'class' => 'monPlaceholder',
            )))
            ->add('content', 'textarea', array('required' => true))
            ->add('status', 'choice', array(
                'label' => 'Status',
                'choices' => $statusArticleEnum->getData()))
            ->add('isPublic')
            ->add('category','entity', array(
                'class'=>'Lrt\CMSBundle\Entity\Category',
                'property'=>'name',
                'label' => 'Rubrique :'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\CMSBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'lrt_sitebundle_articletype';
    }
}
