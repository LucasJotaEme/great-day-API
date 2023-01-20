<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskCreateRequest extends GlobalRequest{

    #[NotBlank(), Type("string")]
    protected $name;

    #[NotBlank(), Type("integer")]
    protected $userId;

    #[NotBlank(), Type("integer")]
    protected $taskTypeId;
    
}