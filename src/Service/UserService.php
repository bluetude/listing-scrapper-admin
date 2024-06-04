<?php

namespace App\Service;

use App\Api\Dto\UserDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Exception;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Uid\Uuid;

class UserService
{
    public function __construct(
        private readonly UserPasswordHasherInterface $passwordHasher,
        private readonly UserRepository $userRepository,
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly RequestStack $requestStack,
        private readonly MailerService $mailerService,
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

        $verificationUrl = $this->generateVerificationLink($user->getUuid(), $user->getEmail());

        $this->mailerService->sendVerificationMail($user->getEmail(), $verificationUrl);
    }

    private function generateVerificationLink(Uuid $uuid, string $email): string
    {
        $url = $this->urlGenerator->generate(
            'api_verify_email',
            [
                'uuid'=> $uuid,
                'emailHash' => hash_hmac('sha256', $email, $_ENV['APP_SECRET'])
            ]
        );

        return $this->requestStack->getMainRequest()->getUriForPath($url);
    }

    /**
     * @throws Exception
     */
    public function verifyUserEmail(string $uuid, string $emailHash): void
    {
        $user = $this->userRepository->findOneBy(['uuid' => $uuid]);

        if (!$user instanceof User) {
            throw new Exception('Could not verify user.');
        }

        if ($emailHash === hash_hmac('sha256', $user->getEmail(), $_ENV['APP_SECRET'])) {
            $user->setVerified(true);
            $this->userRepository->add($user);

            return;
        }

        throw new Exception('Could not verify user.');
    }
}