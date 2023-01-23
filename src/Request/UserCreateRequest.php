<?php

namespace App\Request;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Password;

class UserCreateRequest extends GlobalRequest{

    #[NotBlank(), Email()]
    protected $email;

    #[NotBlank(), Type("string")]
    protected $userName;

    #[NotBlank(), Length(
        min: 5, minMessage: 'Password is too short',
        max: 15, maxMessage: 'Password is too long'
        )]
    protected $password;

    // #[Collection(
    //     fields: [
    //         'email' => new Email,
    //         'short_bio' => [
    //             new NotBlank,
    //             new Length(
    //                 max: 1,
    //                 maxMessage: 'Your short bio is too long!'
    //             )
    //         ]
    //     ],
    //     allowMissingFields: false,
    // )]
    // protected $user;
}