<?php

namespace App\Form;

use App\Entity\Consulta;
use App\Entity\Employed;
use App\Repository\EmployedRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class ConsultaTypeEdit extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       
        $builder
            ->add('motivo_consulta',ChoiceType::class,[
                'placeholder'=>'Seleccione Motivo de Consulta',
                'choices'=>[
                 'Ingreso' => 'Ingreso',
                 'Periódica' => 'Periódica',
                 'Salida' => 'Salida',
                 'Reingreso' => 'Reingreso',
                ]
            ])
            ->add('fecha_atencion',DateTimeType::class,[
                'label'=>'Fecha motivo de consulta',
                'placeholder' => [
                    'year' => 'Año', 'month' => 'Mes', 'day' => 'Día'
                   
                ]
            ])
            ->getForm()
        ;

        
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Consulta::class,
        ]);
    }
}
