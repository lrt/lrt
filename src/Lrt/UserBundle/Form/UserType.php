<?php

/**
 * @category Form
 * @author   Alexandre Seiller <alexandre.seiller92@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     http://longchamp-roller-team.com
 */

namespace Lrt\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use JMS\DiExtraBundle\Annotation\Service;

/**
 * @Service("users.form.userType", public=true)
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', null, array('label' => 'Prénom','attr' => array('class' => 'span4')))
            ->add('lastName', null, array('label' => 'Nom','attr' => array('class' => 'span4')))
            ->add('username', null, array('label' => 'Login','attr' => array('class' => 'span4')))
            ->add('email', 'email', array('label' => 'Email','attr' => array('class' => 'span4')))
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
        return 'lrt_userbundle_usertype';
    }
}
