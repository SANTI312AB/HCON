<?php

namespace App\Form;

use App\Entity\CIE;
use App\Entity\Ciudad;
use App\Entity\Pacientes;
use App\Entity\Provincia;
use App\Entity\PuestoTrabajo;
use App\Entity\Unidadesoperativas;
use App\Repository\CIERepository;
use App\Repository\ProvinciaRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Range;


class PacientesType extends AbstractType
{
    private $cieRepository;

    public function __construct(CIERepository $cieRepository)
    {
        $this->cieRepository = $cieRepository;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tipo_identificacion', ChoiceType::class, [
                'label' => 'Tipo de Documento de Identificación',
                'required' => true,
                'placeholder' => 'Tipo de Documento de Identificación',
                'choices' => [
                    'Cédula' => 'Cédula',
                    'Pasaporte' => 'Pasaporte',
                ]
            ])
            ->add('cedula', TextType::class, [
                'label' => 'N-Documento de Identificación',
                'constraints' => [new Regex([
                    'pattern' => '/^[0-9,$]|[A-Z]*$/',
                    'message' => "El campo solo acepta numeros y letras en mayusculas"
                ])]
            ])
            ->add('image', FileType::class, [
                'label' => 'Imagen del Paciente',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '500k',
                        'mimeTypes' => ['image/jpeg'],
                        'mimeTypesMessage' => 'Porfavor subir una imagen en formato jpg',
                    ])
                ],
            ])
            ->add('pnombre', TextType::class, [
                'label' => 'Primer Nombre',
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('snombre', TextType::class, [
                'label' => 'Segundo Nombre',
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('papellido', TextType::class, [
                'label' => 'Primer Apellido',
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('sapellido', TextType::class, [
                'label' => 'Segundo Apellido',
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('email_paciente', EmailType::class, [
                'label' => 'Correo Electrónico',
            ])
            ->add('celular', TextType::class, [
                'label' => 'Número celular',
                'constraints' => [new Regex([
                    'pattern' => '/^[0-9,$]*$/',
                    'message' => "El campo solo debe tener números"
                ])]
            ])
            ->add('sexo', ChoiceType::class, [
                'label' => 'Sexo',
                'placeholder' => 'Seleccione sexo',
                'choices' => [
                    'Hombre' => 'Hombre',
                    'Mujer' => 'Mujer',
                ]
            ])
            ->add('fecha_nacimiento', BirthdayType::class, [
                'label' => 'Fecha de Nacimiento',
                'years' => range(1950, date("Y")),
                'constraints' => new Range(['max' => "now"]),
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Dia',
                ]
            ])
            ->add('fecha_ingreso', BirthdayType::class, [
                'label' => 'Fecha de Ingreso al Trabajo',
                'years' => range(2000, date("Y")),
                'constraints' => new Range(['max' => "now"]),
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Dia'
                ]
            ])
            ->add('estado_civil', ChoiceType::class, [
                'required' => false,
                'label' => 'Estado Civil',
                'placeholder' => 'Estado Civil',
                'choices' => [
                    'SOLTERO/A' => 'SOLTERO/A',
                    'CASADO/A' => 'CASADO/A',
                    'VIUDO/A' => 'VIUDO/A',
                    'DIVORCIADO/A' => 'DIVORCIADO/A',
                    'UNION LIBRE' => 'UNION LIBRE',
                ]
            ])
            ->add('tipo_sangre', ChoiceType::class, [
                'label' => 'Tipo de sangre',
                'required' => false,
                'placeholder' => 'Tipo de sangre',
                'choices' => [
                    'A+' => 'A+', 'A-' => 'A-', 'B+' => 'B+', 'B-' => 'B-',
                    'AB+' => 'AB+', 'AB-' => 'AB-', 'O+' => 'O+', 'O-' => 'O-',
                ]
            ])
            ->add('discapacidad', ChoiceType::class, [
                'label' => 'Grupo de atención prioritaria',
                'choices' => [
                    'NO' => 'NO',
                    'EMBARAZADA' => 'EMBARAZADA',
                    'ENFERMEDAD CATASTROFICA' => 'ENFERMEDAD CATASTROFICA',
                    'DISCAPACIDAD' => 'DISCAPACIDAD',
                    'ADULTO MAYOR' => 'ADULTO MAYOR',
                ],
                'multiple' => true,
                'expanded' => true,
                'required' => false,
            ])
            ->add('lateralidad', ChoiceType::class, [
                'required' => false,
                'label' => 'Lateralidad',
                'placeholder' => 'Lateralidad',
                'choices' => [
                    'DERECHO' => 'DERECHO',
                    'IZQUIERDO' => 'IZQUIERDO',
                    'AMBIDIESTRO' => 'AMBIDIESTRO',
                ]
            ])
            ->add('Provincia', EntityType::class, [
                'class' => Provincia::class,
                'placeholder' => 'Provincia de residencia',
                'mapped' => false,
                'query_builder' => function (ProvinciaRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.nombre', 'ASC');
                },
                'group_by' => function (Provincia $unidad) {
                    return $unidad->getPais();
                },
                'choice_label' => 'nombre',
                'attr' => ['data-select' => 'true']
            ])
            ->add('calle_principal', TextType::class, [
                'required' => false,
                'label' => 'Calle Principal',
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('calle_secundaria', TextType::class, [
                'required' => false,
                'label' => 'Calle Secundaria',
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('sector', TextType::class, [
                'required' => false,
                'label' => 'Sector',
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('numero_casa', TextType::class, [
                'required' => false,
                'label' => 'Número de Casa',
                'attr' => ['class' => 'text-uppercase'],
            ])
            ->add('etnia', ChoiceType::class, [
                'required' => false,
                'label' => 'Etnia',
                'placeholder' => 'Etnia',
                'choices' => [
                    'INDÍGENA' => 'INDÍGENA',
                    'AFROECUATORIANO/A' => 'AFROECUATORIANO/A',
                    'MULATO/A' => 'MULATO/A',
                    'MONTUBIO/A' => 'MONTUBIO/A',
                    'MESTIZO/A' => 'MESTIZO/A',
                    'BLANCO/A' => 'BLANCO/A',
                    'NINGUNA' => 'NINGUNA',
                ]
            ])
            ->add('nivel_instruccion', ChoiceType::class, [
                'required' => false,
                'label' => 'Nivel de Instrucción',
                'placeholder' => 'Nivel de Instrucción',
                'choices' => [
                    'PRIMARIA' => 'PRIMARIA',
                    'SECUNDARIA INCOMPLETA' => 'SECUNDARIA INCOMPLETA',
                    'SECUNDARIA COMPLETA' => 'SECUNDARIA COMPLETA',
                    'TÉCNICO/TECNÓLOGO' => 'TÉCNICO/TECNÓLOGO',
                    'SUPERIOR INCOMPLETO' => 'SUPERIOR INCOMPLETO',
                    'SUPERIOR COMPLETO' => 'SUPERIOR COMPLETO',
                    'CUARTO NIVEL' => 'CUARTO NIVEL',
                    'PHD' => 'PHD'
                ]
            ])
            ->add('is_active', ChoiceType::class, [
                'label' => 'Activar/Desactivar Paciente',
                'choices' => [
                    'Activo' => 'Activo',
                    'Inactivo' => 'Inactivo',
                ]
            ])
            ->add('puesto_trabajo', EntityType::class, [
                'class' => PuestoTrabajo::class,
                'choice_label' => 'nombre',
                'attr' => ['data-select' => 'true']
            ])
            ->add('unidades_operativas', EntityType::class, [
                'class' => Unidadesoperativas::class,
                'group_by' => function (Unidadesoperativas $unidad) {
                    return $unidad->getRegional();
                },
                'choice_label' => 'nombre',
                'attr' => ['data-select' => 'true']
            ]);

        // ... dentro de buildForm ...

        $formModifier = function (FormInterface $form, $data = null) use ($builder) {
            // Si $data es un string (de la DB), lo convertimos a array.
            // Si ya es un array (del submit), lo dejamos como está.
            $selectedChoices = [];
            if (is_string($data)) {
                $selectedChoices = array_filter(explode(', ', $data));
            } elseif (is_array($data)) {
                $selectedChoices = $data;
            }

            $choices = array_combine($selectedChoices, $selectedChoices);

            $tipoDiscapacidadBuilder = $builder->create('tipo_discapacidad', ChoiceType::class, [
                'label' => 'Atención prioritaria (Diagnóstico CIE-10)',
                'required' => false,
                'multiple' => true,
                'choices' => $choices,
                'auto_initialize' => false,
                'attr' => [
                    'class' => 'select2-ajax',
                    // Importante: No forzar el atributo 'name' aquí, dejar que Symfony lo maneje
                ],
            ]);

            $tipoDiscapacidadBuilder->addModelTransformer(new CallbackTransformer(
                function ($string) {
                    return $string ? explode(', ', $string) : []; },
                function ($array) {
                    return $array ? implode(', ', array_unique((array) $array)) : null; }
            ));

            $form->add($tipoDiscapacidadBuilder->getForm());
        };

        // Listener para carga inicial
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) use ($formModifier) {
            $paciente = $event->getData();
            $formModifier($event->getForm(), $paciente ? $paciente->getTipoDiscapacidad() : null);
        });

        // Listener para el envío - AQUÍ ES DONDE CAPTURAMOS LA DATA
        $builder->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event) use ($formModifier) {
            $data = $event->getData();
            if (isset($data['tipo_discapacidad'])) {
                // Pasamos el array directamente al modifier
                $formModifier($event->getForm(), $data['tipo_discapacidad']);
            }
        });




        // --- LÓGICA PARA PROVINCIA -> CIUDAD ---
        $builder->get('Provincia')->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $form = $event->getForm();
            $provincia = $form->getData();
            $form->getParent()->add('Ciudad', EntityType::class, [
                'class' => Ciudad::class,
                'placeholder' => 'Cantón de Residencia',
                'required' => false,
                'choices' => $provincia ? $provincia->getCiudad() : [],
                'choice_label' => 'nombre',
                'attr' => ['data-select' => 'true']
            ]);
        });

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $form = $event->getForm();
            $data = $event->getData();
            $ciudad = $data ? $data->getCiudad() : null;

            if ($ciudad) {
                $form->get('Provincia')->setData($ciudad->getProvincia());
                $form->add('Ciudad', EntityType::class, [
                    'class' => Ciudad::class,
                    'required' => false,
                    'placeholder' => 'Cantón de Residencia',
                    'choices' => $ciudad->getProvincia()->getCiudad(),
                    'choice_label' => 'nombre',
                    'attr' => ['data-select' => 'true']
                ]);
            } else {
                $form->add('Ciudad', EntityType::class, [
                    'class' => Ciudad::class,
                    'required' => false,
                    'placeholder' => 'Cantón de Residencia',
                    'choices' => [],
                    'attr' => ['data-select' => 'true']
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Pacientes::class,
        ]);
    }
}