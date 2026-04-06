<?php

namespace App\Form;

use App\Entity\Medicamentos;
use App\Entity\Tratamiento;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TratamientoType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('presentacion', ChoiceType::class, [
                'required' => false,
                'label' => 'Presentación',
                'choices' => [
                    'TABLETA' => 'TABLETA',
                    'AMPOLLETA' => 'AMPOLLETA',
                    'CÁPSULA' => 'CÁPSULA',
                    'JARABE' => 'JARABE',
                    // ... el resto de tus opciones
                ]
            ])
            ->add('dosis', ChoiceType::class, [
                'required' => false,
                'label' => 'Dosis',
                'choices' => [
                    '1 TABLETA' => '1 TABLETA',
                    '5 ML' => '5 ML',
                    // ... el resto de tus opciones
                ]
            ])
            ->add('frecuencia', ChoiceType::class, [
                'required' => false,
                'label' => 'Frecuencia',
                'choices' => [
                    'CADA 8 HORAS' => 'CADA 8 HORAS',
                    'CADA 12 HORAS' => 'CADA 12 HORAS',
                    'CADA 24 HORAS' => 'CADA 24 HORAS',
                ]
            ])
            ->add('duracion', ChoiceType::class, [
                'required' => false,
                'label' => 'Duración',
                'choices' => [
                    '3 DÍAS' => '3 DÍAS',
                    '7 DÍAS' => '7 DÍAS',
                    '30 DÍAS' => '30 DÍAS',
                ]
            ])
            ->add('cantidad', NumberType::class, [
                'required' => false,
                'label' => 'Cantidad',
            ])
            ->add('indicaciones', TextareaType::class, [
                'label' => 'Indicaciones',
                'attr' => ['class' => 'text-uppercase'],
            ]);

        // Función para modificar el campo dinámicamente
        // En TratamientoType.php
        $formModifier = function ($form, Medicamentos $medicamento = null) {
            $form->add('medicamentos', EntityType::class, [
                'class' => Medicamentos::class,
                'placeholder' => 'Seleccione un Medicamento',
                'choices' => $medicamento ? [$medicamento] : [], // Si es EDITAR, aquí viene el objeto
                'choice_label' => function (Medicamentos $m) {
                    // Este formato debe coincidir con el 'text' del JS
                    return "[" . $m->getCodigo() . "] " . $m->getDescripcion();
                },
                'attr' => [
                    'class' => 'select2-ajax-medicamentos',
                    'data-select' => 'true'
                ]
            ]);
        };

        // 1. Al cargar (Para Editar: muestra el medicamento guardado)
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
            $data = $event->getData();
            $medicamento = $data ? $data->getMedicamentos() : null;
            $formModifier($event->getForm(), $medicamento);
        });

        // 2. Al enviar (Captura el ID enviado por Select2)
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($formModifier) {
            $data = $event->getData();
            $medicamentoId = $data['medicamentos'] ?? null;

            if ($medicamentoId) {
                $medicamento = $this->em->getRepository(Medicamentos::class)->find($medicamentoId);
                $formModifier($event->getForm(), $medicamento);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tratamiento::class,
        ]);
    }
}