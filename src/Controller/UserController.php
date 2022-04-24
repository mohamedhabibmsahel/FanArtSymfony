<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationOauthType;
use App\Form\ResetPasswordType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Session\Session;
/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @Route("/", name="user_index", methods={"GET"})
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="user_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index');
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @param $id
     * @param UserRepository $userRepository
     * @return Response
     * @Route("user/{id}", name="user_show")
     */
    public function show($id,UserRepository $userRepository): Response
    {
//        return $this->render('user/show.html.twig', [
//            'user' => $user,
//        ]);
        return $this->render('user/show.html.twig', ['users' => $userRepository->findOneBy(['id'=>$id])]);
    }




    /**
     * @Route("/{id}/edit", name="user_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('photo')->getData();
            $user->setMdp(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('mdp')->getData()
                ));
            $um=substr($image,strpos($image,'\\tmp')+5,strlen($image)-strripos($image,"tmp",0)+8);
            $upload_directory=$this->getParameter('upload_directory');
            $image->move($upload_directory,$image);

            $user->setPhoto($um);
            $this->getDoctrine()->getManager()->flush();

            return $this->render('user/show.html.twig', [
                'user' => $user,

            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/Oauth", name="user_edit_Oauth", methods={"GET","POST"})
     */
    public function editOauth(Request $request, User $user,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('photo')->getData();
            $user->setMdp(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('mdp')->getData()
                ));
            $um=substr($image,strpos($image,'\\tmp')+5,strlen($image)-strripos($image,"tmp",0)+8);
            $upload_directory=$this->getParameter('upload_directory');
            $image->move($upload_directory,$image);

            $user->setPhoto($um);
            $this->getDoctrine()->getManager()->flush();

            return $this->render('user/show.html.twig', [
                'user' => $user,

            ]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }
        $session = new Session();
        $session->invalidate();
        return $this->redirectToRoute('app_login');
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     * @Route ("/test", name="modifiermdp")
     */
    public function editAction(Request $request)

    {

        $em = $this->getDoctrine()->getManager();

        $user = $this->getUser();

        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $passwordEncoder = $this->get('security.password_encoder');

            $oldPassword = $request->request->get('etiquettebundle_user')['oldPassword'];

            // Si l'ancien mot de passe est bon

            if ($passwordEncoder->isPasswordValid($user, $oldPassword)) {





                $em->persist($user);

                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('profile');

            } else {

                $form->addError(new FormError('Ancien mot de passe incorrect'));

            }

        }



        return $this->render('account/edit.html.twig', array(

            'form' => $form->createView(),

        ));

    }
}
