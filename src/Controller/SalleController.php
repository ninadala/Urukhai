<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\FranchiseType;
use App\Form\SalleType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleController extends AbstractController
{
    #[Route('/salle', name: 'salle-home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Salle::class);
        $salles = $repository->findAll();
        return $this->render('salle/index.html.twig', [
            'salles' => $salles
        ]);
    }

    #[Route('/salle/new')]
    #[IsGranted('ROLE_ADMIN')]
    public function create(Request $request, ManagerRegistry $doctrine) : Response
    {
        $salle = new Salle();
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($salle);
            $em->flush();
            return $this->redirectToRoute('salle-home');
        }
        return $this->render('salle/form.html.twig', [
            "salle_form" => $form->createView()
        ]);
    }

    #[Route('/salle/delete/{id<\d+>}', name:"delete-salle")]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Salle $salle, ManagerRegistry $doctrine) : Response
    {
        $em = $doctrine->getManager();
        $em->remove($salle);
        $em->flush();

        return $this->redirectToRoute("salle-home");
    }

    #[Route('/salle/edit/{id<\d+>}', name:"edit-salle")]
    #[IsGranted('ROLE_ADMIN')]
    public function update(Salle $salle, Request $request, ManagerRegistry $doctrine) : Response
    {
        $form = $this->createForm(SalleType::class, $salle);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('salle-home');
        }
        return $this->render('salle/form.html.twig', [
            "salle_form" => $form->createView()
        ]);
    }

    #[Route('/salle/fiche/{id<\d+>}', name:'fiche-salle')]
    public function fiche(int $id, ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Salle::class);
        $salle = $repository->find($id);
        $franchise = $salle->getFranchise();
        $franchisePermissions = $franchise->getPermissions();
        $user = $salle->getUser();
        $permissions = $salle->getPermissions();
        return $this->render('salle/unity.html.twig', [
            'salle' => $salle,
            'franchise' => $franchise,
            'user' => $user,
            'permissions' => $permissions,
            'franchisePermissions' => $franchisePermissions
        ]);
    }
}
