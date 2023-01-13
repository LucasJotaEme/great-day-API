<?php

namespace App\Handler;

use App\Entity\User;
use App\Service\GlobalConfigManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserHandler extends GlobalConfigManager{

    const USER_ENTITY_NAME = "User";

    public function set($params, UserPasswordHasherInterface $passwordHasher){
        $email = $params["email"];
        $psw   = $params["password"];

        $user = new User();
        $user->setEmail($email);
        $user->setPassword($passwordHasher->hashPassword(
            $user,
            $psw
        ));
        return $user;
    }

    public function beforeSave(User $user){
        $repository = $this->repository(self::USER_ENTITY_NAME);
        $email = $user->getEmail();
        if(empty($repository->findBy(array("email" => $email)))){
            try{
                $this->repository(self::USER_ENTITY_NAME)->save($user, true);
                return $this->customResponse($user);
            }catch(\Exception $e){
                throw new \Exception($e->getMessage());
            }
        }else{
            throw new \Exception("Email $email already exists");
        }
        return $user;
    }
}