<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class SummaryDateAndUserRequest extends GlobalRequest{

    #[NotBlank(), Type("integer"), Length(10)]
    protected $creationDate;

    #[NotBlank(), Type("integer")]
    protected $userId;
    
}