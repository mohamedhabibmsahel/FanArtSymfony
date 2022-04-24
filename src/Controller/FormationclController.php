<?php

namespace App\Controller;
use App\Entity\Reservation;
use App\Entity\Formation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Component\Form\FormTypeInterface;
use App\Entity\PropertySearch;

use App\Service\SmsGatewayService;

use App\Form\FormationType;
use App\Form\PropertySearchType;
use App\Repository\FormationRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Infobip\Configuration;
use Infobip\Api\SendSmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;


class FormationclController extends AbstractController
{
    /**
     * @Route("/formationcl", name="formationcl")
     */
    public function index(): Response
    {
        return $this->render('formationcl/index.html.twig', [
            'controller_name' => 'FormationclController',
        ]);
    }
    /**
     *@param FormationRepository $repository
     * @return Response
     * @Route ("listformationcl",name ="listformationcl")
     */
    public function Listformationcl(FormationRepository $repository, Request $request){
        $search = new PropertySearch();
        $form = $this -> createForm(PropertySearchType::class,$search);
        $form->handleRequest($request);
        $formarion=[];
        if($form->isSubmitted() && $form->isValid()){
            $prix = $search->getMaxprice();
            if ($prix!="")
                $formarion=$this->getDoctrine()->getRepository() ->findBy(['prix'=>$prix]);
            else
                $formarion=$this->getDoctrine()->getRepository()->findAll();
        }

        $formarion=$repository ->findAll();
        return $this->render('formationcl/listformationcl.html.twig',
            ['formation' => $formarion, 'form' =>$form->createView()]
        );
    }

    /**
     * @param Request $request
     * @return Response
     * @Route ("/formationcl/reservation/{idformation}",name ="reservation")
     */


    function Reservation(SmsGatewayService $smsGateway, FormationRepository $repository, $idformation, Request $request):Response {

        $formation=$repository->find($idformation);
        $form=$this->createForm(FormationType::class,$formation);
        $form->add('Modifier',submitType::class);
        $form->handleRequest($request); //gerer la requette

        if ($form->isSubmitted() && $form->isValid()){
            $datedebut=$request->request->get('start');
            $datefin=$request->request->get('end');
            $formation->setDateDebut($datedebut)
                ->setDateFin($datefin);



            try {
                $smsResponse = $smsGateway->send([
                    [
                        "to" => "21620191491",
                        "from" => "InfoSMS",
                        "message" => "Hello World! This is my first message sameh"
                    ],
                    [
                        "to" => "21620191491",
                        "from" => "InfoSMS",
                        "message" => "Hello World! This is my second message sameh br"
                    ]
                ]);
            } catch (\Throwable $apiException) {
                // HANDLE THE EXCEPTION
                dump($apiException);
            }

            $em=$this->getDoctrine()->getManager();
            $em->flush();

            return new Response("Success (?)");

        }
        return $this->render('formation/Modifier.html.twig',
            ['f'=> $form->createView(), 'formation'=>$formation]);
    }


    /**
     * @Route("/formation/formationdetail" , name="formationdetail")
     */

    public function FormationDetail(Request $request, PaginatorInterface $paginator  ):Response {

        $repository = $this->getDoctrine()->getRepository(Formation::class);
        $forma = $repository->trierParDate();
        $forma = $paginator->paginate(
            $forma,
            $request->query->getInt('page',1),
            3
        );
        return $this->render('formationcl/Formationdetail.html.twig',
            ['forma' => $forma,
            ]);
    }

    /**
     * @Route("/formation/searchNamecl", name="searchNamecl")
     */

    function SearchNamecl (FormationRepository $repository,Request $request) {
        $data=$request->get('find');
        $nom=$repository->findBy(['nomformation'=>$data]);
        return $this->render('formationcl/listformationcl.html.twig', [
            'formation' => $nom,
        ]);
    }

    /**
     * @Route("/formation/formationOrderASC" , name="formationOrderASCcl")
     */

    public function FormationOrderASC(){
        $repository = $this->getDoctrine()->getRepository(formation::class);
        $form = $repository->trierdomaineASC();
        return $this->render('formationcl/Listformationcl.html.twig', ['formation' => $form,]);
    }

    /**
     * @Route("/formation/formationOrderDESC" , name="formationOrderDESCcl")
     */

    public function FormationOrderDESC()  {
        $repository = $this->getDoctrine()->getRepository(formation::class);
        $form = $repository->trierdomaineDESC();
        return $this->render('formationcl/Listformationcl.html.twig', ['formation' => $form,]);
    }
    /**
     * @Route("/infopdf", name="infopdf", methods={"GET"})
     */

    public function Infopdf( FormationRepository $formationRepository): Response  {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('formationcl/Infopdf.html.twig',
            ['forma' => $formationRepository->findAll(),
            ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("formation.pdf", [
            "Attachment" => false
        ]);
    }

    /**
     * @Route("/formationpdf", name="formationpdf", methods={"GET"})
     */

    public function Formationpdf( FormationRepository $formationRepository): Response  {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();

        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('formationcl/Formationpdf.html.twig',
            ['forma' => $formationRepository->findAll(),
            ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("formation.pdf", [
            "Attachment" => false
        ]);
    }


