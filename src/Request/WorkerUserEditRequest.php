<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class WorkerUserEditRequest extends GlobalRequest{

    #[NotBlank(), Type("integer")]
    protected $workerUserId;

    #[NotBlank(), Type(["integer","float"])]
    protected $workingMinutes;

    #[NotBlank(), Type(["integer","float"])]
    protected $restMinutes;

    #[NotBlank(), Type(["integer","float"])]
    protected $totalWorkingHours;

    #[NotBlank(), Type("integer")]
    protected $userId;
    
}