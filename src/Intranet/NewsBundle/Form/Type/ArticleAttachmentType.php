<?php

namespace Intranet\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleAttachmentType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array('label' => 'Nom du fichier'))
                ->add('file', 'file', array('label' => 'Fichier'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\NewsBundle\Entity\ArticleAttachment'
        ));
    }

    public function getName() {
        return 'ArticleAttachment';
    }

}

?>
