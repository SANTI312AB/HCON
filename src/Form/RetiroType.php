<?php

namespace App\Form;

use App\Entity\Consulta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RetiroType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('evaluacion_retiro',ChoiceType::class,[
                'label'=>'El usuario se realizó una evaluación medica de retiro',
                'placeholder'=>'Escoger la evaluación del retiro',
                'choices'=>[
                 'Si' => 'Si',
                 'No' => 'No',
                 
                ]
            ])
            
            ->add('condicion_diagnostico',ChoiceType::class,[
                'label'=>'Condición del Diagnóstico',
                'placeholder'=>'Escoger la condición de diagnóstico',
                'choices'=>[
                 'Presuntiva' => 'Presuntiva',
                 'Definitiva' => 'Definitiva',
                 'No Aplica' => 'No Aplica',
                 
                ]
            ]
            )
        ->add('condicion_salud',ChoiceType::class,[
            'label'=>'La condición de salud esta relacionada con el trabajo',
            'placeholder'=>'Escoger la condición de salud',
            'choices'=>[
             'Si' => 'Si',
             'No' => 'No',
             'No Aplica' => 'No Aplica',
             
            ]
        ])

        ->add('observaciones_retiro',TextType::class,[
            'label'=>'Recomendaciones',
            'attr' => ['class' => 'text-uppercase' ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consulta::class,
        ]);
    }
}
