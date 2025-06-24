<?php

namespace App\Controller;

use App\Entity\Recipe;
use App\Form\RecipeTypeForm;
use App\Repository\RecipeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


/**
 * This function shows all ingredients and information about them
 */
final class RecipeController extends AbstractController
{
    #[Route('recipes/show', name: 'app_recipes', methods: ["GET"])]
    public function index(RecipeRepository $ingredientRepository, Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        $recipes = $paginator->paginate($ingredientRepository->findAll(),
        $request->query->getInt("page", 1), 15);

        return $this->render('admin-panel/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('recipes/new', name: 'app_recipes_create', methods: ["GET","PUT"])]
    public function new(Request $request, EntityManagerInterface $manager) :Response {

        $recipe = new Recipe();
        $form = $this->createForm(RecipeTypeForm::class, $recipe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();

            $recipe->setUpdatedAt(new \DateTimeImmutable());

            dd($recipe);
            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre recette a été créée avec succès"
            );
            return $this->redirectToRoute("app_recipes");
        }

        return $this->render("admin-panel/recipe/new.html.twig", [
            "form" => $form->createView()
        ]);
    }
    // #[Route('ingredients/edit/{id}', name: 'app_recipes_edit', methods: ["GET","POST"])]
    // public function edit(Request $request, EntityManagerInterface $manager, Ingredient $ingredient) :Response {

        
    //     $form = $this->createForm(IngredientTypeForm::class, $ingredient);

    //     $form->handleRequest($request);

    //     if($form->isSubmitted() && $form->isValid()) {
    //         $manager->flush();

    //         $this->addFlash(
    //             "success",
    //             "Votre ingrédient a été modifié avec succès"
    //         );
    //         return $this->redirectToRoute("app_ingredients", [], Response::HTTP_SEE_OTHER);
    //     }

    //     return $this->render("admin-panel/ingredient/edit.html.twig", [
    //         "form" => $form->createView(),
    //         "ingredient" => $ingredient
    //     ]);
    // }
    // #[Route('ingredients/delete/{id}', name: 'app_recipes_delete', methods: ["GET","POST"])]
    // public function delete(Request $request, EntityManagerInterface $manager, Ingredient $ingredient) :Response {

    //     if(!$ingredient) {
    //         $this->addFlash(
    //             "success",
    //             "Votre ingrédient n'a pas été trouvé");
    //         return $this->redirectToRoute("app_ingredients", [], Response::HTTP_SEE_OTHER);
    //     }
    //     else {
    //         $manager->remove($ingredient);
    //         $manager->flush();

    //         $this->addFlash(
    //             "success",
    //             "Votre ingrédient a été supprimé avec succès");

    //         return $this->redirectToRoute("app_ingredients", [], Response::HTTP_SEE_OTHER);
            
    //     }
    // }
}


