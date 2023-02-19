<?php

namespace App\Controller;

use App\Entity\Franchise;
use App\Entity\Salle;
use App\Form\SalleType;
use Doctrine\Persistence\ManagerRegistry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
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

    #[Route('/salle/new/{franchise}', name: "create-salle", requirements: ['franchise' => '\d+'])]
    #[IsGranted('ROLE_ADMIN')]
    public function create(
        Franchise $franchise, 
        Request $request, 
        ManagerRegistry $doctrine, 
        MailerInterface $mailer, 
        EmailController $email) : Response
    {
        $salle = new Salle();
        $salle->setFranchise($franchise);
        $form = $this->createForm(SalleType::class, $salle, ['franchise_permissions' => $franchise->getPermissions()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $salle->addPermissions($franchise->getPermissions()->toArray());
            $em = $doctrine->getManager();
            $em->persist($salle);
            $em->flush();
            $this->addFlash('success', 'La salle a bien été créée !' );
            $user = $salle->getUser();
            $email->sendEmailNewSalle($mailer, $user, $salle);
            return $this->redirectToRoute('salle-home');
        }
        return $this->render('salle/form.html.twig', [
            "salle_form" => $form->createView(),
            "franchise_permissions" => $franchise->getPermissions()
        ]);
    }

    #[Route('/salle/delete/{id<\d+>}', name:"delete-salle")]
    #[IsGranted('ROLE_ADMIN')]
    public function delete(Salle $salle, ManagerRegistry $doctrine, MailerInterface $mailer, EmailController $email) : Response
    {
        $em = $doctrine->getManager();
        $em->remove($salle);
        $em->flush();
        $this->addFlash('success', 'La salle a bien été supprimée !' );
        $user = $salle->getUser();
        $email->sendEmailDeleteSalle($mailer, $user, $salle);
        

        return $this->redirectToRoute("salle-home");
    }

    #[Route('/salle/edit/{id<\d+>}', name:"edit-salle")]
    #[IsGranted('ROLE_ADMIN')]
    public function update(Salle $salle, Request $request, ManagerRegistry $doctrine, MailerInterface $mailer, EmailController $email) : Response
    {
        $franchise = $salle->getFranchise();
        $form = $this->createForm(SalleType::class, $salle, ['franchise_permissions' => $franchise->getPermissions()]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $salle->addPermissions($franchise->getPermissions()->toArray());
            $em = $doctrine->getManager();
            $em->flush();
            $this->addFlash('success', 'La salle a bien été mise à jour !' );
            $user = $salle->getUser();
            $email->sendEmailEditSalle($mailer, $user, $salle);
            return $this->redirectToRoute('salle-home');
        }
        return $this->render('salle/form.html.twig', [
            "salle_form" => $form->createView(),
            "franchise_permissions" => $franchise->getPermissions()
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
