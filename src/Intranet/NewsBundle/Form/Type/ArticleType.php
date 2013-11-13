<?php

namespace Intranet\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('title', 'text', array('label' => 'Titre'))
                ->add('picto', 'entity', array(
                    'label' => 'Pictogramme',
                    'class' => 'IntranetNewsBundle:PictoNews',
                    'property' => 'description',
                    'empty_value' => 'Choisissez le pictogramme',
                    'expanded' => false,
                    'multiple' => false,))
                ->add('content', 'ckeditor', array('label' => 'Contenu'))
                ->add('attachments', 'collection', array(
                    'label' => 'Fichiers joints',
                    'type' => new ArticleAttachmentType(),
                    'allow_add' => true,
                    'by_reference' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\NewsBundle\Entity\Article'
        ));
    }

    public function getName() {
        return 'Article';
    }

}

?>
