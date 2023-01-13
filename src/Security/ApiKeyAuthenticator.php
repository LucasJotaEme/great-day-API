<?php
namespace App\Security;

use App\Service\GlobalConfigManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    const HEADER_API_KEY  = "apiKey";
    const HEADER_USER     = "user";
    const HEADER_PASSWORD = "password";
    const REQUEST_LOGIN   = "login";

    private $globalConfigManager;

    public function __construct(GlobalConfigManager $globalConfigManager){
        $this->globalConfigManager = $globalConfigManager;
    }
    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->headers->get(self::HEADER_API_KEY);
        if (null === $apiToken){
            if(strpos($request->getRequestUri(), self::REQUEST_LOGIN)){
                $user = $request->headers->has(self::HEADER_USER);
                $psw  = $request->headers->has(self::HEADER_PASSWORD);
                if($user && $psw){
                    $user = $request->headers->get(self::HEADER_USER);
                    $psw  = $request->headers->get(self::HEADER_PASSWORD);
                    $passport = new Passport(
                        new UserBadge($user, function ($userIdentifier){
                        return $this->globalConfigManager->repository("User")->findOneBy(array("email" => $userIdentifier));
                        }),
                        new PasswordCredentials($psw)
                    );
                    return $passport;
                }
                throw new CustomUserMessageAuthenticationException('No user or password provided');
            }else{
                throw new CustomUserMessageAuthenticationException('No API token provided');
            }
        }
        $userByApiToken = $this->globalConfigManager->repository("User")->findOneBy(array("apiToken" => $apiToken));
        if(null === $userByApiToken){
            throw new CustomUserMessageAuthenticationException("User with API token $apiToken not found");
        }
        return new SelfValidatingPassport(new UserBadge($userByApiToken->getEmail()));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())
        ];
        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}