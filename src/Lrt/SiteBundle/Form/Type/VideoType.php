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

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', null, array('required' => false, 'label' => 'Titre :'))
            ->add('description', null, array('required' => false, 'label' => 'Description :'))
            ->add('isPublished', null, array('required' => false, 'label' => 'Publication :'))
            ->add('isHighlighted', null, array('required' => false, 'label' => 'Mise en avant ?'))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\VideoBundle\Entity\Video'
        ));
    }

    public function getName()
    {
        return 'lrt_videobundle_videotype';
    }
}
