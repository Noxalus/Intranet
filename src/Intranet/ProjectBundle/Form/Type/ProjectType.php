<?php

/**
 * Description of ProjectFormType
 *
 * @author Martial
 */

// src/Intranet/ProjectBundle/Form/Type/ProjectFormType.php
namespace Intranet\ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ProjectType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');
        $builder->add('description', 'textarea');

        $builder->add('deadlines', 'collection', array(
            'type' => new DeadlineType(),
            'allow_add'    => true,
            'by_reference' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\ProjectBundle\Entity\Project',
        ));
    }

    public function getName()
    {
        return 'project';
    }

}