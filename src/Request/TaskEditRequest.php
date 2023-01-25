<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class TaskEditRequest extends GlobalRequest{

    #[NotBlank(), Type("integer")]
    protected $taskId;
    
    #[NotBlank(), Type("string")]
    protected $name;

    #[Type("integer")]
    protected $userId;

    #[Type("integer")]
    protected $taskTypeId;
    
}