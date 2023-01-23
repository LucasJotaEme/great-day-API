<?php

namespace App\Controller;

use App\Handler\TaskHandler;
use App\Handler\WorkerUserHandler;
use App\Request\GlobalRequest;
use App\Request\TaskCreateRequest;
use App\Request\TaskEditRequest;
use App\Request\TaskIdRequest;
use App\Request\TaskSearchRequest;
use App\Request\WorkerUserCreateRequest;
use App\Request\WorkerUserEditRequest;
use App\Service\GlobalConfigManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/worker-user")]
class WorkerUserController extends GlobalConfigManager
{

    #[Route("/create", methods: ["POST"])]
    public function create(WorkerUserHandler $handler, WorkerUserCreateRequest $automatizedValidator): Response
    {
        try{
            $request    = GlobalRequest::getRequest();
            $workerUser = $handler->set($request);
            $result     = $handler->beforeSave($workerUser);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/edit", methods: ["POST"])]
    public function edit(WorkerUserHandler $handler, WorkerUserEditRequest $automatizedValidator): Response
    {
        try{
            $request    = GlobalRequest::getRequest();
            $workerUser = $handler->set($request, true);
            $result     = $handler->beforeSave($workerUser);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }
}
