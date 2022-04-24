<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationsController extends AbstractController
{
    /**
     * @Route("/reclamations", name="reclamations")
     */
    public function index(): Response
    {
        return $this->render('reclamations/index.html.twig');
    }

    /**
     * @Route("/reclamationsB", name="reclamationsB")
     */
    public function reclamationsBack(): Response
    {
        return $this->render('reclamations/Back.html.twig');
    }

    /**
     * @Route("/reclamationsF", name="reclamationsF")
     */
    public function reclamationsFront(): Response
    {
        return $this->render('reclamations/Front.html.twig');
    }
}
