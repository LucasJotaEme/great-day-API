<?php

namespace App\Handler;

use App\Entity\User;
use App\Service\GlobalConfigManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserHandler extends GlobalConfigManager{

    const ENTITY_NAME = "User";
    const ID_PARAM    = "userId";

    public function set($params, UserPasswordHasherInterface $passwordHasher, $edit = false){
        $userId   = isset($params[self::ID_PARAM]) ? $params[self::ID_PARAM]  : 0;
        $email    = $params["email"];
        $psw      = isset($params["password"])     ? $params["password"]      : null;
        $userName = $params["userName"];

        $user = !$edit ? new User() : $this->ifExistsGetUserById($userId);
        $user->setEmail($email);
        if($this->validatePassword($psw))
            $user->setPassword($passwordHasher->hashPassword($user,$psw));
        $user->setUserName($userName);
        return $user;
    }

    public function beforeSave(User $user){
        $this->validateEmailAndUserNameInRepository($user);

        $this->repository(self::ENTITY_NAME)->save($user, true);
        return $user;
    }

    public function remove($params){
        $id = isset($params[self::ID_PARAM]) ? $params[self::ID_PARAM] : 0;

        $this->repository(self::ENTITY_NAME)->remove($this->ifExistsGetUserById($id), true);
        return "Deleted task";
    }

    public function get($params){
        $id = isset($params[self::ID_PARAM]) ? $params[self::ID_PARAM] : 0;

        return $this->ifExistsGetUserById($id);
    }

    private function ifExistsGetUserById($userId){
        $user = $this->repository(self::ENTITY_NAME)->find($userId);
        
        if(null === $user)
            throw new \Exception("User with id $userId not found");
        return $user;
    }

    private function validatePassword($psw):bool{
        if(null !== $psw)
            return true;
        else
            return false;
    }

    private function validateEmailAndUserNameInRepository(User $user){
        $repository               = $this->repository(self::ENTITY_NAME);
        $existingUserWithEmail    = $repository->findOneBy(array("email" => $user->getEmail()));
        $existingUserWithUserName = $repository->findOneBy(array("userName" => $user->getUserName()));

        if(null !== $existingUserWithEmail && $existingUserWithEmail->getId() != $user->getId())
            throw new \Exception("User with email {$user->getEmail()} already exists");
        if(null !== $existingUserWithUserName && $existingUserWithUserName->getId() != $user->getId())
            throw new \Exception("User with userName {$user->getUserName()} already exists");
    }
}