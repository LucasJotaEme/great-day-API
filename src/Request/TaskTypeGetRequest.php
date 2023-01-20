<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskTypeGetRequest extends GlobalRequest{

    #[NotBlank(), Type("integer")]
    protected $taskTypeId;
    
}