<?php

namespace Lrt\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * @Service("users.form.adhesionType")
 */
class AdhesionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName','text', array('label' => 'Prénom','attr' => array('class' => 'span4', 'placeholder' => 'Prénom')))
            ->add('lastName', 'text', array('label' => 'Nom','attr' => array('class' => 'span4', 'placeholder' => 'Nom')))
            ->add('birthday', 'genemu_jquerydate', array(
                'widget' => 'single_text',
                'label' => 'Date de naissance ',
                'format' => 'dd/MM/yyyy',
                'attr' => array('class' => 'datepicker span8')
            ))
            ->add('gender', 'choice', array(
                'label' => 'Sexe',
                'empty_value' => 'Je suis un/une ...',
                'choices'   => array('f' => 'Femme', 'm' => 'Homme'),
                'required'  => false,
                'attr' => array('class' => 'span8')
            ))
            ->add('phone', 'text', array('label' => 'Numéro de téléphone mobile','attr' => array('class' => 'span8')))
            ->add('email', 'email', array('label' => 'Votre adresse e-mail actuelle','attr' => array('class' => 'span8')))
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
        return 'adhesion';
    }
}
