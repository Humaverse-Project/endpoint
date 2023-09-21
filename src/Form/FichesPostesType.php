<?php

namespace App\Form;

use App\Entity\FichesPostes;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FichesPostesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fiches_postes_titre')
            ->add('fiches_postes_validation_at')
            ->add('fiches_postes_visa_at')
            ->add('fiches_postes_activite')
            ->add('fiches_postes_definition')
            ->add('fiches_postes_agrement')
            ->add('conditions_generales')
            ->add('instructions')
            ->add('created_at')
            ->add('updated_at')
            ->add('fiches_postes_version')
            ->add('fiches_postes_fiche_competence')
            ->add('fiches_postes_fiche_rome')
            ->add('fiches_postes_liaison_hierarchique')
            ->add('fiches_postes_nplus1')
            ->add('fiches_postes_liaison_fonctionnelle')
            ->add('fiches_postes_convention_collective')
            ->add('fiches_postes_entreprise')
            ->add('formations')
            ->add('fiches_postes_parcours_professionnel')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FichesPostes::class,
        ]);
    }
}
