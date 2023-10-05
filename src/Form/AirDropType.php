<?php

namespace App\Form;

use App\Entity\AirDrop;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AirDropType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('nftQuantity')
            ->add('category')
            ->add('launchPrice')
            ->add('webSiteUrl')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => AirDrop::class,
        ]);
    }
}
