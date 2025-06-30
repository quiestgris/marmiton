<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Admin;
use App\Form\SignUpTypeForm;
use Exception;

final class LoginController extends AbstractController
{
    #[Route('/login', name: 'app_login', methods: ['GET', "POST"])]
    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_user_name' => $lastUsername,
            "error" => $error,
        ]);
    }
    #[Route("/logout", name: "app_logout")]
    public function logout() :never {
        throw new Exception("Activate logout in security.yaml");
    }
    #[Route('/sign-up', name: 'app_sign_up', methods: ["GET", "POST"])]
    public function signUp(Request $request, EntityManagerInterface $manager) :Response {
        $user = new Admin();
        $form = $this->createForm(SignUpTypeForm::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                "success",
                "Votre ingrédient a été créé avec succès"
            );
            return $this->redirectToRoute("app_login");
        }
        return $this->render("admin-panel/sign-up/index.html.twig", [
            'form' => $form->createView()
        ]);
    }
}
