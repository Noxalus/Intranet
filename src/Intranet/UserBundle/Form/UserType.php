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
                ->add('username', 'text')
                ->add('email', 'text')
                ->add('firstName', 'text')
                ->add('lastName', 'text')
                ->add('promo', 'integer')
                ->add('photo', new PhotoType());
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
