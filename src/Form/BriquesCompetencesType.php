<?php

namespace App\Form;

use App\Entity\BriquesCompetences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BriquesCompetencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('brq_comp_titre')
            ->add('created_at')
            ->add('updated_at')
            ->add('comp_gb')
            ->add('rome')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BriquesCompetences::class,
        ]);
    }
}
