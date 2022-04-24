<?php

namespace App\Controller;

use App\Entity\Recprod;
use App\Form\RecpType;
use App\Repository\RecprodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class RecprodController extends AbstractController
{

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     * @Route ("/recprod/addr", name="recprod_add")
     *
     */
    public function addrecp(Request $request, \Swift_Mailer $mailer){

        $recpp=new Recprod();
        $form=$this->createForm(RecpType::class,$recpp);
        $form->handleRequest($request);

        if ($this->getUser())
        {
            $email = $this->getUser()->getEmail();
        }
        else
        {
            $email = "mhabybs@gmail.com";
        }

        $recpp->setStatus('pending')
            ->setEmail($email);

        if ($form->isSubmitted() && $form->isValid()){

            $message = (new \Swift_Message('Reclamation'))
                ->setFrom('fanart3a18@gmail.com')
                ->setTo($email)
                ->setBody("Votre Reclamation a été transmise avec succes! merci pour votre contribution!",
                    'text/html'
                )
            ;

            $mailer->send($message);

            $em=$this->getDoctrine()->getManager();
              $em->persist($recpp);
              $em->flush();
              return $this->redirectToRoute('listrecp');

        }
        return $this->render('/recprod/addr.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param RecprodRepository $repository
     * @return Response
     * @Route ("/recprod/listrecp", name="listrecp")
     */

    public function displayAll(RecprodRepository $repository){
        if ($this->getUser())
        {
            $email = $this->getUser()->getEmail();
        }
        else
        {
            $email = "mhabybs@gmail.com";
        }
        $recprod=$repository->findByEmail($email);
        return $this->render('recprod/listrecp.html.twig',['recp'=>$recprod]);
    }

    /**
     * @param $id
     * @param RecprodRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/recprod/supprp/{id}" ,name="supprecp")
     */
    public function delete($id,RecprodRepository $repository){
        $recp=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($recp);
        $em->flush();
        return $this->redirectToRoute('listrecp');
    }

    /**
     * @Route("/show/{recprod}", name="recprod_show", methods={"GET"})
     */
    public function show(Recprod $recprod): Response
    {
        return $this->render('recprod/show.html.twig', [
            'recprod' => $recprod,
        ]);
    }

    /**
     * @Route("/see/{recprod}", name="recprod_seen", methods={"GET"})
     */
    public function seeRecprod(Recprod $recprod): Response
    {
        $recprod->setStatus('seen');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($recprod);
        $entityManager->flush();
        return $this->render('recprod/show.html.twig', [
            'recprod' => $recprod,
        ]);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Response
     * @Route ("/recprod/addrB", name="recprod_addB")
     *
     */
    public function addrecpB(Request $request, \Swift_Mailer $mailer){

        $recpp=new Recprod();
        $form=$this->createForm(RecpType::class,$recpp);
        $form->handleRequest($request);

        if ($this->getUser())
        {
            $email = $this->getUser()->getEmail();
        }
        else
        {
            $email = "mhabybs@gmail.com";
        }

        $recpp->setStatus('pending')
            ->setEmail($email);

        if ($form->isSubmitted() && $form->isValid()){

            $message = (new \Swift_Message('Reclamation'))
                ->setFrom('mhabybs@gmail.com')
                ->setTo('mhabybs@gmail.com')
                ->setBody("Votre Reclamation a été transmise avec succes! merci pour votre contribution!",
                    'text/html'
                )
            ;


            $mailer->send($message);

            $em=$this->getDoctrine()->getManager();
            $em->persist($recpp);
            $em->flush();
            return $this->redirectToRoute('listrecp');

        }
        return $this->render('/recprodB/addr.html.twig',[
            'form'=>$form->createView()
        ]);
    }

    /**
     * @param RecprodRepository $repository
     * @return Response
     * @Route ("/recprod/listrecpB", name="listrecpB")
     */

    public function displayAllB(RecprodRepository $repository){
        $recprod=$repository->findAll();
        return $this->render('recprodB/listrecp.html.twig',['recp'=>$recprod]);
    }

    /**
     * @param $id
     * @param RecprodRepository $repository
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     * @Route ("/recprod/supprpB/{id}" ,name="supprecpB")
     */
    public function deleteB($id,RecprodRepository $repository){
        $recp=$repository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($recp);
        $em->flush();
        return $this->redirectToRoute('listrecpB');
    }

    /**
     * @Route("/showB/{recprod}", name="recprod_showB", methods={"GET"})
     */
    public function showB(Recprod $recprod): Response
    {
        return $this->render('recprodB/show.html.twig', [
            'recprod' => $recprod,
        ]);
    }

    /**
     * @Route("/seeB/{recprod}", name="recprod_seenB", methods={"GET"})
     */
    public function seeRecprodB(Recprod $recprod): Response
    {
        $recprod->setStatus('seen');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($recprod);
        $entityManager->flush();
        return $this->render('recprodB/show.html.twig', [
            'recprod' => $recprod,
        ]);
    }


}
