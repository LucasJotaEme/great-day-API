<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class SummaryCreateRequest extends GlobalRequest{

    #[Type(["integer", "float"])]
    protected $hoursWorked;

    #[Type(["integer","float"])]
    protected $totalWorkingHours;

    #[NotBlank(), Type("integer")]
    protected $userId;
    
}