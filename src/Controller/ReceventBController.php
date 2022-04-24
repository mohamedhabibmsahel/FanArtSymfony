<?php

namespace App\Controller;

use App\Entity\Recevent;
use App\Form\ReceventType;
use App\Repository\ReceventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/receventB")
 */
class ReceventBController extends AbstractController
{
    /**
     * @Route("/", name="recevent_indexB", methods={"GET"})
     */
    public function index(ReceventRepository $receventRepository): Response
    {
        return $this->render('receventB/index.html.twig', [
            'recevents' => $receventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="recevent_newB", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $recevent = new Recevent();
        $form = $this->createForm(ReceventType::class, $recevent);
        $form->handleRequest($request);
        if ($this->getUser())
        {
            $email = $this->getUser()->getEmail();
        }
        else
        {
            $email = "mhabybs@gmail.com";
        }

        $recevent->setStatus('pending')
            ->setEmail($email);



        if ($form->isSubmitted() && $form->isValid()) {

            $message = (new \Swift_Message('Reclamation'))
                ->setFrom('fanart3a18@gmail.com')
                ->setTo($email)
                ->setBody("Votre Reclamation a été transmise avec succes! merci pour votre contribution!",
                    'text/html'
                )
            ;

            $mailer->send($message);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recevent);
            $entityManager->flush();

            return $this->redirectToRoute('recevent_indexB');
        }

        return $this->render('receventB/new.html.twig', [
            'recevent' => $recevent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{receid}", name="recevent_showB", methods={"GET"})
     */
    public function show(Recevent $recevent): Response
    {
        return $this->render('receventB/show.html.twig', [
            'recevent' => $recevent,
        ]);
    }

    /**
     * @Route("/see/{receid}", name="recevent_seenB", methods={"GET"})
     */
    public function seeRecevent(Recevent $recevent): Response
    {
        $recevent->setStatus('seen');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($recevent);
        $entityManager->flush();
        return $this->render('receventB/show.html.twig', [
            'recevent' => $recevent,
        ]);
    }

    /**
     * @Route("/{receid}/edit", name="recevent_editB", methods={"GET","POST"})
     */
    public function edit(Request $request, Recevent $recevent): Response
    {
        $form = $this->createForm(ReceventType::class, $recevent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recevent_indexB');
        }

        return $this->render('receventB/edit.html.twig', [
            'recevent' => $recevent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{receid}", name="recevent_deleteB", methods={"POST"})
     */
    public function delete(Request $request, Recevent $recevent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recevent->getReceid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recevent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recevent_indexB');
    }
}
