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
 * @Route("/recevent")
 */
class ReceventController extends AbstractController
{
    /**
     * @Route("/", name="recevent_index", methods={"GET"})
     */
    public function index(ReceventRepository $receventRepository): Response
    {
        if ($this->getUser())
        {
            $email = $this->getUser()->getEmail();
        }
        else
        {
            $email = "mhabybs@gmail.com";
        }

        return $this->render('recevent/index.html.twig', [
            'recevents' => $receventRepository->findByEmail($email),
        ]);
    }

    /**
     * @Route("/new", name="recevent_new", methods={"GET","POST"})
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
                ->setFrom('mhabybs@gmail.com')
                ->setTo('mhabybs@gmail.com')
                ->setBody("Votre Reclamation a été transmise avec succes! merci pour votre contribution!",
                    'text/html'
                )
            ;

            $mailer->send($message);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($recevent);
            $entityManager->flush();

            return $this->redirectToRoute('recevent_index');
        }

        return $this->render('recevent/new.html.twig', [
            'recevent' => $recevent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{receid}", name="recevent_show", methods={"GET"})
     */
    public function show(Recevent $recevent): Response
    {
        return $this->render('recevent/show.html.twig', [
            'recevent' => $recevent,
        ]);
    }

    /**
     * @Route("/see/{receid}", name="recevent_seen", methods={"GET"})
     */
    public function seeRecevent(Recevent $recevent): Response
    {
        $recevent->setStatus('seen');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($recevent);
        $entityManager->flush();
        return $this->render('recevent/show.html.twig', [
            'recevent' => $recevent,
        ]);
    }

    /**
     * @Route("/{receid}/edit", name="recevent_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Recevent $recevent): Response
    {
        $form = $this->createForm(ReceventType::class, $recevent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('recevent_index');
        }

        return $this->render('recevent/edit.html.twig', [
            'recevent' => $recevent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{receid}", name="recevent_delete", methods={"POST"})
     */
    public function delete(Request $request, Recevent $recevent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$recevent->getReceid(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($recevent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('recevent_index');
    }
}
