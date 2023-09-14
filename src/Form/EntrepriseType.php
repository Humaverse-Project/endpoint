<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('entreprise_nom')
            ->add('entreprise_siret')
            ->add('entreprise_ape_naf')
            ->add('entreprise_url')
            ->add('entreprise_adresse')
            ->add('entreprise_code_postal')
            ->add('entreprise_ville')
            ->add('entreprise_pays')
            ->add('entreprise_telephone')
            ->add('entreprise_email')
            ->add('entreprise_effectif')
            ->add('entreprise_etablissement')
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
