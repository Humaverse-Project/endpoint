<?php

namespace App\Form;

use App\Entity\Rome;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RomeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rome_titre')
            ->add('rome_coderome')
            ->add('rome_definition')
            ->add('rome_acces_metier')
            ->add('created_at')
            ->add('updated_at')
            ->add('fiches_rome_proches')
            ->add('fiches_rome_evolution')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Rome::class,
        ]);
    }
}
