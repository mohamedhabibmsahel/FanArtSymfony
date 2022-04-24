<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Recprod;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Repository\ProduitRepository;

class RecpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomprod', EntityType::class, [
                'class' => Produit::class,
                'choice_label' => function ($p) {
                    return $p->getTitre();
                },
                'choice_value' => function (?Produit $entity) {
                    return $entity ? $entity->getTitre() : '';
                },

            ])
            ->add('reclprod',TextType::class)
            ->add('Enregistrer',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Recprod::class,
        ]);
    }
}
