<?php

namespace App\Request;

use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

class UserIdRequest extends GlobalRequest{

    #[NotBlank(), Type("integer")]
    protected $userId;
    
}