<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\NotificationRepository;
use App\Repository\SallesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class EvenementController extends AbstractController
{
    /**
     * @Route("/evenement", name="evenement")
     */
    public function index(): Response
    {
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',


        ]);
    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route ("/evenement/listevent", name="listevent")
     */

    public function displayAll(EvenementRepository $repository){
        $evenement=$repository->findAll();
        return $this->render('evenement/listevent.html.twig',['list'=>$evenement]);


    }

    /**
     * @param EvenementRepository $repository
     * @return Response
     * @Route ("/evenement/listeventproduct",name="listeventproduct")
     */
    public function DisplayAllProduct(EvenementRepository $repository){

        $evenement=$repository->findAll();
        return $this->render('evenement/listeventproduct.html.twig',['listeventproduct'=>$evenement]);


    }

    /**
     * @param $id
     * @param EvenementRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/evenement/suppevent/{id}" ,name="suppevent")
     */
    public function delete($id,EvenementRepository $repository){
        sleep(3);
        $evenement=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();
        return $this->redirectToRoute('listevent');

    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     * @Route ("/evenement/addevent",name="addvent")
     */
    public function addevent(\Symfony\Component\HttpFoundation\Request $request,SallesRepository $repositorysalle,NotificationRepository $notificationRepository){
        $listsalle=$repositorysalle->findBy(['disponibilite'=>'dispo']);
        $evenement=new Evenement();
        $form=$this->createForm(EvenementType::class,$evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ){
            sleep(5);
            $locall=$request->request->get('locall');
            $datedebut=$request->request->get('start');
            $datefin=$request->request->get('end');
            $image = $form->get('image')->getData();

            $um=substr($image,strpos($image,'\\tmp')+5,strlen($image)-strripos($image,"tmp",0)+8);
           $upload_directory=$this->getParameter('upload_directory');
           $image->move($upload_directory,$image);

            $evenement->setImage($um);
            $evenement->setDateDebut($datedebut)
                ->setDateFin($datefin)
                ->setIdUser(null)
                ->setLocall($locall);
            $em=$this->getDoctrine()->getManager();
            $em->persist($evenement);
            $em->flush();
            $notif=$notificationRepository->findOneBy(['id'=>1]);
            $notif->setNbevent($notif->getNbevent()+1);

            $em2 = $this->getDoctrine()->getManager();

            $RAW_QUERY = 'UPDATE `notification` SET `id`=1,`nbevent`='.$notif->getNbevent().' WHERE 1';

            $statement = $em2->getConnection()->prepare($RAW_QUERY);
            $statement->execute();
           // $notificationRepository->update(1,1);

            return $this->redirectToRoute('listevent');
        }
        return $this->render('/evenement/addevent.html.twig',[
            'form'=>$form->createView()
        ,'listsalle'=>$listsalle]);


    }

    /**
     * @param EvenementRepository $repository
     * @param $id
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route("/evenement/edit{id}",name="edit")
     */
    public function edit(EvenementRepository $repository,$id,\Symfony\Component\HttpFoundation\Request $request){
        $evenement=$repository->find($id);
        $form=$this->createForm(EvenementType::class,$evenement);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            sleep(5);
            $locall=$request->request->get('locall');
            $datedebut=$request->request->get('start');
            $datefin=$request->request->get('end');
            $image = $form->get('image')->getData();
            $evenement->setImage($image);
            $evenement->setDateDebut($datedebut)
                ->setDateFin($datefin)
                ->setIdUser(null)
                ->setLocall($locall);
            $em=$this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('listevent');

        }
        return $this->render('/evenement/editevent.html.twig',[
            'form'=>$form->createView(),
            'evenement'=>$evenement
        ]);
    }


    /**
     * @return Response
     * @Route("/evenement/home",name="home")
     */
    public function homepage(EvenementRepository $repository){

        $evenement=$repository->findAll();

        return $this->render('front.html.twig',['listeventproduct'=>$evenement]);
    }

    /**
     * @return Response
     * @Route("/evenement/calendar", name="calendar")
     */
    public function CalendarMetier(EvenementRepository $repository){
        $listevenement=$repository->findAll();
            $events=[];

            foreach ($listevenement as $produit){
                $datedebut = new \DateTime($produit->getDateDebut());
                $datefin = new \DateTime($produit->getDateFin());

                $events[]=[
                    'id'=>$produit->getIdEvenement(),
                    'title'=>$produit->getTitre(),
                    'start'=>$datedebut->format('Y-m-d H:i:s'),
                    'end'=>$datefin->format('Y-m-d H:i:s')



                ];

            }
        $data=json_encode($events);

        return $this->render('/evenement/calendar.html.twig',['listevent'=>$listevenement,'data'=>$data]);
    }


    /**
     * @param Evenement|null $evenement
     * @param Request $request
     * @param $id
     * @param EvenementRepository $repository
     * @return Response
     * @throws \Exception
     * @Route ("/api/{id}/edit",name="api_event_id",methods={"PUT"})
     */
    public function majEvent(?Evenement $evenement,Request $request,$id,EvenementRepository $repository){
        $donnes=json_decode($request->getContent());
        dump($donnes);
        if(
            isset($donnes->title)&& !empty($donnes->title) &&
            isset($donnes->start)&& !empty($donnes->start) &&
            isset($donnes->end)&& !empty($donnes->end)
    ){
            if(!$evenement){
                $evenement=new Evenement();


            }
            $evenement
                ->setIdEvenement($id)
                ->setTitre($donnes->title)
                ->setDateDebut($donnes->start)
                ->setDateFin($donnes->end);
            $em=$this->getDoctrine()->getManager();
            $em->persist();
            $em->flush();

        }
        $listevenement=$repository->findAll();
        $events=[];

        foreach ($listevenement as $produit){
            $datedebut = new \DateTime($produit->getDateDebut());
            $datefin = new \DateTime($produit->getDateFin());

            $events[]=[
                'id'=>$produit->getIdEvenement(),
                'title'=>$produit->getTitre(),
                'start'=>$datedebut->format('Y-m-d H:i:s'),
                'end'=>$datefin->format('Y-m-d H:i:s')



            ];

        }
        $data=json_encode($events);

        return $this->render('/evenement/calendar.html.twig',['listevent'=>$listevenement,'data'=>$data]);


    /**
     * @return Response
     * @Route("/evenement/home",name="home")
     */
    public function homepage(EvenementRepository $repository,NotificationRepository $notificationRepository){
        $es=null;
        $evenement=$repository->findAll();
        $nbevent=$repository->findAll();
        $nbevent=count($nbevent);
        $notif=$notificationRepository->findOneBy(['id'=>1]);
        $nbnotif=$notif->getNbevent();
        if($nbnotif>$nbevent){
            $nbnotifaff=$nbnotif-$nbevent;

            $em2 = $this->getDoctrine()->getManager();

            $RAW_QUERY = 'SELECT * FROM `evenement` ORDER BY id_evenement DESC limit '.$nbnotifaff;

            $statement = $em2->getConnection()->prepare($RAW_QUERY);
            $statement->execute();
            $es=$statement->fetchAll();

        }




        return $this->render('front.html.twig',['listeventproduct'=>$evenement,'listnotif'=>$es]);
    }

    /**
     * @return Response
     * @Route("/evenement/calendar", name="calendar")
     */
    public function CalendarMetier(EvenementRepository $repository){
        $listevenement=$repository->findAll();
            $events=[];

            foreach ($listevenement as $produit){
                $datedebut = new \DateTime($produit->getDateDebut());
                $datefin = new \DateTime($produit->getDateFin());

                $events[]=[
                    'id'=>$produit->getIdEvenement(),
                    'title'=>$produit->getTitre(),
                    'start'=>$datedebut->format('Y-m-d H:i:s'),
                    'end'=>$datefin->format('Y-m-d H:i:s')



                ];

            }
        $data=json_encode($events);

        return $this->render('/evenement/calendar.html.twig',['listevent'=>$listevenement,'data'=>$data]);
    }


    /**
     * @param Evenement|null $evenement
     * @param Request $request
     * @param $id
     * @param EvenementRepository $repository
     * @return Response
     * @throws \Exception
     * @Route ("/api/{id}/edit",name="api_event_id",methods={"PUT"})
     */
    public function majEvent(?Evenement $evenement,Request $request,$id,EvenementRepository $repository){
        $donnes=json_decode($request->getContent());
        dump($donnes);
        if(
            isset($donnes->title)&& !empty($donnes->title) &&
            isset($donnes->start)&& !empty($donnes->start) &&
            isset($donnes->end)&& !empty($donnes->end)
    ){
            if(!$evenement){
                $evenement=new Evenement();


            }
            $evenement
                ->setIdEvenement($id)
                ->setTitre($donnes->title)
                ->setDateDebut($donnes->start)
                ->setDateFin($donnes->end);
            $em=$this->getDoctrine()->getManager();
            $em->persist();
            $em->flush();

        }
        $listevenement=$repository->findAll();
        $events=[];

        foreach ($listevenement as $produit){
            $datedebut = new \DateTime($produit->getDateDebut());
            $datefin = new \DateTime($produit->getDateFin());

            $events[]=[
                'id'=>$produit->getIdEvenement(),
                'title'=>$produit->getTitre(),
                'start'=>$datedebut->format('Y-m-d H:i:s'),
                'end'=>$datefin->format('Y-m-d H:i:s')



            ];

        }
        $data=json_encode($events);

        return $this->render('/evenement/calendar.html.twig',['listevent'=>$listevenement,'data'=>$data]);

    }




}

