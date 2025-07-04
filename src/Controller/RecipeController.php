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
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * This function shows all ingredients and information about them
 */
final class RecipeController extends AbstractController
{
    #[Route('recipes/show', name: 'app_recipes', methods: ["GET"])]
    // #[IsGranted("ROLES_USER")]
    public function index(RecipeRepository $recipeRepository, Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        $recipes = $paginator->paginate($recipeRepository->findBy(['user' => $this->getUser()]),
        $request->query->getInt("page", 1), 15);

        return $this->render('admin-panel/recipe/index.html.twig', [
            'recipes' => $recipes,
        ]);
    }

    #[Route('recipes/new', name: 'app_recipes_create', methods: ["GET","POST"])]
    // #[IsGranted("ROLES_USER")]
    public function new(Request $request, EntityManagerInterface $manager) :Response {

        $recipe = new Recipe();
        $form = $this->createForm(RecipeTypeForm::class, $recipe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $recipe = $form->getData();
            $recipe->setUser($this->getUser());

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
    #[Route('recipes/edit/{id}', name: 'app_recipes_edit', methods: ["GET","POST"])]
    // #[IsGranted("ROLES_USER")]
    public function edit(Request $request, EntityManagerInterface $manager, Recipe $recipe) :Response {

        
        $form = $this->createForm(RecipeTypeForm::class, $recipe);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre ingrédient a été modifié avec succès"
            );
            return $this->redirectToRoute("app_recipes", [], Response::HTTP_SEE_OTHER);
        }

        return $this->render("admin-panel/recipe/edit.html.twig", [
            "form" => $form->createView(),
            "recipe" => $recipe
        ]);
    }
    #[Route('recipes/delete/{id}', name: 'app_recipes_delete', methods: ["GET","POST"])]
    // #[IsGranted("ROLES_USER")]
    public function delete(Request $request, EntityManagerInterface $manager, Recipe $recipe) :Response {

        if(!$recipe) {
            $this->addFlash(
                "success",
                "Votre ingrédient n'a pas été trouvé");
            return $this->redirectToRoute("app_ingredients", [], Response::HTTP_SEE_OTHER);
        }
        else {
            $manager->remove($recipe);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre ingrédient a été supprimé avec succès");

            return $this->redirectToRoute("app_recipes", [], Response::HTTP_SEE_OTHER);
        }
    }
}


