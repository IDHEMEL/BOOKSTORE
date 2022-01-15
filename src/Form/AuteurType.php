<?php

namespace App\Form;

use App\Entity\Auteur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuteurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_prenom',null,[
                'attr'=>[
                    'placeholder' => 'Nom & Prénom',
                    'class'=>'uk-input mb-3 mt-3'
                ]
            ])
            ->add('sexe', ChoiceType::class,[
                'choices' => [
                    "----- Selectinner le sexe -----"=>"",
                    "Male"=>"M",
                    "Female"=>"F",
                ],
                'attr'=>[
                    'class'=>'uk-select mb-3 mt-3'
                ]
            ])
            ->add('date_de_naissance',BirthdayType::class,[
                'widget' => 'single_text',
                'attr'=>[
                    'class'=>'uk-input mb-3 mt-3'
                ]
            ])
            ->add('nationalite',CountryType::class,[
                'attr'=>[
                    'class'=>'uk-select mb-3 mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Auteur::class,
        ]);
    }
}
