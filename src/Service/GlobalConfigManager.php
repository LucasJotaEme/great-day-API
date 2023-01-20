<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class GlobalConfigManager extends AbstractController{


    public function __construct(protected EntityManagerInterface $entityManager){
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
                "result" => json_decode($this->generateSerializer($result, "json")),
                "error"  => $error
            )
        );
    }

    private function generateSerializer($result, $format){
        $encoders = [new JsonEncoder()];
        $normalizers = [new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer->serialize($result, $format, [
            'circular_reference_handler' => function ($object) {
                return $object->getId();
            }
        ]);
    }

}