<?php

namespace Intranet\ScheduleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScheduleAttachmentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array('label' => 'Nom du fichier'))
                ->add('file', 'file', array('label' => 'Fichier'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\ScheduleBundle\Entity\ScheduleAttachment'
        ));
    }

    public function getName() {
        return 'ScheduleAttachment';
    }

}