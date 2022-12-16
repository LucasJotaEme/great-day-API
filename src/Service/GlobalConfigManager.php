<?php

namespace App\Service;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GlobalConfigManager extends AbstractController{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager){
        $this->entityManager = $entityManager;
    }

    public function repository($entityName){
        return $this->entityManager->getRepository(
            $this->getParameter("entity_route") . $entityName
        );
    }

    public function generateToken(){
        return bin2hex(openssl_random_pseudo_bytes(16));
    }

    public function customResponse($result, $error = null){
        return $this->json(
            array(
                "result" => $result,
                "error"  => $error
            )
            );
    }

}