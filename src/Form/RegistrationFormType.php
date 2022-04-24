<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Captcha\Bundle\CaptchaBundle\Form\Type\CaptchaType;
use Captcha\Bundle\CaptchaBundle\Validator\Constraints\ValidCaptcha;

class RegistrationFormType extends AbstractType
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

            ->add('mdp', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passes ne sont pas identique',
                'attr' => ['class' => 'tinymce'],
                'first_options' => [ 'label' => false,'attr' => ['placeholder' => 'Mot de passe']],
                'second_options' => ['label' => false, 'attr' => ['placeholder' => 'Nouveau mot de passe']],

            ])
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
                    'placeholder' => 'Choisir photo','accept'=>'.jpg, .jpeg, .png')


            ))
            ->add('type', ChoiceType::class, [
                'choices'  => [
                    'Client' => 'client',
                    'Artiste' => 'artiste',
                ],
            ])

            ->add('captchaCode', CaptchaType::class, array(
                'captchaConfig' => 'ExampleCaptchaUserRegistration',
                'constraints' => [
                    new ValidCaptcha([
                        'message' => 'Captcha incorrect',
                    ]),
                ],
            ))
            ->add('Creer Compte',SubmitType::class)
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
