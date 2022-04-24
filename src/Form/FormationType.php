<?php

namespace App\Form;

use App\Entity\Formation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('domaine', ChoiceType::class,[
                'choices' =>[
                    '' =>[
                        'Aucun' =>'Aucun',
                        'Arts du spectacle vivant' =>'Arts du spectacle vivant',
                        'Arts de l’espace' =>'Arts de l’espace',
                        'Arts du visuel' =>'Arts du visuel',
                        'Arts du quotidien' =>'Arts du quotidien',
                        'Arts du son' =>'Arts du son',
                        'Arts du langage' =>'Arts de l’espaceArts du langage',

                    ],
                ],
            ])

            ->add('nomformation',TextType::class,['label'=>'Nom de formation '])
           // ->add('datedebut',TextType::class,['label'=>'Date debut '])
           // ->add('datefin',TextType::class,['label'=>'Date fin '])
            ->add('description',TextareaType::class,['label'=>'Description '])
            ->add('prix',TextType::class,['label'=>'Prix inscription'])
            //->add('Enregistrer',SubmitType::class)
            ->add('Annuler',ResetType::class)
           // ->add('Modifier',SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formation::class,]);
    }
}
