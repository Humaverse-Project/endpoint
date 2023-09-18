<?php

namespace App\Form;

use App\Entity\FichesCompetences;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichesCompetencesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fic_comp_titre_emploi')
            ->add('fic_comp_competences_niveau')
            ->add('fic_comp_version')
            ->add('created_at')
            ->add('updated_at')
            ->add('fic_comp_competences')
            ->add('fic_comp_accreditations')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FichesCompetences::class,
        ]);
    }
}
