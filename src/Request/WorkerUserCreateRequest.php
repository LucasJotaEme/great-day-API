<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class WorkerUserCreateRequest extends GlobalRequest{

    #[Type(["integer","float"])]
    protected $workingMinutes;

    #[Type(["integer","float"])]
    protected $restMinutes;

    #[Type(["integer","float"])]
    protected $totalWorkingHours;

    #[NotBlank(), Type("integer")]
    protected $userId;
    
}