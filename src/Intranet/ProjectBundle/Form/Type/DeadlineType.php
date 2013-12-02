<?php
/**
 * Description of DeadlineFormType
 *
 * @author Martial
 */

// src/Intranet/ProjectBundle/Form/Type/DeadlineFormType.php
namespace Intranet\ProjectBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeadlineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('date', 'datetime', array(
                      'label' => 'Date limite',
                      //'format' => 'yyyy-mm-dd hh:ii',
                      'widget' => 'single_text'));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Intranet\ProjectBundle\Entity\ProjectDeadline',
        ));
    }

    public function getName()
    {
        return 'deadline';
    }
}
