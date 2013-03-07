<?php

namespace Lrt\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("form.site.event.type")
 */
class EventType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', 'text', array('label' => 'Nom', 'attr' => array('placeholder' => 'Titre de l\'évènement')))
                ->add('dateDeb', 'genemu_jquerydate', array(
                    'widget' => 'single_text',
                    'label' => 'Date de début',
                    'format' => 'dd/MM/yyyy',
                    'attr' => array('class' => 'datepicker mask_date')
                ))
                ->add('dateEnd', 'genemu_jquerydate', array(
                    'widget' => 'single_text',
                    'label' => 'Date de fin',
                    'format' => 'dd/MM/yyyy',
                    'attr' => array('class' => 'datepicker mask_date')
                ))
                ->add('place', 'text', array('label' => 'Ville'))
                ->add('website', 'text', array('label' => 'Site internet'))
                ->add('description', 'textarea', array('required' => false, 'label' => 'Description'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\SiteBundle\Entity\Event'
        ));
    }

    public function getName()
    {
        return 'lrt_calendarbundle_eventtype';
    }

}
