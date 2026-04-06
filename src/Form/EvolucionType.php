<?php

namespace App\Form;

use App\Entity\Evolucion;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class EvolucionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('descripcion',TextareaType::class,[
                 'label'=> 'Notas de Evolución Médica',
                 'constraints' => [
                    new NotBlank([
                        'message' => 'El campo no puede estar en blanco.',
                    ]),
                    new Length([
                        'max' => 300,
                        'maxMessage' => 'La descripción no puede exceder los {{ limit }} caracteres.',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evolucion::class,
        ]);
    }
}
