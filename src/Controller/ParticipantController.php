<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class ParticipantController extends AbstractController
{
    public $x;
    public function setevent($id){
        $x=$id;
    }
    public function getevent(){
        return $this->x;
    }


    /**
     * @param Request $request
     * @param $id
     * @return Response
     * @Route("/participant{id}", name="participant")
     */
    public function index(EvenementRepository $repository,Request $request,$id): Response
    {
        $this->setevent($id);
        $evenement=$repository->findOneBy(['idEvenement'=>$id]);

        return $this->render('participant/index.html.twig', [
          'event'=>$evenement,
        ]);
    }


    /**
     * @return Response
     * @Route ("/create-checkout-session", name="checkout")
     */
    public function checkout(){
        $idevent=$this->getevent();
        $em=$this->getDoctrine()->getRepository(Evenement::class)->find(360);


        \Stripe\Stripe::setApiKey('sk_test_51IYHfGBQ0LLhBexiKiPzJjHM7f7z3koVIrDiiEr4hfUu35iV558XKAIZIiY3Xbm9tkF6zCn0fEjTXRpt4aIYmpww00p9s6z11h');
        header('Content-Type: application/json');

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' =>$em->getPrix()*100,
                    'product_data' => [
                        'name' => $em->getTitre(),
                        'images' => ["https://global-uploads.webflow.com/5ef5480befd392489dacf544/5f9f5e5943de7e69a1339242_5f44a7398c0cdf460857e744_img-image.jpeg"],
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $this->generateUrl('success',[],UrlGeneratorInterface::ABSOLUTE_URL),
            'cancel_url' => $this->generateUrl('error',[],UrlGeneratorInterface::ABSOLUTE_URL),
        ]);

        return new JsonResponse(['id'=>$session->id]);


    }

    /**
     * @Route ("/success",name="success")
     */
    public function success(){
        return $this->render('participant/success.html.twig');



    }
    /**
     * @Route ("/error",name="error")
     */
    public function error(){
        return $this->render('participant/error.html.twig');



    }
}
