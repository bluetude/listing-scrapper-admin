<?php

namespace App\Api\Action;

use App\Api\Dto\ProductDto;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

class CreateProductAction
{
    public function __construct()
    {
    }

    public function __invoke(#[MapRequestPayload] ProductDto $dto): Response
    {

    }
}