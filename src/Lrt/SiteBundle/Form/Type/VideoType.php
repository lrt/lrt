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
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\Service("form.site.video.type")
 */
class VideoType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('title', null, array('required' => false, 'label' => 'Titre :'))
                ->add('description', null, array('required' => false, 'label' => 'Description :'))
                ->add('isPublished', 'choice', array(
                    'label' => 'Etat de publication',
                    'choices' => array(
                        '0' => 'Publié',
                        '1' => 'Non publié',
            )))
                ->add('isHighlighted', 'choice', array(
                    'label' => 'Mise en avant ?',
                    'choices' => array(
                        '0' => 'Non',
                        '1' => 'Oui',
            )))
                ->add('path', null, array('required' => false, 'label' => 'Url :'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\SiteBundle\Entity\Video'
        ));
    }

    public function getName()
    {
        return 'lrt_videobundle_videotype';
    }

}
