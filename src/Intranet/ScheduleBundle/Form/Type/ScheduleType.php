<?php

namespace Intranet\ScheduleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScheduleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('comment', 'ckeditor', array('label' => 'Commentaire'))
                ->add('attachments', 'collection', array(
                    'label' => ' ',
                    'type' => new ScheduleAttachmentType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\ScheduleBundle\Entity\Schedule'
        ));
    }

    public function getName() {
        return 'Schedule';
    }

}