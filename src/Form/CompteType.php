<?php

namespace App\Form;

use App\Entity\Compte;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('compte_nom')
            ->add('compte_prenom')
            ->add('compte_email')
            ->add('compte_nom_utilisateur')
            ->add('compte_mot_de_passe')
            ->add('compte_role')
            ->add('created_at')
            ->add('updated_at')
            ->add('compte_telephone')
            ->add('compte_service')
            ->add('compte_entreprise_id')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Compte::class,
        ]);
    }
}
