<?php

namespace App\Security;

use App\Repository\UserRepository;
use KnpU\OAuth2ClientBundle\Client\ClientRegistry;
use KnpU\OAuth2ClientBundle\Client\Provider\GithubClient;
use KnpU\OAuth2ClientBundle\Security\Authenticator\SocialAuthenticator;
use League\OAuth2\Client\Provider\GithubResourceOwner;
use League\OAuth2\Client\Token\AccessToken;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class GithubAuthenticator extends SocialAuthenticator
{
    use TargetPathTrait;
    private  $router;
    private  $clientRegistry;
    private  $userRepository;
    public function __construct(RouterInterface $router, ClientRegistry $clientRegistry, UserRepository $userRepository)
    {
        $this->router=$router;
        $this->clientRegistry=$clientRegistry;
        $this->userRepository=$userRepository;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        return new RedirectResponse($this->router->generate('app_login'));
    }

    public function supports(Request $request)
    {
        return 'oauth_check' === $request->attributes->get('_route') && $request->get('service') === 'github';
    }

    public function getCredentials(Request $request)
    {
        return $this->fetchAccessToken($this->clientRegistry->getClient('github'));
    }

    /**
     * @param AccessToken $credentials
     */
    public function getUser($credentials, UserProviderInterface $userProvider)
    {
        /**@Var GithubResourceOwner $githubUser*/

        $githubUser =$this->clientRegistry->getClient('github')->fetchUserFromToken($credentials);

        $response = HttpClient::create()->request(
            'GET',
            'https://api.github.com/user/emails',
            [
                'headers'=>[
                    'authorization' => "token {$credentials->getToken()}"
                ]
            ]
        );
        $emails= json_decode($response->getContent(),true);
        foreach ($emails as $email){
            if ($email['primary']=== true && $email['verified'] === true){
                $data = $githubUser->toArray();
                $data['email'] = $email['email'];
                $githubUser= new GithubResourceOwner($data);
            }
        }
        if ($githubUser->getEmail() === null){
            throw new NotVerifiedEmailException();
        }

        return $this->userRepository->findOrCreateFromOauth($githubUser);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        if ($request->hasSession()){
            $request->getSession()->set(Security::AUTHENTICATION_ERROR,$exception);
        }
        return new RedirectResponse($this->router->generate('app_login'));
    }

    /**
     * @param Request $request
     * @param TokenInterface $token
     * @param string $providerKey
     * @param UserRepository $repositoryp
     * @param AccessToken $credentials
     * @return RedirectResponse
     */

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey )
    {
        $targetPath = $this->getTargetPath($request->getSession(),$providerKey);

        $request->getSession()->get('id');

        return new RedirectResponse($targetPath ?: '/evenement/home');
//       dd($this->getCredentials($request));

//        dd($this->getUser($a,));

//        return new RedirectResponse($this->router->generate($targetPath));


    }


}