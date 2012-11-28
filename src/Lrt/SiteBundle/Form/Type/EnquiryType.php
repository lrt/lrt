<?php

namespace Lrt\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'Votre nom :'));
        $builder->add('email', 'email');
        $builder->add('subject', null, array('label' => 'Sujet : '));
        $builder->add('body', 'textarea', array('label' => 'Message :'));
    }

    public function getDefaultOptions(array $options)
    {
        return array('data_class' => 'Lrt\SiteBundle\Entity\Enquiry',);
    }

    public function getName()
    {
        return 'contact';
    }
}
