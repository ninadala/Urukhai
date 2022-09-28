<?php

namespace App\Controller;

use App\Entity\Permission;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
