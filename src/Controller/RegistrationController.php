<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\RegistrationOauthType;
use App\Form\UserType;
use App\Security\EmailVerifier;
use App\Security\UserAuthAuthenticator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    private $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    /**
     * @Route("/register", name="app_register")
     */
    public function register(AuthenticationUtils $authenticationUtils,Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UserAuthAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setMdp(
                $passwordEncoder->encodePassword(
                   $user,
                   $form->get('mdp')->getData()
                )

            );

            $image = $form->get('photo')->getData();

            $um=substr($image,strpos($image,'\\tmp')+5,strlen($image)-strripos($image,"tmp",0)+8);
            $upload_directory=$this->getParameter('upload_directory');
            $image->move($upload_directory,$image);

            $user->setPhoto($um);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername, 'error' => $error]);
            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                   ->from(new Address('fanart3a18@gmail.com', 'Confirmation par Mail'))
//                    ->to($user->getEmail())
//                    ->subject('Merci de confirmer votre email')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
           // do anything else you need here, like send an email

        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("/register", name="app_registerv2")
     */
    public function registerOauth(AuthenticationUtils $authenticationUtils,Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UserAuthAuthenticator $authenticator): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationOauthType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setMdp(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('mdp')->getData()
                )

            );

            $image = $form->get('photo')->getData();

            $um=substr($image,strpos($image,'\\tmp')+5,strlen($image)-strripos($image,"tmp",0)+8);
            $upload_directory=$this->getParameter('upload_directory');
            $image->move($upload_directory,$image);

            $user->setPhoto($um);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $error = $authenticationUtils->getLastAuthenticationError();
            // last username entered by the user
            $lastUsername = $authenticationUtils->getLastUsername();

            return $this->render('security/login.html.twig', [
                'last_username' => $lastUsername, 'error' => $error]);
            // generate a signed url and email it to the user
//            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
//                (new TemplatedEmail())
//                   ->from(new Address('fanart3a18@gmail.com', 'Confirmation par Mail'))
//                    ->to($user->getEmail())
//                    ->subject('Merci de confirmer votre email')
//                    ->htmlTemplate('registration/confirmation_email.html.twig')
//            );
            // do anything else you need here, like send an email

        }

        return $this->render('registration/ContinueReg.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
//    /**
//     * @Route("/verify/email", name="app_verify_email")
//     */
//    public function verifyUserEmail(Request $request): Response
//    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//
//        // validate email confirmation link, sets User::isVerified=true and persists
//        try {
//            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
//        } catch (VerifyEmailExceptionInterface $exception) {
//            $this->addFlash('verify_email_error', $exception->getReason());
//
//            return $this->redirectToRoute('app_register');
//        }
//
//        // @TODO Change the redirect on success and handle or remove the flash message in your templates
//        $this->addFlash('success', 'Votre adresse email a été validé');
//
//        return $this->redirectToRoute('app_register');
//    }
}
