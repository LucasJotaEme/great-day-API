<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\GlobalConfigManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends GlobalConfigManager
{

    #[Route('/login', name: 'login')]
    public function login(): JsonResponse
    {
        $user = $this->getUser();
        $token = $this->generateToken();
        $user->setApiToken($token);
        $this->repository("User")->save($user, true);
        return $this->customResponse($token);
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

    //     $this->repository("User")->save($user, true);
    //     return $this->json([
    //         'message' => 'Welcome to your new controller!',
    //         'path' => 'src/Controller/UserController.php',
    //     ]);
    // }
}
