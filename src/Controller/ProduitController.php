<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{
    /**
     * @Route("/", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/produit_new", name="produit_new")
     */
    public function new(Request $request): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image =$form->get('image')->getData();
            $um=substr($image,strpos($image,'\\tmp')+5,strlen($image)-strripos($image,"tmp",0)+8);
            $upload_directory=$this->getParameter('upload_directory');
            $image->move($upload_directory,$image);

            $produit->setImage($um);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idProduit}", name="produit_show", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }

    /**
     * @Route("/{idProduit}/edit", name="produit_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Produit $produit): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param $id
     * @param ProduitRepository $repository
     * @Route("/deleteproduit/{id}", name="deleteproduit")
     */
   public function delete($id,ProduitRepository $repository)
    {
        if($repository->findOneBy(['idProduit' => $id]))
        {
        $produit=$repository->findOneBy(['idProduit' => $id]);
        $em = $this->getDoctrine()->getManager();
        $em->remove($produit);
        $em->flush();
        }
        return $this->redirectToRoute('produit_index');
    }
    /**
     * @param ProduitRepository $repository
     * @return Response
     * @Route ("/produit/listproduct",name="listproduct")
     */
    public function showlistproduct(ProduitRepository $repository){
        $produit=$repository->findAll();
        return $this->render('produit/listproduit.html.twig',['listproduit'=>$produit]);
    }

}
