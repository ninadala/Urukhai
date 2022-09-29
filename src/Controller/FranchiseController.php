<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Form\FranchiseType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;


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

    #[Route('/franchise/new')]
    public function create(Request $request, ManagerRegistry $doctrine): Response
    {
        $franchise = new Franchise();
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($franchise);
            $em->flush();
            return $this->redirectToRoute('franchise-home');
        }
        return $this->render('franchise/form.html.twig', [
            "franchise_form" => $form->createView()
        ]);
    }

    #[Route('/franchise/delete/{id<\d+>}', name:"delete-franchise")]
    public function delete(Franchise $franchise, ManagerRegistry $doctrine): Response
    {
        $em = $doctrine->getManager();
        $em->remove($franchise);
        $em->flush();

        return $this->redirectToRoute("franchise-home");
    }

    #[Route('/franchise/edit/{id<\d+>}', name:"edit-franchise")]
    public function update(Franchise $franchise, Request $request, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(FranchiseType::class, $franchise);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
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
        $franchise = $repository->find($id);
        $salles = $franchise->getSalles();
        $permissions = $franchise->getPermissions();
        return $this->render('franchise/unity.html.twig', [
            'franchise' => $franchise,
            'salles' => $salles,
            'permissions' => $permissions
        ]);
    }
}