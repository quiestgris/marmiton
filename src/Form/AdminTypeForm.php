<?php

namespace App\Form;

use App\Entity\Admin;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class AdminTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'minLength' => '2',
                    'maxLength' => '50'
                ],
                "required" => false,
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                "constraints" => [
                    new Assert\NotBlank(),
                    new Assert\Length(['min' => 2, 'max' => 50]) 
                ]
                ])
            ->add('pseudonyme', TextType::class, [
                "attr" => [
                    'class' => 'form-control',
                    'minLength' => '2',
                    'maxLength' => '50',
                    
                ],
                "required" => false,
                'label' => 'Pseudonyme',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                "constraints" => [

                    new Assert\Length(['min' => 2, 'max' => 50]) 
                ]
                ])
                ->add('plainPassword', PasswordType::class, [
                "attr" => [
                    'class' => 'form-control',
                    
                ],
                'label' => 'Mot de passe',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                "constraints" => [
                    new Assert\NotBlank(),
                ]
                ])
                ->add('submit', SubmitType::class, [
                'attr' => [
                    "class" => 'btn'
                ],
                'label' => 'Enregistrer'
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Admin::class,
        ]);
    }
}
