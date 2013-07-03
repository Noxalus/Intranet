<?php

/**
 * Description of WikiArticleType
 *
 * @author Erika
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class WikiArticleType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text');

        $builder->add('deadlines', 'collection', array(
            'type' => new DeadlineType(),
            'allow_add'    => true,
            'by_reference' => false));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\WikiBundle\Entity\Article',
        ));
    }

    public function getName()
    {
        return 'WikiArticle';
    }
}

?>
