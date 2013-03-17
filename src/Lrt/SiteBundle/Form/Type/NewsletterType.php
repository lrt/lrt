<?php

namespace Lrt\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @Service("form.site.newsletter.type")
 */
class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array(
            'label' => 'Email',
            'required' => true,
            'attr' => array(
                'class' => 'input-medium',
                'placeholder' => 'Votre email'
            )
        ));
    }

    public function getName()
    {
        return 'newsletter';
    }
}
