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
 * @Service("form.cms.article.type")
 */
class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $statusArticleEnum = new StatusArticleEnum();

        $builder
            ->add('title', 'text', array('label' => 'Titre', 'required' => true))
            ->add('content', 'textarea', array('label' => 'Contenu', 'required' => true))
            ->add('status', 'choice', array('label' => 'Status','choices' => $statusArticleEnum->getData()))
            ->add('isPublic', null, array('label' => 'Publique'))
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
