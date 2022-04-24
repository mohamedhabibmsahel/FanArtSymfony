<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, array(

                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom')
            ))
            ->add('prenom',TextType::class, array(

                'label' => false,
                'attr' => array(
                    'placeholder' => 'Prenom')
            ))




            ->add('email',TextType::class, array(

                'label' => false,
                'attr' => array(
                    'placeholder' => 'Email')
            ))
            ->add('numtel',IntegerType::class, array(

                'label' => false,
                'attr' => array(
                    'placeholder' => 'Numéro de téléphone')
            ))

            ->add('photo',FileType::class, array('data_class' => null,

                'label' => false,
                'attr' => array(
                    'placeholder' => 'Choisir photo','accept'=>'.jpg, .jpeg, .png','required' => false)
            ))
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Client' => 'client',
                    'Artiste' => 'artiste',
                ],
            ])


        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
