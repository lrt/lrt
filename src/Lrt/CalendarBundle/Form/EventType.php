<?php

namespace Lrt\CalendarBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','text', array('label' => 'Nom'))
            ->add('dateDeb', 'genemu_jquerydate', array(
            'widget' => 'single_text',
            'label' => 'Date de début',
            'format' => 'dd/MM/yyyy',
            'attr' => array('class' => 'date')
            ))
            ->add('dateEnd', 'genemu_jquerydate', array(
            'widget' => 'single_text',
            'label' => 'Date de fin',
            'format' => 'dd/MM/yyyy',
            'attr' => array('class' => 'date')
            ))
            ->add('place','text', array('label' => 'Ville'))
            ->add('website','text', array('label' => 'Site internet'))
            ->add('description', 'textarea', array('required' => false, 'label' => 'Description'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\CalendarBundle\Entity\Event'
        ));
    }

    public function getName()
    {
        return 'lrt_calendarbundle_eventtype';
    }
}
