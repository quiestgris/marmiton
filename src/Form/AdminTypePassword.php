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
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;


class AdminTypePassword extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) :void {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => 'Mot de passe',
                ],
                "required" => false,
                'mapped' => false,
                'second_options' => [
                    'attr' => [
                        'class' => 'form-control'
                    ],
                    'label' => "Confirmation du mot de passe"
                ],
                "invalid_message" => "Les mot de passe ne correspondent pas"
            ])
                ->add('newPassword', PasswordType::class, [
                "attr" => [
                    'class' => 'form-control',
                    
                ],
                'label' => 'Nouveau mot de passe',
                'label_attr' => [
                    'class' => 'form_label'
                ],
                'mapped' => false,
                "constraints" => [
                    new Assert\NotBlank(),
                ]
                ])
                ->add('submit', SubmitType::class, [
                'attr' => [
                    "class" => 'btn'
                ],
                'label' => 'Enregistrer'
            ]);
    }
     
}