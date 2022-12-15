<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\GlobalConfigManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

class UserController extends AbstractController
{
    private $globalConfigManager;

    public function __construct(GlobalConfigManager $globalConfigManager)
    {
        $this->globalConfigManager = $globalConfigManager;
    }

    #[Route('/login', name: 'login')]
    public function login(): JsonResponse
    {
        $user = $this->getUser();
        $token = $this->globalConfigManager->generateToken();

        $user->setApiToken($token);
        $this->globalConfigManager->repository("User")->save($user, true);
        return $this->json([
            'result' => $token
        ]);
    }

    // #[Route('/user/create', name: 'user_create')]
    // public function userCreate(UserPasswordHasherInterface $passwordHasher): JsonResponse
    // {
    //     $user = new User();
    //     $user->setEmail("lucasmaldonado10@hotmail.com");
    //     $user->setPassword($passwordHasher->hashPassword(
    //         $user,
    //         "lucas"
    //     ));

    //     $this->globalConfigManager->repository("User")->save($user, true);
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/UserController.php',
    //     ]);
    // }
}
