<?php

namespace App\Request;

use App\Service\GlobalConfigManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class GlobalRequest{

    public function __construct(protected ValidatorInterface $validator, public GlobalConfigManager $globalConfigManager){
        dd($request->server->get('SERVER_NAME'));
        $this->populate();

        if ($this->autoValidateRequest()) {
            $this->validate();
        }
    }

    public function validate(){
        $errors =  $this->validator->validate($this);
        $messages = ['message' => 'validation_failed', 'errors' => []];
        /** @var \Symfony\Component\Validator\ConstraintViolation  */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => $message->getPropertyPath(),
                'value' => $message->getInvalidValue(),
                'message' => $message->getMessage(),
            ];
        }
        if (count($messages['errors']) > 0) {
            $response = new JsonResponse($messages, 201);
            $response->send();

            exit;
        }
    }

    public static function getRequest(){
        return Request::createFromGlobals();
    }

    protected function populate(){
        try{
            $requestAsArray = $this->getRequest()->toArray();
            foreach($requestAsArray as $property => $value){
                if(property_exists($this, $property)){
                    $this->{$property} = $value;
                }
            }
        }catch(\Exception $e){

        }
    }

    protected function autoValidateRequest(): bool{
        return false;
    }
}
