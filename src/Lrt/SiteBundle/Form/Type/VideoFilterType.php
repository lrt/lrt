<?php

/**
 * @category Form
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\SiteBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @Service("form.video.filter.type")
 */
class VideoFilterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', null, array('required' => false, 'label' => 'Titre :'))
                ->add('status', 'choice', array(
                    'required' => false,
                    'label' => 'Statut :',
                    'empty_value' => 'Etat de publication',
                    'choices' => array(
                        '0' => 'Publié',
                        '1' => 'Non publié',
            )))
                ->add('isPublic', 'choice', array(
                    'required' => false,
                    'label' => 'Visibilité :',
                    'empty_value' => 'Restrictions',
                    'choices' => array(
                        '0' => 'Privé',
                        '1' => 'Public',
        )));
    }

    public function getName()
    {
        return 'lrt_videobundle_videofiltertype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

}
