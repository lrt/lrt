<?php

namespace Lrt\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @Service("users.form.userFilterType", public=true)
 */
class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', 'choice', array(
            'required' => false,
            'choices' => array(
                '' => 'tous',
                'ROLE_ADMIN' => 'Administrateur',
            ),
        ));
    }

    public function getName()
    {
        return 'lrt_userbundle_userfiltertype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }
}
