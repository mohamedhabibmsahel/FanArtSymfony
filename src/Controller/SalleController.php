<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Salle;
use App\Form\SalleType;
use App\Repository\FormationRepository;
use App\Repository\SalleRepository;
use Doctrine\Common\Annotations\Annotation;
use Doctrine\DBAL\Types\Type;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SalleController extends AbstractController
{
    /**
     * @Route("/salle", name="salle")
     */
    public function index(): Respon {
        return $this->render('salle/index.html.twig', [
            'controller_name' => 'SalleController',]);
    }

    /**
     *@param SalleRepository $repository
     * @return Response
     * @Route ("listsalle",name ="AfficheClass")
     */
    public function Listsalle(SalleRepository $repository){
        //$repo=$this->getDoctrine()->getRepository(Salle::class);
        $salle=$repository ->findAll();
        return $this->render('salle/Listesalle.html.twig',
            ['salle' => $salle]);
    }

    /**
     * @Route *("/supp/{idsalle}",name ="d")
     */

    function Supprimer($idsalle, SalleRepository $repository){
        $Salle=$repository-> find ($idsalle);
        $em= $this -> getDoctrine()->getManager();
        $em ->remove($Salle);
        $em -> flush(); // mettre a jour
        return $this-> redirectToRoute('AfficheClass');
        // return new Response('Salle ajouté..');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/salle/Ajouter",name="ajoutersalle")
     */
    function Ajouter(Request $request ) {
        // self::$y=0;
        $salle = new Salle();
        $form = $this->createForm(SalleType::class,$salle);
        $form->add('Enregistrer', submitType::class);
        $form->handleRequest($request); //gerer la requette, parcourir et extraire
        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();
            $salle->setImage($image);
            $em = $this->getDoctrine()->getManager();
            $em->persist($salle);
            $em->flush();
            //self::$y=1;
            //$flashy->success('New Hotel is created!', 'listsalle');
            return $this->redirectToRoute('AfficheClass');
        }
        return $this->render('salle/Ajouter.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("salle/Modifier/{idsalle}",name="update")
     */
    function Modifier(SalleRepository $repository,$idsalle,Request $request){
        $salle=$repository->find($idsalle);
        $form=$this->createForm(SalleType::class,$salle);
        $form->add('Modifier',submitType::class);
        $form->handleRequest($request); //gerer la requette
        if ($form->isSubmitted() && $form->isValid()){
            $image = $form->get('image')->getData();
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("AfficheClass");

        }
        return $this->render('salle/Modifier.html.twig',
            [
                's'=> $form->createView()
            ]);
    }

    /**
     * @Route("/salle/searchNum", name="searchNum")
     */
    function SearchNum (SalleRepository $repository,Request $request){
        $data=$request->get('find');
        $nom=$repository->findBy(['numsalle'=>$data]);
        return $this->render('salle/Listesalle.html.twig', [
            'salle' => $nom,
        ]);
    }

    /**
     * @Route("/salle/salleOrderASC" , name="salleOrderASC")
     */
    public function SalleOrderASC(){
        $repository = $this->getDoctrine()->getRepository(formation::class);
        $form = $repository->trierNumsalleASC();
        return $this->render('salle/Listesalle.html.twig', ['salle' => $form,]);
    }

    /**
     * @Route("/salle/salleOrderDESC" , name="salleOrderDESC")
     */
    public function SalleOrderDESC(){
        $repository = $this->getDoctrine()->getRepository(formation::class);
        $form = $repository->trierNumsalleDESC();
        return $this->render('salle/Listesalle.html.twig', ['salle' => $form,]);
    }
    /**
     * @return Response
     * @Route("salle/home",name="home")
     */
    public function homepage(){
        return $this->render('front.html.twig');
    }

    /**
     * @param SalleRepository $repository
     * @return Response
     * @Route ("/salle/Tables")
     */
    function Tables(SalleRepository $repository){
        $salle=$repository ->findAll();
        return $this->render('salle/Home.html.twig',
            ['salle' => $salle]);
    }
}
