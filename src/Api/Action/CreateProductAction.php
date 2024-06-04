<?php

namespace App\Api\Action;

use App\Api\Dto\ProductDto;
use App\Service\ProductService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class CreateProductAction
{
    public function __construct(
        private readonly ProductService $productService,
        private readonly NormalizerInterface $normalizer,
    )
    {
    }

    #[Route(path: '/products', name: 'api_products_create', methods: ['POST'])]
    public function __invoke(
        #[MapRequestPayload] ProductDto $dto,
    ): Response
    {
        try {
            $product = $this->productService->createNewProduct($dto);
        } catch (\Exception $exception) {
            return new JsonResponse([$exception->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $jsonData = $this->normalizer->normalize($product, null, ['groups' => ['product']]);

        return new JsonResponse($jsonData, Response::HTTP_CREATED);
    }
}