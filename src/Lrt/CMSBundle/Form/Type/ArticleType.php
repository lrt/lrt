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
use Lrt\CMSBundle\Entity\Article;

/**
 * @Service("form.cms.article.type")
 */
class ArticleType extends AbstractType
{
    /** @DI\Inject("translator") */
    public $tr;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text', array('label' => 'Titre', 'required' => true))
            ->add('content', 'textarea', array('label' => 'Contenu', 'required' => true, 'attr' => array('class' => 'ckeditor')))
            ->add('status', 'choice', array(
            'label' => 'Etat de publication',
            'choices' => array(
                Article::DRAFTS => 'Brouillon',
                Article::IMMEDIATE => 'Publication immédiate',
            )))
            ->add('picture', null, array('label' => 'Image', 'required' => false))
            ->add('isPublic', null, array('label' => 'Voir sur la page principal ?', 'required' => false))
            ->add('category', 'entity', array(
            'class' => 'Lrt\CMSBundle\Entity\Category',
            'property' => 'name',
            'label' => 'Rubrique :'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Lrt\CMSBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'lrt_cmsbundle_articletype';
    }
}
