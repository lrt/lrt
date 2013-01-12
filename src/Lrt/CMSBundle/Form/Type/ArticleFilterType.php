<?php

/**
 * @category Form
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\CMSBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\Service;
use JMS\DiExtraBundle\Annotation as DI;
use Lrt\SiteBundle\Enum\StatusArticleEnum;

/**
 * @Service("form.cms.article.filter.type")
 */
class ArticleFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $statusArticleEnum = new StatusArticleEnum();
        
        $builder->add('title', null, array('required' => false, 'label' => 'Titre :'))
                ->add('status', 'choice', array(
                    'required' => false,
                    'label' => 'Statut :',
                    'empty_value' => 'Etat de publication',
                    'choices' => $statusArticleEnum->getData()))
                ->add('isPublic', 'choice', array(
                    'required' => false,
                    'label' => 'Visibilité :',
                    'empty_value' => 'Restrictions',
                    'choices' => array(
                        '0' => 'Privé',
                        '1' => 'Public', 
                    )))
                ->add('category', 'entity', array(
                    'required' => false,
                    'class' => 'Lrt\CMSBundle\Entity\Category',
                    'property' => 'name',
                    'empty_value' => 'Dans la rubrique',
                    'label' => 'Rubrique :'));
    }

    public function getName() 
    {
        return 'cmsbundle_articlefiltertype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }

}

