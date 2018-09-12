<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DSDType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('title', TextType::class,[
            'label' => 'Title',
            'required' => true,
        ]);

        $builder->add('manufacturer', TextType::class,[
            'label' => 'Manufacturer',
            'required' => false,
        ]);

        $builder->add('file', VichFileType::class,[
            'label' => 'Upload a file',
            'required' => false,
            'download_link' => true,
            'allow_delete' => true,
        ]);

        $builder->add('itemSds', NumberType::class,[
            'label' => '#Item / #SDS',
            'required' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\DSD'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_dsd';
    }


}
