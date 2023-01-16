<?php

namespace App\Controller;

use App\Handler\UserHandler as HandlerUserHandler;
use App\Request\GlobalRequest;
use App\Request\UserRequest;
use App\Service\GlobalConfigManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends GlobalConfigManager
{

    #[Route('/login', name: 'login')]
    public function login(HandlerUserHandler $userHandler): JsonResponse
    {
        $user = $this->getUser();
        $token = $this->generateToken();
        
        $user->setApiToken($token);
        $this->repository($userHandler::USER_ENTITY_NAME)->save($user, true);
        return $this->customResponse($token);
    }

    #[Route('/user/create', methods: ['POST'])]
    public function userCreate(UserRequest $userRequest, HandlerUserHandler $userHandler, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        try{
            $params = GlobalRequest::getRequest()->toArray();
            $user   = $userHandler->set($params, $passwordHasher);
            $result = $userHandler->beforeSave($user);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $result;
    }
}
