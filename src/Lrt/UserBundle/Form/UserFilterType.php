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
use JMS\DiExtraBundle\Annotation as DI;

/**
 * @Service("users.form.userFilterType", public=true)
 */
class UserFilterType extends AbstractType
{
    /** @DI\Inject("translator") */
    public $tr;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('login', null, array('required' => false, 'label' => $this->tr->trans('users.form.login')))
                ->add('nom', null, array('required' => false, 'label' => $this->tr->trans('users.form.nom')))
                ->add('type', 'choice', array(
                    'label' => $this->tr->trans('users.form.type'),
                    'required' => false,
                    'choices' => array(
                        '' => 'tous',
                        'ROLE_ADMIN' => 'Administrateur',
                    ),
                ))
                ->add('email', null, array(
                    'required' => false,
                    'label' => $this->tr->trans('users.form.email')));
    }

    public function getName()
    {
        return 'userbundle_userfiltertype';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'csrf_protection' => false
        ));
    }
}
