<?php

namespace App\Form;

use App\Entity\CIE;
use App\Entity\Consulta;
use App\Entity\Diagnostico;
use App\Entity\Medicamentos;
use App\Entity\Pacientes;
use App\Repository\ConsultaRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DiagnosticoEdit2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('cie',EntityType::class,[
            'disabled' => true,
            'label'=>'Clasificación Internacional de Enfermedades',
            'class'=>CIE::class,
            'choice_label'=>function (CIE $materia) {
                return  $materia->getCodigo(). ': ' . $materia->getDescripcion();},
            'attr' => ['data-select' => 'true'],
           
        ])
        /*
        ->add('consulta',EntityType::class,[
            'label'=>'Lista de Consultas',
            'class'=>Consulta::class,
            'query_builder' => function (ConsultaRepository $er) use ($options) {
                return $er->createQueryBuilder('c')
                    ->innerJoin('c.pacientes', 'p')
                    ->where('p.id = :paciente_id')
                    ->andWhere('c.fecha_atencion <= :fecha_consulta')
                    ->setParameter('fecha_consulta',$options['consulta']->getFechaAtencion())
                    ->setParameter('paciente_id',$options['paciente']->getId());
            },
            'choice_label' => 'datos',
        ])*/
        ->add('tipo_diagnostico',ChoiceType::class,[
            'disabled' => true,
            'label'=>'Tipo de diagnóstico',
            'choices'=>[
                'PRESUNTIVO' => 'PRESUNTIVO',
                'DEFINITIVO' => 'DEFINITIVO',
            ],
            

        ])
        ->add('solicitud',TextType::class,[
            'disabled' => true,
            'required'=>false,
            'disabled' => true,
            'label'=>'Exámenes de Laboratorio',
            'attr' => ['class' => 'text-uppercase' ], 
            
        ])
        ->add('solicitud_complementaria',TextType::class,[
            'disabled' => true,
            'required'=>false,
            'label'=>'Exámenes Complementarios',
            'attr' => ['class' => 'text-uppercase' ], 
            
        ])

        ->add('procedimiento',TextType::class,[
            'disabled' => true,
            'required'=>false,
            'label'=>'Fisioterapia',
            'attr' => ['class' => 'text-uppercase' ], 
        ])
        ->add('interconsulta',TextType::class,[
            'disabled' => true,
            'required'=>false,
            'label'=>'Interconsulta',
            'attr' => ['class' => 'text-uppercase' ], 
        ])
        


            ->getForm();
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
          /*  
        'data_class' => Diagnostico::class,*/
        ]);
    }
}
