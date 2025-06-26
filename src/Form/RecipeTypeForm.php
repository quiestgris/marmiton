<?php

namespace App\Form;

use App\Entity\Ingredient;
use App\Entity\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType as TypeTextType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Repository\IngredientRepository;
use Symfony\Component\OptionsResolver\OptionsResolver;
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
            ->add('time', IntegerType::class, [
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
            ->add('people_nb', IntegerType::class, [
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
                    "class" => "form-item",
                    "min" => "1",
                    "max" => "5",
                ],
                "label" => "Difficulté",
                "label_attr" => [
                    "class" => "form-label"
                ],
                "constraints" => [
                    new Assert\Positive(),
                    new Assert\LessThan(6)
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
                    "class" => "form-item",
                ],
                "required" => false,
                "label" => "Si préféré",
                "label_attr" => [
                    "class" => "form-label"
                ],
                
            ])
            ->add("ingredients", EntityType::class,[
                "label" => "Les ingrédients",
                'label_attr' => [
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
