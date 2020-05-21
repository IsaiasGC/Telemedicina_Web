<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use App\Repository\UserRepository;

class EleccionController extends AbstractController
{
    /**
     * @Route("/eleccion/{id}", name="eleccion", methods={"GET"})
     */
    public function index(User $user): Response
    {
        return $this->render('eleccion/index.html.twig', [
            'controller_name' => 'EleccionController',
            'user_id'=> $user->getId(),
        ]);
    }
}
