<?php

namespace Lrt\AdhesionBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * @Service("form.adhesionType")
 */
class AdhesionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('licence', 'text', array('label' => 'Numéro de licence','attr' => array('class' => 'span8', 'placeholder' => 'facultatif')))    
            ->add('firstName','text', array('label' => 'Prénom','attr' => array('class' => 'span4', 'placeholder' => 'Prénom')))
            ->add('lastName', 'text', array('label' => 'Nom*','attr' => array('class' => 'span4', 'placeholder' => 'Nom')))
            ->add('birthday', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'label' => 'Date de naissance* ',
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'datepicker span8')
            ))
            ->add('address', 'text', array('label' => 'Adresse*','attr' => array('class' => 'span8')))
            ->add('city', 'text', array(
                'label' => 'Nom',
                'attr' => array('class' => 'span4', 'placeholder' => 'Ville')))
            ->add('zipCode', 'text', array(
                'label' => 'Nom',
                'max_length' => '5',
                'attr' => array('class' => 'span4', 'placeholder' => 'Code Postale')))
            ->add('gender', 'choice', array(
                'label' => 'Sexe*',
                'empty_value' => 'Je suis un/une ...',
                'choices'   => array('f' => 'Femme', 'm' => 'Homme'),
                'required'  => false,
                'attr' => array('class' => 'span8')
            ))
            ->add('phone', 'text', array(
                'label' => 'Numéro de téléphone mobile*',
                'max_length' => '10',
                'attr' => array('class' => 'span8')))
            ->add('email', 'email', array(
                'label' => 'Votre adresse e-mail actuelle*',
                'attr' => array('class' => 'span8')))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\AdhesionBundle\Entity\Adherent'
        ));
    }

    public function getName()
    {
        return 'adhesion';
    }
}
