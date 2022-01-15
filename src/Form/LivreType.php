<?php

namespace App\Form;

use App\Entity\Livre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LivreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('isbn',null,[
                'attr'=>[
                    'placeholder'=>'ISBN' ,
                    'class'=>'uk-input mb-3 mt-3'
                ]
            ])
            ->add('titre',null,[
                'attr'=>[
                    'placeholder'=>'Titre' ,
                    'class'=>'uk-input mb-3 mt-3'
                ]
            ])
            ->add('nombre_pages',NumberType::class,[
                'attr'=>[
                    'min'=>0,
                    'placeholder'=>'Nombre de page' ,
                    'class'=>'uk-input mb-3 mt-3'
                ]
            ])
            ->add('date_de_parution',BirthdayType::class,[
                'widget'=>'single_text',
                'attr'=>[
                    'class'=>'uk-input mb-3 mt-3'
                ]
            ])
            ->add('note',NumberType::class,[
                    'attr'=>[
                        'min'=>0,
                        'max'=>20,
                        'placeholder'=>'Note',
                        'class'=>'uk-input mb-3 mt-3'
                    ]
            ])
            ->add('auteurs',null,[
                'attr'=>[
                    'class'=>'uk-select mb-3 mt-3'
                ]
            ])
            ->add('genres',null,[
                'attr'=>[
                    'class'=>'uk-select mb-3 mt-3'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Livre::class,
        ]);
    }
}
