<?php

namespace App\Form;

use App\Constant\Content;
use App\Entity\Documentation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DocumentationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'nom',
                'attr' => [
                    'class' => 'form-control fullname',
                    'placeholder' => 'Prénom',
                ],
                'row_attr' => [
                    'class' => 'fv-row mb-2'
                ],
                'required' => false
            ])

           ->add('description', TextType::class, [
                'label' => 'Téléphone',
                'attr' => [
                    'class' => 'form-control phone',
                    'placeholder' => 'Téléphone',
                ],
                'row_attr' => [
                    'class' => 'fv-row mb-2'
                ],
                'required' => false
            ])

           ->add('status', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => array_flip(Content::DOCUMENTATION_STATUS_LIST),
                'attr' => [
                    'class' => 'form-select',
                ],
                'row_attr' => [
                    'class' => 'fv-row mb-2'
                ],
            ])

            ->add('submit', SubmitType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'btn btn-primary me-1',
                ],
                'row_attr'  => [
                    'class'     => 'col-md-2 mb-8 float-right'
                ],
            ]);
  
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Documentation::class,
        ]);
    }
}
