<?php

namespace App\Form;

use App\Entity\SignosVitales;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Form\Extension\Core\Type\NumberType;


class SignosVitalesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('estatura',NumberType::class,[
            'required' => false,
            'constraints' => new Range(['min' => 50,'max'=>300]),
        ])
        ->add('peso',NumberType::class,[
            'required' => false,

            'constraints' => new Range(['min' =>25.00,'max'=>500.00]),
        ])
        ->add('temperatura',NumberType::class,[
            'required' => false,
            'constraints' => new Range(['min' =>34.00,'max'=>42.00]),
        ])
        ->add('frecuencia_respiratoria',NumberType::class,[
            'required' => false,

            'constraints' => new Range(['min' => 9,'max'=>21]),
        ])
        ->add('sistole',NumberType::class,[
            'required' => false,
            'label'=>'Presion Arterial Sistólica',
            
            'constraints' => new Range(['min' => 40,'max'=>180]),
        ])
        ->add('diastole',NumberType::class,[
            'label'=>'Presion Arterial Diastólica',
            'required' => false,
            'constraints' => new Range(['min' => 40,'max'=>120]),
        ])
        ->add('frecuencia_cardiaca',NumberType::class,[
            'required' => false,
            'constraints' => new Range(['min' => 40,'max'=>150]),
        ])
        ->add('grasa_corporal',NumberType::class,[
            'required' => false,
            'label'=>' Porcentaje de Grasa Corporal',
            'constraints' => new Range(['min' => 1,'max'=>50]),
        ])
         /**Adecuado No adecuado */
        ->add('masa_muscular',ChoiceType::class,[
            'required'=>false,
            'placeholder'=>'Seleccione un estado',
            'choices'=>[
             'Adecuado' => 'Adecuado',
             'No adecuado' => 'No adecuado',
            ]
        ])
        ->add('saturacion_oxigeno',NumberType::class,[
            'required' => false,
            'constraints' => new Range(['min' => 80,'max'=>100]),
        ])
        ->add('grasa_visceral',NumberType::class,[
            'required' => false,
            'constraints' => new Range(['min' => 1,'max'=>100]),
        ])
        /**Adecuado No adecuado */
        ->add('hidratacion',ChoiceType::class,[
            'required'=>false,
            'placeholder'=>'Seleccione un estado',
            'choices'=>[
             'Adecuado' => 'Adecuado',
             'No adecuado' => 'No adecuado',
            ]
        ])

        ->add('cintura',NumberType::class,[
            'required' => false,
            'constraints' => new Range(['min' => 10,'max'=>200]),
        ])

        ->add('glucosa_ayunas',NumberType::class,[
            'required' => false,
            'constraints' => new Range(['min' => 50,'max'=>600]),
        ])

        ->add('glucosa_post',NumberType::class,[
            'required' => false,
            'constraints' => new Range(['min' => 50,'max'=>600]),
        ])
        
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SignosVitales::class,
        ]);
    }
}
