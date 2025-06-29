<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AdminRepository;
use App\Form\AdminTypeForm;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;

final class AdminController extends AbstractController
{
    #[Route('/user/edit/{id}', name: 'app_user_edit', methods: ["GET", "POST"])]
    public function edit(AdminRepository $userRepository, int $id, Request $request, EntityManagerInterface $manager): Response
    {
        $user = $userRepository->findOneBy(["id"=>$id]);
        
        if(!$this->getUser()) {
            return $this->redirectToRoute("app_login");
        }
        
        if($this->getUser() !== $user) {
            return $this->redirectToRoute('app_recipes');
        }
        
        $form = $this->createForm(AdminTypeForm::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre ingrédient a été créé avec succès"
            );
            return $this->redirectToRoute("app_login");
        }

        return $this->render('admin-panel/admin/edit.html.twig', [
            'form' =>  $form->createView(),
        ]);
    }
}
