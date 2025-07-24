<?php

namespace App\Form;

use App\Entity\Contact;
use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'class' => 'form-control user-email',
                    'placeholder' => 'Email',
                ],
                'row_attr' => [
                    'class' => 'fv-row mb-2'
                ],
                    'constraints' => [
                    new NotBlank(),
                    new Email(),
                ],
                'required' => false
            ])
            ->add('name', TextType::class, [
                'label' => 'Prénom',
                'attr' => [
                    'class' => 'form-control fullname',
                    'placeholder' => 'Prénom',
                ],
                'row_attr' => [
                    'class' => 'fv-row mb-2'
                ],
                'required' => false
            ])
           ->add('phone', TextType::class, [
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
           ->add('submit', SubmitType::class, [
                'label' => 'SEND',
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
            'data_class' => Contact::class,
        ]);
    }
}
