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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class UserController extends AbstractController
{
    #[Route('/user', name: 'user-home')]
    #[IsGranted('ROLE_ADMIN')]
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
            'form_login' => $form->createView()
        ]);
    }

    #[Route('/logout', name: 'logout')]
    public function logout()
    {
        
    }

    #[Route('/user/new', name:"new-user")]
    #[IsGranted('ROLE_ADMIN')]
    public function create(UserPasswordHasherInterface $userPasswordHasher, 
    Request $request, 
    ManagerRegistry $doctrine, 
    EmailController $email, 
    MailerInterface $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $email->sendEmailNewUser($mailer, $user);
            return $this->redirectToRoute('user-home');
        }
        return $this->render('user/form.html.twig', [
            "user_form" => $form->createView()
        ]);
    }

    #[Route('/user/delete/{id<\d+>}', name:"delete-user")]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(User $user, 
    ManagerRegistry $doctrine, 
    MailerInterface $mailer, 
    EmailController $email): Response
    {
        $em = $doctrine->getManager();
        $em->remove($user);
        $em->flush();
        $email->sendEmailDeleteUser($mailer, $user);

        return $this->redirectToRoute("user-home");
    }

    #[Route('/user/edit/{id<\d+>}', name:"edit-user")]
    #[IsGranted('ROLE_ADMIN')]
    public function update(User $user, 
    Request $request, 
    ManagerRegistry $doctrine, 
    UserPasswordHasherInterface $passwordHasher, 
    MailerInterface $mailer, 
    EmailController $email): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $form->get('password')->getData()));
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            $email->sendEmailEditUser($mailer, $user);
            return $this->redirectToRoute("user-home");
        }
        return $this->render('user/form.html.twig', [
            "user_form" => $form->createView()
        ]);
    }

    #[Route('/user/edit/Self{id<\d+>}', name:"editSelf-user")]
    public function updateSelf(User $user, Request $request, ManagerRegistry $doctrine, UserPasswordHasherInterface $passwordHasher): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($passwordHasher->hashPassword($user, $form->get('password')->getData()));
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute("home");
        }
        return $this->render('user/formSelf.html.twig', [
            "user_form" => $form->createView()
        ]);
    }
   
    #[Route('/user/fiche/{id<\d+>}', name:'fiche-user')]
    public function fiche(int $id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(User::class);
        $user = $repository->find($id);
        $salles = $user->getSalles();
        $franchises = $user->getFranchises();
        return $this->render('user/unity.html.twig', [
            'user' => $user,
            'salles' => $salles,
            'franchises' => $franchises
        ]);
    }
}
