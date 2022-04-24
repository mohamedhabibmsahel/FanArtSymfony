<?php

namespace App\Controller;

use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use Symfony\Component\HttpFoundation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(HttpFoundation\Request $request,AuthenticationUtils $authenticationUtils): Response
    {
//         if ($this->getUser()) {
//             return $this->redirectToRoute('home');
//         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route ("/connect/github", name="github_connect")
     */

    public function connect (ClientRegistry $clientRegistry): HttpFoundation\RedirectResponse{
        $client = $clientRegistry->getClient('github');
        return $client->redirect(['read:user','user:email']);

    }

    /**
     * @Route ("/connect/facebook", name="facebook_connect")
     */

    public function connectfb (ClientRegistry $clientRegistry): HttpFoundation\RedirectResponse{
//        $client = $clientRegistry->getClient('facebook');
//        return $client->redirect(['public_profile', 'email']);
        $client = $this->get('oauth2.registry')
            ->getClient('facebook_main');

        $user = $client->fetchUser();
        // do something with all this new power!
        $user->getFirstName();

    }

    /**
     *
     * @Route("/connect/google", name="google_connect")
     * @param ClientRegistry $clientRegistry
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectAction(ClientRegistry $clientRegistry)
    {
        return $clientRegistry
            ->getClient('google')
            ->redirect();
    }

    /**
     * Facebook redirects to back here afterward
     *
     * @Route("/connect/google/check", name="connect_google_check")
     * @param Request $request
     * @return JsonResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function connectCheckAction(Request $request)
    {
        if (!$this->getUser()) {
            return new JsonResponse(array('status' => false, 'message' => "User not found!"));
        } else {
            return $this->redirectToRoute('app_login');
        }

    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('app_login');
    }
}
