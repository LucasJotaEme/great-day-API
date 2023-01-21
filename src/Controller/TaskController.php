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
    public function create(TaskHandler $handler, TaskCreateRequest $automatizedValidator): Response
    {
        try{
            $request = GlobalRequest::getRequest();
            $result  = ($task = $handler->set($request)) && $handler->beforeSave($task);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/edit", methods: ["POST"])]
    public function edit(TaskHandler $handler, TaskEditRequest $automatizedValidator): Response
    {
        try{
            $request = GlobalRequest::getRequest();
            $result  = ($task = $handler->set($request)) && $handler->beforeSave($task);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/remove", methods: ["POST"])]
    public function remove(TaskHandler $handler, TaskIdRequest $automatizedValidator): Response
    {
        try{
            $request = GlobalRequest::getRequest();
            $result  = $handler->remove($request);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/get", methods: ["POST"])]
    public function get(TaskHandler $handler, TaskIdRequest $automatizedValidator): Response
    {
        try{
            $request = GlobalRequest::getRequest();
            $result  = $handler->get($request);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/search", methods: ["POST"])]
    public function search(TaskHandler $handler, TaskSearchRequest $automatizedValidator): Response
    {
        try{
            $request = GlobalRequest::getRequest();
            $result  = $handler->search($request);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }
}
