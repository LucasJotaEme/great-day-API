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

#[Route("/user")]
class UserController extends GlobalConfigManager
{

    #[Route('/login', name: 'login')]
    public function login(HandlerUserHandler $handler): JsonResponse
    {
        $user = $this->getUser();
        $token = $this->generateToken();
        
        $user->setApiToken($token);
        $this->repository($handler::ENTITY_NAME)->save($user, true);
        return $this->customResponse($token);
    }

    #[Route('/create', methods: ["POST"])]
    public function userCreate(UserRequest $validator, HandlerUserHandler $handler, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        try{
            $params   = GlobalRequest::getRequest();
            $user     = $handler->set($params, $passwordHasher);
            $response = $handler->beforeSave($user);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($response);
    }
}
