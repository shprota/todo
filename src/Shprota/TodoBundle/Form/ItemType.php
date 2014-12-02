<?php

namespace Shprota\TodoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('done')
            ->add('created', 'text', ['mapped' => false])
            ->add('updated', 'text', ['mapped' => false])
            ->add('id', null, ['mapped' => false])
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Shprota\TodoBundle\Entity\Item',
	        'csrf_protection' => false,
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'shprota_todobundle_item';
    }
}
