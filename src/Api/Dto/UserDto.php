<?php

namespace App\Api\Dto;

use Symfony\Component\Validator\Constraints as Assert;

class UserDto
{
    public function __construct(
        public readonly string $username,
        #[Assert\Email]
        public readonly string $email,
        public readonly string $password,
    )
    {
    }
}