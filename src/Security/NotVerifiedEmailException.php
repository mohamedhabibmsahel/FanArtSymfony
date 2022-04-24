<?php


namespace App\Security;


use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;

class NotVerifiedEmailException extends  CustomUserMessageAuthenticationException
{
    public function __construct(
        string $messagee ="Ce compte ne semble pas posséder d'email verifie",
    array $messageData = [],
    int $code = 0,
    \Throwable $previous = null

){
        parent::__construct($messagee,$messageData,$code,$previous);
}

}