<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class SummarySearchRequest extends GlobalRequest{

    #[Type("integer"), Length(10)]
    protected $firstDate;

    #[Type("integer"), Length(10)]
    protected $secondDate;

    #[NotBlank(), Type("integer")]
    protected $userId;
    
}