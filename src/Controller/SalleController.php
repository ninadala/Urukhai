<?php

namespace App\Controller;

use App\Entity\Salle;
use App\Form\SalleType;
use Doctrine\Persistence\ManagerRegistry;
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
            'salles' => $salles,
        ]);
    }

    #[Route('salle/new')]
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
}
