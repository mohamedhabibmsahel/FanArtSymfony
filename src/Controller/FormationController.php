<?php

namespace App\Controller;

use App\Entity\Formation;

use App\Entity\PropertySearch;
use App\Entity\Salle;
use App\Form\FormationType;
use App\Form\PropertySearchType;
use App\Form\SalleType;
use App\Repository\FormationRepository;
use phpDocumentor\Reflection\DocBlock\Tags\Formatter;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\DBAL\Types\Type;
use Doctrine\Common\Annotations\Annotation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormTypeInterface;
use Doctrine\DBAL\Types\IntegerType;

class FormationController extends AbstractController
{
    /**
     * @Route("/formation", name="formation")
     */
    public function index(): Response  {
        return $this->render('formation/index.html.twig', [
            'controller_name' => 'FormationController',
        ]);
    }

    /**
     *@param FormationRepository $repository
     * @return Response
     * @Route ("listformation",name ="listformation")
     */
    public function Listformation(FormationRepository $repository, Request $request){
        $search = new PropertySearch();
        $form = $this -> createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);
        $formarion=[];
        if($form->isSubmitted() && $form->isValid()){
            $prix = $search->getMaxprice();
            if ($prix!="")
                $formarion=$this->getDoctrine()->getRepository()
                    ->findBy(['prix'=>$prix]);
            else
                $formarion=$this->getDoctrine()->getRepository()
                    ->findAll();
        }
        $formarion=$repository ->findAll();
        return $this->render('formation/ListeFormation.html.twig',
            ['formation' => $formarion, 'form' =>$form->createView()]
        );
    }

    /**
     * @Route *("/sup/{idformation}",name ="supprimer")
     */

    function Supprimer($idformation, FormationRepository $repository){
        $formation=$repository-> find ($idformation);
        $em= $this -> getDoctrine()->getManager();
        $em ->remove($formation);
        $em -> flush(); // mettre a jour
        return $this-> redirectToRoute('listformation');
        return new Response('Formation ajouté');
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/formation/Ajouter",name ="ajouter")
     */
    function Ajouter(Request $request)
    {
        $formation = new Formation();
        $form = $this->createForm(FormationType::class, $formation);
        $form->add('Enregistrer', submitType::class);
        $form->handleRequest($request); //gerer la requette, parcourir et extraire

        if ($form->isSubmitted() && $form->isValid()) {
            $datedebut=$request->request->get('start');
            $datefin=$request->request->get('end');
            $formation->setDateDebut($datedebut)
                ->setDateFin($datefin);
            $em = $this->getDoctrine()->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('listformation');
        }
        return $this->render('formation/Ajouter.html.twig', ['form' => $form->createView()]);
    }


    /**
     * @Route("formation/Modifier/{idformation}",name="modifier")
     */
    function Modifier(FormationRepository $repository,$idformation ,Request $request){
        $formation=$repository->find($idformation);
        $form=$this->createForm(FormationType::class,$formation);
        $form->add('Modifier',submitType::class);
        $form->handleRequest($request); //gerer la requette

        if ($form->isSubmitted() && $form->isValid()){
            $datedebut=$request->request->get('start');
            $datefin=$request->request->get('end');
            $formation->setDateDebut($datedebut)
                ->setDateFin($datefin);
            $em=$this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute("listformation");
        }
        return $this->render('formation/Modifier.html.twig',
            ['f'=> $form->createView(), 'formation'=>$formation]);
    }

    /**
     * @Route("/formation/searchName", name="searchName")
     */
    function SearchName (FormationRepository $repository,Request $request){
        $data=$request->get('find');
        $nom=$repository->findBy(['nomformation'=>$data]);
        return $this->render('formation/Listeformation.html.twig', [
            'formation' => $nom,
        ]);
    }

    /**
     * @Route("/formation/formationOrderASC" , name="formationOrderASC")
     */
    public function FormationOrderASC(){
        $repository = $this->getDoctrine()->getRepository(formation::class);
        $form = $repository->trierdomaineASC();
        return $this->render('formation/Listeformation.html.twig', ['formation' => $form,]);
    }

    /**
     * @Route("/formation/formationOrderDESC" , name="formationOrderDESC")
     */
    public function FormationOrderDESC(){
        $repository = $this->getDoctrine()->getRepository(formation::class);
        $form = $repository->trierdomaineDESC();
        return $this->render('formation/Listeformation.html.twig', ['formation' => $form,]);
    }

    /**
     * @Route("/formation/stat", name="adminstat")
     */
    public function adminstat(): Response
    {
        $repository=$this->getDoctrine()->getRepository(Salle::Class);
        $salle=$repository->findAll();
        $repository=$this->getDoctrine()->getRepository(Formation::Class);
        $formation=$repository->findAll();

        return $this->render('formation/stat.html.twig', [
            'salle' => $salle,
            'formation' =>  $formation,

        ]);
    }
    /**
     * @param FormationRepository
     * $repository
     * @return Response
     * @Route ("/formation/front",name="front")
     */
    function Tables(FormationRepository $repository){
        $formation=$repository ->findAll();
        return $this->render('front.html.twig', ['formation' => $formation]);
    }
}
