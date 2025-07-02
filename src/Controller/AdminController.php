<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\AdminRepository;
use App\Entity\Admin;
use App\Form\AdminTypeForm;
use App\Form\AdminTypePassword;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;



final class AdminController extends AbstractController
{
    #[Route('/user/edit/{id}', name: 'app_user_edit', methods: ["GET", "POST"])]
    public function edit(AdminRepository $userRepository, int $id, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher): Response
    {
        $user = $userRepository->findOneBy(['id' => $id]);
        if(!$this->getUser()) {
            return $this->redirectToRoute("app_recipes");
        }
        
        if ($this->getUser()->getId() !== $user->getId()){
            return $this->redirectToRoute('app_recipes');
        }
        
        $form = $this->createForm(AdminTypeForm::class, $user);
        
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            if($hasher->isPasswordValid($user, $form->getData()->getPlainPassword())) {
            
            $user = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre compte ont bien été modifié"
            );
            return $this->redirectToRoute("app_ingredients");
            }
            else {
               $this->addFlash(
                "warning",
                "Mot de passe n'est pas correct"
            ); 
            }
        }

        return $this->render('admin-panel/admin/edit.html.twig', [
            'form' =>  $form->createView(),
        ]);
    }
    #[Route('/user/edit-password/{id}', name: 'app_user_edit_password', methods: ["GET", "POST"])]
    public function editPassword(AdminRepository $userRepository, int $id, Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hasher) : Response {

         $user =$userRepository->findOneBy(["id"=>$id]);

    $form = $this->createForm(AdminTypePassword::class,$user);
    
     $form->handleRequest($request); 
     if($form->isSubmitted() && $form->isValid()){
        if($hasher->isPasswordValid($user,$form->get('plainPassword')->getData())){
            $user->setPassword(
                $hasher->hashPassword(
                    $user,
                    $form->get('newPassword')->getData()
                )
                ); 
                $manager->persist($user);
                $manager->flush();
            $user->setPlainPassword(
                $form->get('newPassword')->getData()
            );
            $this->addflash(
                'success',
                'Le mot de passe a été modifié'
            );
            return $this->redirectToRoute('app_recipes');
        }else{
            $this->addFlash(
                'warning',
                "Le mot de passe renseigné est incorrect"

            );
        }
        }

        return $this->render('admin-panel/admin/edit_password.html.twig',[
            'form' => $form->createView()
    ]);
    }

}
