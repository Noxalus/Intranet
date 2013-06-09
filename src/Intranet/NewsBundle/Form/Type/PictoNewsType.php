<?php

namespace Intranet\NewsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


/**
 * Description of PictoNewsType
 *
 * @author Erika
 */
class PictoNewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
           ->add('description', 'text')
           ->add('file');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\NewsBundle\Entity\PictoNews'
        ));
    }

    public function getName()
    {
        return 'PictoNews';
    }
}

?>
