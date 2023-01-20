<?php

namespace App\Controller;

use App\Handler\TaskTypeHandler;
use App\Request\GlobalRequest;
use App\Request\TaskRemoveRequest;
use App\Request\TaskTypeGetRequest;
use App\Service\GlobalConfigManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/task-type")]
class TaskTypeController extends GlobalConfigManager
{

    #[Route("/get", methods: ["POST"])]
    public function get(TaskTypeGetRequest $validator, TaskTypeHandler $handler): Response
    {
        $params = GlobalRequest::getRequest();
        try{
            $result = $handler->get($params);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }
}
