<?php

namespace App\Controller;

use App\Repository\SalleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SalleclController extends AbstractController
{
    /**
     * @Route("/sallecl", name="sallecl")
     */
    public function index(): Response
    {
        return $this->render('sallecl/index.html.twig', [
            'controller_name' => 'SalleclController',
        ]);
    }

    /**
     * @Route("/gallery", name="gallery")
     */
    public function Gallery(): Response
    {
        return $this->render('sallecl/Gallery.html.twig', [
            'controller_name' => 'SalleclController',
        ]);
    }

    /**
     *@param SalleRepository $repository
     * @return Response
     * @Route ("listsallecl",name ="listsallecl")
     */
    public function Listsallecl(SalleRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Salle::class);
        $sallecl=$repository ->findAll();
        return $this->render('sallecl/Listsallecl.html.twig',
            ['salle' => $sallecl]);
    }

    /**
     * @Route("/sallecl/searchNumero", name="searchNumero")
     */
    function SearchNum (SalleRepository $repository,Request $request){
        $data=$request->get('find');
        $nom=$repository->findBy(['numsalle'=>$data]);
        return $this->render('sallecl/Listsallecl.html.twig', [
            'salle' => $nom,
        ]);
    }
}
