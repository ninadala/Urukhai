<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginType;
use App\Form\UserType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user-home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $users = $repository->findAll();
        return $this->render('user/index.html.twig', [
            'users' => $users
        ]);
    }

    #[Route('/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils, Request $request): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUserName = $authenticationUtils->getLastUsername();

        $form = $this->createForm(LoginType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
        }
        
        return $this->render('user/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUserName,
            'form' => $form->createView()
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        
    }

    #[Route('/user/new', name:"new-user")]
    #[IsGranted('ROLE_ADMIN')]
    public function create(UserPasswordHasherInterface $userPasswordHasher, Request $request, ManagerRegistry $doctrine): Response
    {
        $user = new User($userPasswordHasher);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('user-home');
        }
        return $this->render('user/form.html.twig', [
            "user_form" => $form->createView()
        ]);
    }

    #[Route('/user/delete/{id<\d+>}', name:"delete-user")]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(User $user, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute("user-home");
    }

    // #[Route('/user/edit/{id<\d+>}', name:"edit-user")]
    // public function update(User $user, Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $userPasswordHasher): Response
    // {
    //     $form = $this->createForm(UserType::class, $user);
    //     $form->handleRequest($request);
    //     if ($form->isSubmitted() && $form->isValid()) {
    //         $em = $doctrine->getManager();
    //         $em->persist($user);
    //         $em->flush();
    //         return $this->redirectToRoute("user-home");
    //     }
    //     return $this->render('user/form.html.twig', [
    //         "user_form" => $form->createView()
    //     ]);
    // }

    #[Route('/user/fiche/{id<\d+>}', name:'fiche-user')]
    public function fiche(int $id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->find($id);
        // $salles = $franchise->getSalles();
        return $this->render('user/unity.html.twig', [
            'user' => $user,
        ]);
    }
}
