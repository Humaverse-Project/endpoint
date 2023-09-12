<?php

namespace App\Form;

use App\Entity\ContextesTravail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContextesTravailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ctx_trv_titre')
            ->add('created_at')
            ->add('updated_at')
            ->add('ctx_trv_categorie')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ContextesTravail::class,
        ]);
    }
}
