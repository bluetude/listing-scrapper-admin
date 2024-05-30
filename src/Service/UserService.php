<?php

namespace App\Service;

use App\Api\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $userRepository,
    )
    {
    }

    public function registerUser(UserDto $dto): void
    {
        $user = new User();
        $user->setUsername($dto->username);
        $user->setEmail($dto->email);
        $user->setPassword(
            $this->passwordHasher->hashPassword($user, $dto->password)
        );

        $this->userRepository->add($user);

        $verificationUrl = $this->generateVerificationLink($user->getId(), $user->getEmail());
        
    }

    private function generateVerificationLink(int $id, string $email): string
    {
        $key = $_ENV['APP_SECRET'];
        $method = "aes-256-cbc";
        $encryptedId = openssl_encrypt($id, $method, $key);
        dd($encryptedId);
    }
}