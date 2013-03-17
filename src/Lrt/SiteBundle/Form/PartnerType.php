<?php

namespace Lrt\SiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("form.site.partner.type")
 */
class PartnerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('name')
                ->add('description')
                ->add('website')
                ->add('picture', null, array('label' => 'Logo', 'required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\SiteBundle\Entity\Partner'
        ));
    }

    public function getName()
    {
        return 'lrt_sitebundle_partnertype';
    }

}
