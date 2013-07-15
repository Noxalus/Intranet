<?php

namespace Intranet\WikiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ModifType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('article', new ArticleType())
                ->add('content', 'ckeditor', array('label' => 'Contenu'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\WikiBundle\Entity\Modif'
        ));
    }

    public function getName()
    {
        return 'intranet_wikibundle_modiftype';
    }

}
