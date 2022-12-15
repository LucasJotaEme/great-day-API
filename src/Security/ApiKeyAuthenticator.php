<?php
namespace App\Security;

use App\Service\GlobalConfigManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;

class ApiKeyAuthenticator extends AbstractAuthenticator
{
    const HEADER_API_KEY  = "apiKey";
    const HEADER_USER     = "user";
    const HEADER_PASSWORD = "password";

    private $globalConfigManager;

    public function __construct(GlobalConfigManager $globalConfigManager){
        $this->globalConfigManager = $globalConfigManager;
    }

    /**
     * Called on every request to decide if this authenticator should be
     * used for the request. Returning `false` will cause this authenticator
     * to be skipped.
     */
    public function supports(Request $request): ?bool
    {
        return true;
    }

    public function authenticate(Request $request): Passport
    {
        $apiToken = $request->headers->get(self::HEADER_API_KEY);
        if (null === $apiToken) {
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

            throw new CustomUserMessageAuthenticationException('No API token provided');
        }
        return new SelfValidatingPassport(new UserBadge($apiToken));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $data = [
            // you may want to customize or obfuscate the message first
            'message' => strtr($exception->getMessageKey(), $exception->getMessageData())

            // or to translate this message
            // $this->translator->trans($exception->getMessageKey(), $exception->getMessageData())
        ];

        return new JsonResponse($data, Response::HTTP_UNAUTHORIZED);
    }
}