<?php

namespace App\Controller;

use App\Entity\PanierElem;
use App\Entity\Panier;
use App\Form\PanierElemType;
use App\Repository\PanierElemRepository;
use App\Repository\PanierRepository;
use App\Repository\ProduitRepository;
use phpDocumentor\Reflection\Types\Array_;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function Sodium\add;

/**
 * @Route("/panier/elem")
 */
class PanierElemController extends AbstractController
{
    /**
     * @Route("/", name="panier_elem_index", methods={"GET"})
     */
    public function index(PanierElemRepository $panierElemRepository): Response
    {
        return $this->render('panier_elem/index.html.twig', [
            'panier_elems' => $panierElemRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="panier_elem_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $panierElem = new PanierElem();
        $form = $this->createForm(PanierElemType::class, $panierElem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($panierElem);
            $entityManager->flush();

            return $this->redirectToRoute('panier_elem_index');
        }

        return $this->render('panier_elem/new.html.twig', [
            'panier_elem' => $panierElem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPanier}", name="panier_elem_show", methods={"GET"})
     */
    public function show(PanierElem $panierElem): Response
    {
        return $this->render('panier_elem/show.html.twig', [
            'panier_elem' => $panierElem,
        ]);
    }

    /**
     * @Route("/{idPanier}/edit", name="panier_elem_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, PanierElem $panierElem): Response
    {
        $form = $this->createForm(PanierElemType::class, $panierElem);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('panier_elem_index');
        }

        return $this->render('panier_elem/edit.html.twig', [
            'panier_elem' => $panierElem,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{idPanier}", name="panier_elem_delete", methods={"POST"})
     */
    public function delete(Request $request, PanierElem $panierElem): Response
    {
        if ($this->isCsrfTokenValid('delete'.$panierElem->getIdPanier(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($panierElem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('panier_elem_index');
    }

    /**
     * @param $id
     * @param $idp
     * @param PanierElemRepository $repository
     * @Route("/panier/elem/{id}/{idp}", name="d")
     */
    public function deletepanier_elem($id,$idp,PanierElemRepository  $repository){
       if($repository->findOneBy(['idPanier' => $idp, 'idProduit' => $id]))
       {
            $evenement = $repository->findOneBy(['idPanier' => $idp, 'idProduit' => $id]);
            $em = $this->getDoctrine()->getManager();
            $em->remove($evenement);
            $em->flush();
        }
      return $this->redirectToRoute('listpanierelem');

    }

    /**
     * @param PanierElemRepository $repository
     * @param PanierRepository $repositoryp
     * @return Response
     * @Route ("/panierElem/listpanierelem",name="listpanierelem")
     */

    public function Listpanierelem(PanierElemRepository $repository,PanierRepository $repositoryp,ProduitRepository $produitRepository)
    {
        $panier=$repositoryp->findBy(['idUser'=>'682','validite'=>'nonvalid']);
        $p=$panier[0]->getIdPanier();
        $panierelem=$repository->findBy(['idPanier'=>$p]);
        $panierelem1=array();
        foreach($panierelem as $pe){
            $idproduit=$pe->getIdProduit();

            $produit=$produitRepository->find($idproduit);
            if(is_array($panierelem1)){
                array_push($panierelem1,$produit);
            }


        }
        dump($panierelem);
        $nbprod=count($panierelem);
        return $this->render('panier_elem/listpanier.html.twig',['listpanierelem'=>$panierelem,'listproduit'=>$panierelem1,'nbprod'=>$nbprod]);
    }
}
