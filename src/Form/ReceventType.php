<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Produit;
use App\Entity\Recevent;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReceventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomevent', EntityType::class, [
                'class' => Evenement::class,
                'choice_label' => function ($p) {
                    return $p->getTitre();
                },
                'choice_value' => function (?Evenement $entity) {
                    return $entity ? $entity->getTitre() : '';
                },

            ])
            ->add('reclevent')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recevent::class,
        ]);
    }
}
