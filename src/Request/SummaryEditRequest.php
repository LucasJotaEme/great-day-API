<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class SummaryEditRequest extends GlobalRequest{

    #[NotBlank(), Type("integer"), Length(10)]
    protected $creationDate;

    #[NotBlank(), Type(["integer", "float"])]
    protected $hoursWorked;

    #[NotBlank(), Type(["integer","float"])]
    protected $totalWorkingHours;

    #[NotBlank(), Type("integer")]
    protected $userId;
    
}