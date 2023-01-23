<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class WorkerUserEditRequest extends GlobalRequest{

    #[NotBlank(), Type("integer")]
    protected $workerUserId;

    #[Type(["integer","float"])]
    protected $workingMinutes;

    #[Type(["integer","float"])]
    protected $restMinutes;

    #[Type(["integer","float"])]
    protected $totalWorkingHours;

    #[Type("integer")]
    protected $userId;
    
}