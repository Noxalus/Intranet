<?php

namespace Intranet\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('username', 'text', array('label' => 'Login'))
                ->add('email', 'text', array('label' => 'Adresse email'))
                ->add('firstName', 'text', array('label' => 'Prénom'))
                ->add('lastName', 'text', array('label' => 'Nom'))
                ->add('promo', 'integer', array('label' => 'Promotion'))
                ->add('photo', new PhotoType(), array('label' => ' '));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\UserBundle\Entity\User'
        ));
    }

    public function getName()
    {
        return 'intranet_userbundle_usertype';
    }

}
