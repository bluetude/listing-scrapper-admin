<?php

namespace App\Api\Action;

use App\Api\Dto\UserDto;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class RegisterAction
{
    public function __construct(
        private readonly UserService $service,
    )
    {
    }

    #[Route(path: '/register', name: 'api_user_register', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] UserDto $dto
    ): Response
    {
        $this->service->registerUser($dto);
    }
}