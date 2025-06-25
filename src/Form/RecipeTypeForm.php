<?php

namespace App\Form;

use App\Entity\Recipe;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\DBAL\Types\SmallIntType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Validator\Constraints as Assert;



class RecipeTypeForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TypeTextType::class, [
                "attr" => [
                    "class" => "form-item"
                ],
                "label" => "Nom",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Length(["min" => 2, "max" => 40]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('time', NumberType::class, [
                "attr" => [
                    "class" => "form-item"
                ],
                "label" => "Temps",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Positive(),
                    new Assert\NotBlank()
                ]
            ])
            ->add('people_nb', NumberType::class, [
                "attr" => [
                    "class" => "form-item"
                ],
                "label" => "Nombre de gens",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Positive(),
                    new Assert\LessThan(200)
                ]
            ])
            ->add('difficulty', RangeType::class, [
                "attr" => [
                    "class" => "form-item"
                ],
                "label" => "Difficulté",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Positive(),
                    new Assert\LessThan(100)
                ]
            ])
            ->add('description', TextareaType::class, [
                "attr" => [
                    "class" => "form-item"
                ],
                "label" => "Description",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Length(["min" => 2, "max" => 500]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('price', MoneyType::class, [
                "attr" => [
                    "class" => "form-item"
                ],
                "label" => "Prix",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Positive(),
                    new Assert\LessThan(128)
                ]
            ])
            ->add('is_favorite', CheckBoxType::class, [
                "attr" => [
                    "class" => "form-item"
                ],
                "label" => "Si préféré",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Positive(),
                    new Assert\LessThan(128)
                ]
            ])
            ->add("ingredients", EntityType::class,[
                "label" => "Les ingrédients",
                'label_attre' => [
                    'class' => 'form-label',
                ],
                "class" => Ingredient::class,
                'query_builder' => function (IngredientRepository $r) {
                    return $r->createQueryBuilder('i')
                            ->orderBy('i.name',"ASC");
                },
                'choice_label' => 'name',
                'multiple' => 'true',
                'expanded' => 'true',
            ])
            ->add("submit", SubmitType::class, [
                "attr" => [
                    "class" => "form-btn"
                ],
                "label" => "Créer une recette"
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
