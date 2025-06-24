<?php


namespace App\Form;

use App\Entity\Ingredient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Webmozart\Assert\Assert as AssertAssert;

class IngredientTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Nom",
                "label_attr" => [
                    "class" => "form-label"
                ], 
                "constraints" => [
                    new Assert\Length(["min" => 2, "max" => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('price', TypeTextType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Prix",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Positive(),
                    new Assert\LessThan(200)
                ]
            ])
            ->add("submit", SubmitType::class, [
                "attr" => [
                    "class" => "form-btn"
                ],
                "label" => "Créer un ingrédient"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
