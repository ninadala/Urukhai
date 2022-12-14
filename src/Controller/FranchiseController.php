<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\Permission;
use App\Form\FranchiseType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;

class FranchiseController extends AbstractController
{
    #[Route('/franchise', name:'franchise-home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Franchise::class);
        $franchises = $repository->findAll();
        return $this->render('franchise/index.html.twig', [
            "franchises"=>$franchises
        ]);
    }

    #[Route('/franchise/new', name:'create-franchise')]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, ManagerRegistry $doctrine, MailerInterface $mailer, EmailController $email): Response
    {
        $franchise = new Franchise();
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($franchise);
            $em->flush();
            $this->addFlash('success', 'La franchise a bien été créée !' );
            $user = $franchise->getUser();
            $email->sendEmailNewFranchise($mailer, $user, $franchise);
            return $this->redirectToRoute('franchise-home');
        }
        return $this->render('franchise/form.html.twig', [
            "franchise_form" => $form->createView()
        ]);
    }

    #[Route('/franchise/delete/{id<\d+>}', name:"delete-franchise")]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Franchise $franchise, ManagerRegistry $doctrine, MailerInterface $mailer, EmailController $email): Response
    {
        $em = $doctrine->getManager();
        $em->remove($franchise);
        $em->flush();
        $this->addFlash('success', 'La franchise a bien été supprimée !' );
        $user = $franchise->getUser();
        $email->sendEmailDeleteFranchise($mailer, $user, $franchise);

        return $this->redirectToRoute("franchise-home");
    }

    #[Route('/franchise/edit/{id<\d+>}', name:"edit-franchise")]
    #[IsGranted('ROLE_ADMIN')]
    public function update(Franchise $franchise, Request $request, ManagerRegistry $doctrine, MailerInterface $mailer, EmailController $email): Response
    {
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
            $user = $franchise->getUser();
            $this->addFlash('success', 'La franchise a bien été mise à jour !' );
            $email->sendEmailDeleteFranchise($mailer, $user, $franchise);

            return $this->redirectToRoute("franchise-home");
        }
        return $this->render('franchise/form.html.twig', [
            "franchise_form" => $form->createView()
        ]);
    }

    #[Route('/franchise/fiche/{id<\d+>}', name:'fiche-franchise')]
    public function fiche(int $id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Franchise::class);
        $repositoryPermissions = $doctrine->getRepository(Permission::class);
        $franchise = $repository->find($id);
        $salles = $franchise->getSalles();
        $user = $franchise->getUser();
        $permGlobales = $repositoryPermissions->findAll();
        $permissions = $franchise->getPermissions();
        return $this->render('franchise/unity.html.twig', [
            'franchise' => $franchise,
            'salles' => $salles,
            'user' => $user,
            'permissions' => $permissions,
            'permGlobales' => $permGlobales
        ]);
    }
}