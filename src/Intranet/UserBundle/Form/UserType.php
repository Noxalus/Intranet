<?php

namespace Intranet\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', 'text', array('label' => 'Login'))
                ->add('plainPassword', 'repeated', array(
                'type' => 'password',
                'label' => ' ',
                'options' => array('translation_domain' => 'FOSUserBundle'),
                'first_options' => array('label' => 'Mot de passe'),
                'second_options' => array('label' => 'Confirmation'),
                'invalid_message' => 'Les deux mots de passe ne sont pas identiques',
                ))
                ->add('email', 'email', array('label' => 'Adresse email'))
                ->add('firstName', 'text', array('label' => 'Prénom'))
                ->add('lastName', 'text', array('label' => 'Nom'))
                ->add('promo', 'integer', array(
                    'label' => 'Promotion',
                    'required' => false))
                
                ->add('roles', 'choice', array(
                    'label' => 'Rôles',
                    'choices' => array(
                        'ROLE_STUDENT' => 'Etudiant', 
                        'ROLE_TEACHER' => 'Professeur'),
                    'required' => true,
                    'multiple'  => false,
                    'expanded' => false,
                    'mapped' => false
                ))
                ->add('photo', new PhotoType(), array('label' => ' ', 'required' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\UserBundle\Entity\User'
        ));
    }

    public function getName() {
        return 'intranet_userbundle_usertype';
    }

}
