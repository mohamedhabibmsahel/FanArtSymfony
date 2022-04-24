<?php

namespace App\Form;

use App\Entity\Salle;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ResetType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\DomCrawler\Field\TextareaFormField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SalleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('numsalle',TextType::class, ['label'=> 'Numero salle'])
            ->add('nbreplace',TextType::class,['label'=>'Nombre de places'])
            ->add('description',TextareaType::class,['label'=>'Description '])
            ->add('image',FileType::class,['mapped'=>false,'required' => false])
            ->add('Annuler',ResetType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => Salle::class,]);
    }
}
