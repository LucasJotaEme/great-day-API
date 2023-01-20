<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskSearchRequest extends GlobalRequest{
    
    #[Type("string")]
    protected $name;

    #[Type("integer")]
    protected $taskTypeId;
    
}