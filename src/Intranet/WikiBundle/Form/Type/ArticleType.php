<?php

namespace Intranet\WikiBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ArticleType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text')
                ->add('thematic', 'entity', array(
                    'class' => 'IntranetWikiBundle:Thematic',
                        )
                );
                
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\WikiBundle\Entity\Article'
        ));
    }

    public function getName()
    {
        return 'intranet_wikibundle_articletype';
    }

}
