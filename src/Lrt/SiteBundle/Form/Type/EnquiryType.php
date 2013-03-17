<?php

namespace Lrt\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @Service("form.site.contact.type")
 */
class EnquiryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, array('label' => 'Nom'));
        $builder->add('email', 'email');
        $builder->add('subject', null, array('label' => 'Sujet'));
        $builder->add('body', 'textarea', array('label' => 'Message'));
    }

    public function getName()
    {
        return 'contact';
    }
}
