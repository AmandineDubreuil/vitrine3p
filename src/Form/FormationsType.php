<?php

namespace App\Form;

use App\Entity\Formations;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre')
            ->add('reference')
            ->add('duree')
            ->add('public')
            ->add('prerequis')
            ->add('tarif')
            ->add('objectifs')
            ->add('reussite')
            ->add('satisfaction')
            ->add('effectif')
            ->add('cpf')
            ->add('modalitepedago')
            ->add('validation')
            ->add('acces')
            ->add('referencesreglementaires')
            ->add('programme')
            ->add('photo')
            ->add('modifiedAt')
            ->add('moyenspedagogiques')
            ->add('documents')
            ->add('referentpedagogique')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formations::class,
        ]);
    }
}
