<?php

namespace App\Form;

use App\Entity\Consulta;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class AnamnesisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('anamnesis',TextareaType::class,[
                'label' => 'Anamnesis',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Por favor, ingresa datos.',
                    ]),
                    new Length([
                        'max' => 3000,
                        'maxMessage' => 'Este campo no puede tener más de {{ limit }} caracteres.',
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Consulta::class,
        ]);
    }
}
