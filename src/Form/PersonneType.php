<?php

namespace App\Form;

use App\Entity\Personne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('personne_nom')
            ->add('personne_prenom')
            ->add('personne_email')
            ->add('personne_telephone')
            ->add('personne_adresse')
            ->add('personne_genre')
            ->add('personne_date_naissance')
            ->add('created_at')
            ->add('updated_at')
            ->add('personne_poste')
            ->add('personne_experiences')
            ->add('personne_formations')
            ->add('personne_accreditations')
            ->add('personne_compte')
            ->add('entreprise')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Personne::class,
        ]);
    }
}
