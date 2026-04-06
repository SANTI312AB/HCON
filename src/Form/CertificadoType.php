<?php

namespace App\Form;

use App\Entity\Certificado;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CertificadoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
// Configuración del campo fecha_inicio
->add('fecha_inicio', DateTimeType::class, [
    'data' => new \DateTime(), // Valor por defecto: fecha y hora actuales
    'date_widget' => 'single_text',
    'html5' => false,
    'format' => 'yyyy-MM-dd HH:mm', // Formato de fecha y hora
    'constraints' => [
        new LessThanOrEqual([
            'value' => 'now',
            'message' => 'La fecha de inicio no puede ser posterior a la fecha actual.',
        ]),
    ]
])

// Configuración del campo fecha_final
->add('fecha_final', DateTimeType::class, [
    'data' => new \DateTime(), // Valor por defecto: fecha y hora actuales
    'date_widget' => 'single_text',
    'html5' => false,
    'format' => 'yyyy-MM-dd HH:mm', // Formato de fecha y hora
    'constraints' => [
        new GreaterThanOrEqual([
            'value' => (new \DateTime())->setTime(0, 0), // Fecha actual
            'message' => 'La fecha final debe ser igual o posterior a la fecha actual.',
        ]),
    ],
])
        ->add('tipo_contingencia',ChoiceType::class,[
            'label'=>'Tipo de contingencia',
            'placeholder'=>'Seleccione tipo de contingencia',
            'choices'=>[
             'Enfermedad general' => 'Enfermedad general',
             'Accidente de trabajo' => 'Accidente de trabajo',
             'Emergencia' => 'Emergencia',
            ]
        ])
        ->add('licencia',ChoiceType::class,[
            'label'=>'Licencia por',
            'placeholder'=>'Seleccione tipo de licencia',
            'choices'=>[
             'Reposo médico' => 'Reposo médico',
             'Teletrabajo' => 'Teletrabajo',
            ]
        ])
        ->add('empresa')
        ->add('contacto')
        ->add('telefono',TextType::class,[
            'label'=>'Teléfono',
            'constraints' => [new Regex([
                'pattern'=>'/^[0-9,$]*$/',
                'message' =>"El campo solo debe tener números"
             ])
        ] ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Certificado::class,
        ]);
    }
}
