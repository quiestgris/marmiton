<?php

namespace App\Controller;

use App\Entity\Ingredient;
use App\Form\IngredientTypeForm;
use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManager;
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
final class IngredientController extends AbstractController
{
    #[Route('ingredients/show', name: 'app_ingredients', methods: ["GET"])]
    #[IsGranted("ROLES_USER")]
    public function index(IngredientRepository $ingredientRepository, Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        $ingredients = $paginator->paginate($ingredientRepository->findBy(['user' => $this->getUser()]),
        $request->query->getInt("page", 1), 15);

        return $this->render('admin-panel/ingredient/index.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }

    #[Route('ingredients/new', name: 'app_ingredients_create', methods: ["GET","POST"])]
    #[IsGranted("ROLES_USER")]
    public function new(Request $request, EntityManagerInterface $manager) :Response {

        $ingredient = new Ingredient();
        $form = $this->createForm(IngredientTypeForm::class, $ingredient);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $ingredient->setUser($this->getUser());

            $manager->persist($ingredient);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre ingrédient a été créé avec succès"
            );
            return $this->redirectToRoute("app_ingredients");
        }

        return $this->render("admin-panel/ingredient/new.html.twig", [
            "form" => $form->createView()
        ]);
    }
    #[Route('ingredients/edit/{id}', name: 'app_ingredients_edit', methods: ["GET","POST"])]
    #[IsGranted("ROLES_USER")]
    public function edit(Request $request, EntityManagerInterface $manager, Ingredient $ingredient) :Response {

        
        $form = $this->createForm(IngredientTypeForm::class, $ingredient);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre ingrédient a été modifié avec succès"
            );
            return $this->redirectToRoute("app_ingredients", [], Response::HTTP_SEE_OTHER);
        }

        return $this->render("admin-panel/ingredient/edit.html.twig", [
            "form" => $form->createView(),
            "ingredient" => $ingredient
        ]);
    }
    #[Route('ingredients/delete/{id}', name: 'app_ingredients_delete', methods: ["GET","POST"])]
    #[IsGranted("ROLES_USER")]
    public function delete(Request $request, EntityManagerInterface $manager, Ingredient $ingredient) :Response {

        if(!$ingredient) {
            $this->addFlash(
                "success",
                "Votre ingrédient n'a pas été trouvé");
            return $this->redirectToRoute("app_ingredients", [], Response::HTTP_SEE_OTHER);
        }
        else {
            $manager->remove($ingredient);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre ingrédient a été supprimé avec succès");

            return $this->redirectToRoute("app_ingredients", [], Response::HTTP_SEE_OTHER);
            
        }
    }
}



