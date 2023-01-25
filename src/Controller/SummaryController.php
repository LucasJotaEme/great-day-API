<?php

namespace App\Controller;

use App\Handler\SummaryHandler;
use App\Request\GlobalRequest;
use App\Request\SummaryCreateRequest;
use App\Request\SummaryDateAndUserRequest;
use App\Request\SummaryEditRequest;
use App\Request\SummarySearchRequest;
use App\Service\GlobalConfigManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/summary")]
class SummaryController extends GlobalConfigManager
{

    #[Route("/create", methods: ["POST"])]
    public function create(SummaryHandler $handler, SummaryCreateRequest $automatizedValidator): Response
    {
        try{
            $request = GlobalRequest::getRequest();
            $summary = $handler->set($request);
            $result  = $handler->beforeSave($summary);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/edit", methods: ["POST"])]
    public function edit(SummaryHandler $handler, SummaryEditRequest $automatizedValidator): Response
    {
        try{
            $request = GlobalRequest::getRequest();
            $summary = $handler->set($request, true);
            $result  = $handler->beforeSave($summary);
        }catch(\Exception $e){
            return $this->customResponse(null, $e->getMessage());
        }
        return $this->customResponse($result);
    }

    #[Route("/remove", methods: ["POST"])]
    public function remove(SummaryHandler $handler, SummaryDateAndUserRequest $automatizedValidator): Response
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
    public function get(SummaryHandler $handler, SummaryDateAndUserRequest $automatizedValidator): Response
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
    public function search(SummaryHandler $handler, SummarySearchRequest $automatizedValidator): Response
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
