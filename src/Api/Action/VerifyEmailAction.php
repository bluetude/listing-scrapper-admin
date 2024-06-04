<?php

namespace App\Api\Action;

use App\Service\UserService;
use Exception;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class VerifyEmailAction
{
    public function __construct(
        private readonly UserService $userService,
    )
    {
    }

    #[Route(path: '/verify', name: 'api_verify_email', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $uuid = $request->query->get('uuid');
        $emailHash = $request->query->get('emailHash');

        try {
            $this->userService->verifyUserEmail($uuid, $emailHash);
        } catch (Exception $e) {
            return new JsonResponse([$e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse(['Email verified.'], Response::HTTP_OK);
    }
}