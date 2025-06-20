<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


/**
 * This function shows all ingredients and information about them
 */
final class IngredientController extends AbstractController
{
    #[Route('/ingredients', name: 'app_ingredients', methods: ["GET"])]
    public function index(IngredientRepository $ingredientRepository, Request $request, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        $ingredients = $paginator->paginate($ingredientRepository->findAll(),
        $request->query->getInt("page", 1), 15);

        return $this->render('ingredient/index.html.twig', [
            'ingredients' => $ingredients,
        ]);
    }
}


