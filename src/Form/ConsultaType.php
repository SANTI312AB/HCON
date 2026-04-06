<?php

namespace App\Form;

use App\Entity\Consulta;
use App\Entity\Employed;
use App\Repository\EmployedRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Intl\Timezones;

class ConsultaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('motivo_consulta', ChoiceType::class, [
                'label' => 'Motivo de consulta',
                'placeholder' => 'Seleccione el motivo de consulta',
                'choices' => [
                    'Ingreso' => 'Ingreso',
                    'Periódica' => 'Periódica',
                    'Salida' => 'Salida',
                    'Reingreso' => 'Reingreso',
                    'Médica' => 'Médica',
                ]
            ])

            ->add('fecha_atencion', DateType::class, [ // Cambiado a DateType
                'label' => 'Fecha motivo de consulta',
                'widget' => 'choice', // Esto mantiene los desplegables de Año, Mes, Día
                'data' => new \DateTime(), // Corregido: \DateTime en lugar de \Date
                'years' => range(2019, date("Y")),
                'constraints' => [
                    new Range(['max' => 'now'])
                ],
                'placeholder' => [
                    'year' => 'Año',
                    'month' => 'Mes',
                    'day' => 'Día'
                ]
            ])
            ->add('estatura', NumberType::class, [
                'label' => 'Estatura (cm)',
                'required' => false,
                'constraints' => new Range(['min' => 50, 'max' => 300]),
            ])
            ->add('peso', NumberType::class, [
                'label' => 'Peso (kg)',
                'required' => false,
                'constraints' => new Range(['min' => 25.00, 'max' => 500.00]),
            ])
            ->add('temperatura', NumberType::class, [
                'required' => false,
                'constraints' => new Range(['min' => 34.00, 'max' => 42.00]),
            ])
            ->add('frecuencia_respiratoria', NumberType::class, [
                'required' => false,
                'constraints' => new Range(['min' => 9, 'max' => 21]),
            ])
            ->add('sistole', NumberType::class, [
                'label' => 'Presion Arterial Sistólica',
                'required' => false,
                'constraints' => new Range(['min' => 40, 'max' => 180]),
            ])
            ->add('diastole', NumberType::class, [
                'label' => 'Presión Arterial Diastólica',
                'required' => false,
                'constraints' => new Range(['min' => 40, 'max' => 120]),
            ])
            ->add('frecuencia_cardiaca', NumberType::class, [
                'required' => false,
                'constraints' => new Range(['min' => 40, 'max' => 150]),
            ])
            ->add('grasa_corporal', NumberType::class, [
                'required' => false,
                'label' => ' Porcentaje de Grasa Corporal',
                'constraints' => new Range(['min' => 1, 'max' => 50]),
            ])
            /**Adecuado No adecuado */
            ->add('masa_muscular', ChoiceType::class, [
                'required' => false,
                'placeholder' => 'Seleccione un estado',
                'choices' => [
                    'Adecuado' => 'Adecuado',
                    'No adecuado' => 'No adecuado',
                ]
            ])
            ->add('saturacion_oxigeno', NumberType::class, [
                'label' => 'Saturación de oxígeno',
                'required' => false,
                'constraints' => new Range(['min' => 80, 'max' => 100]),
            ])
            ->add('grasa_visceral', NumberType::class, [
                'required' => false,
                'constraints' => new Range(['min' => 1, 'max' => 100]),
            ])
            /**Adecuado No adecuado */
            ->add('hidratacion', ChoiceType::class, [
                'label' => 'Hidratación',
                'required' => false,
                'placeholder' => 'Seleccione un estado',
                'choices' => [
                    'Adecuado' => 'Adecuado',
                    'No adecuado' => 'No adecuado',
                ]
            ])
            ->add('cintura', NumberType::class, [
                'label' => 'Circunferencia abdominal (cm)',
                'required' => false,
                'constraints' => new Range(['min' => 10, 'max' => 200]),
            ])

            ->add('glucosa_ayunas', NumberType::class, [
                'label' => 'Glucosa en ayunas',
                'required' => false,
                'constraints' => new Range(['min' => 50, 'max' => 600]),
            ])

            ->add('glucosa_post', NumberType::class, [
                'label' => 'Glucosa Postpandrial',
                'required' => false,
                'constraints' => new Range(['min' => 50, 'max' => 600]),
            ])
            ->getForm();





    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // 'data_class' => Consulta::class,
        ]);
    }
}
