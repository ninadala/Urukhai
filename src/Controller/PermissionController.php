<?php

namespace App\Controller;

use App\Entity\Permission;
use App\Form\PermissionType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PermissionController extends AbstractController
{
    #[Route('/permission', name: 'permission-home')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Permission::class);
        $permissions = $repository->findAll();
        return $this->render('permission/index.html.twig', [
            'permissions' => $permissions
        ]);
    }

    #[Route('/permission/new')]
    public function create(Request $request, ManagerRegistry $doctrine) : Response
    {
        $permission = new Permission();
        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->persist($permission);
            $em->flush();
            return $this->redirectToRoute('permission-home');
        }
        return $this->render('permission/form.html.twig', [
            "permission_form" => $form->createView()
        ]);
    }

    #[Route('/permission/delete/{id<\d+>}', name:"delete-permission")]
    public function delete(Permission $permission, ManagerRegistry $doctrine) : Response
    {
        $em = $doctrine->getManager();
        $em->remove($permission);
        $em->flush();

        return $this->redirectToRoute("permission-home");
    }

    #[Route('/permission/edit/{id<\d+>}', name:"edit-permission")]
    public function update(Permission $permission, Request $request, ManagerRegistry $doctrine) : Response
    {
        $form = $this->createForm(PermissionType::class, $permission);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('permission-home');
        }
        return $this->render('permission/form.html.twig', [
            "permission_form" => $form->createView()
        ]);
    }
}
