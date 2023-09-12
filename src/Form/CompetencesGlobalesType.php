<?php

namespace App\Form;

use App\Entity\CompetencesGlobales;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CompetencesGlobalesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('comp_gb_titre')
            ->add('comp_gb_categorie')
            ->add('created_at')
            ->add('updated_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompetencesGlobales::class,
        ]);
    }
}
