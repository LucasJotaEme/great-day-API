<?php

namespace App\Controller;

use App\Handler\TaskHandler;
use App\Request\GlobalRequest;
use App\Request\TaskCreateRequest;
use App\Request\TaskEditRequest;
use App\Request\TaskIdRequest;
use App\Request\TaskSearchRequest;
use App\Service\GlobalConfigManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/task")]
class TaskController extends GlobalConfigManager
{

    #[Route("/create", methods: ["POST"])]
    public function create(TaskCreateRequest $validator, TaskHandler $handler): Response
    {
        $params = GlobalRequest::getRequest();
        try{
            $task   = $handler->set($params);
            $result = $handler->beforeSave($task);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/edit", methods: ["POST"])]
    public function edit(TaskEditRequest $validator, TaskHandler $handler): Response
    {
        $params = GlobalRequest::getRequest();
        try{
            $task   = $handler->set($params, true);
            $result = $handler->beforeSave($task);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/remove", methods: ["POST"])]
    public function remove(TaskIdRequest $validator, TaskHandler $handler): Response
    {
        $params = GlobalRequest::getRequest();
        try{
            $result = $handler->remove($params);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/get", methods: ["POST"])]
    public function get(TaskIdRequest $validator, TaskHandler $handler): Response
    {
        $params = GlobalRequest::getRequest();
        try{
            $result = $handler->get($params);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/search", methods: ["POST"])]
    public function search(TaskSearchRequest $validator, TaskHandler $handler): Response
    {
        $params = GlobalRequest::getRequest();
        try{
            $result = $handler->search($params);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }
}
