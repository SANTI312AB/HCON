<?php

namespace App\Form;

use App\Entity\CIE;
use App\Entity\Diagnostico;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiagnosticoType extends AbstractType
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo_diagnostico', ChoiceType::class, [
                'label' => 'Tipo de Diagnóstico',
                'choices' => [
                    'Escoja el tipo' => '',
                    'PRESUNTIVO' => 'PRESUNTIVO',
                    'DEFINITIVO' => 'DEFINITIVO',
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('solicitud', TextType::class, [
                'required' => false,
                'label' => 'Pedido de Examen de Laboratorio',
                'attr' => ['class' => 'text-uppercase']
            ])
            ->add('solicitud_complementaria', TextType::class, [
                'required' => false,
                'label' => 'Pedido de Examen Complementario',
                'attr' => ['class' => 'text-uppercase']
            ])
            ->add('procedimiento', TextType::class, [
                'required' => false,
                'label' => 'Pedido de Fisioterapia',
                'attr' => ['class' => 'text-uppercase']
            ])
            ->add('interconsulta', TextType::class, [
                'required' => false,
                'label' => 'Pedido de Interconsulta',
                'attr' => ['class' => 'text-uppercase']
            ]);

        // Modificador de campo para manejar AJAX
        $formModifier = function ($form, CIE $cie = null) {
            $form->add('cie', EntityType::class, [
                'class' => CIE::class,
                'label' => 'Clasificación Internacional de Enfermedades CIE',
                'placeholder' => 'Seleccione una Enfermedad',
                'choice_label' => function (CIE $cie) {
                    return '[' . $cie->getCodigo() . '] ' . $cie->getDescripcion();
                },
                // Crucial: el valor en el <option value="..."> será la descripción
                'choice_value' => 'descripcion', 
                'choices' => $cie ? [$cie] : [],
                'attr' => [
                    'class' => 'select2-ajax-cie',
                    'data-select' => 'true'
                ]
            ]);
        };

        // 1. Escuchar cuando se carga el formulario (Editar)
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
            $data = $event->getData();
            $cie = $data ? $data->getCie() : null;
            $formModifier($event->getForm(), $cie);
        });

        // 2. Escuchar cuando se envía el formulario (Guardar)
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($formModifier) {
            $data = $event->getData();
            $cieValue = $data['cie'] ?? null;

            if ($cieValue) {
                // Buscamos por descripcion porque el controlador AJAX manda texto en el ID
                $cie = $this->em->getRepository(CIE::class)->findOneBy([
                    'descripcion' => $cieValue
                ]);
                $formModifier($event->getForm(), $cie);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Diagnostico::class,
        ]);
    }
}