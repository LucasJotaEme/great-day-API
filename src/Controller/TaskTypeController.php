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
    public function get(TaskTypeHandler $handler, TaskTypeGetRequest $automatizedValidator): Response
    {
        try{
            $request = GlobalRequest::getRequest();
            $result  = $handler->get($request);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }
}
