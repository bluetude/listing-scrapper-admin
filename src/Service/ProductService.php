<?php

namespace App\Service;

use App\Api\Dto\ProductDto;
use App\Entity\Product;
use App\Repository\ProductRepository;

class ProductService
{
    public function __construct(
        private readonly ProductRepository $productRepository,
        private readonly StoreService $storeService,
    )
    {
    }

    public function createNewProduct(ProductDto $dto): Product
    {
        $product = new Product();

        $product->setName($dto->name);
        $product->setStore(
            $this->storeService->findStoreByKey($dto->storeKey)
        );
        $product->setSearchTerm($dto->searchTerm);
        $product->setMaxPrice($dto->maxPrice);

        $this->productRepository->add($product);

        return $product;
    }
}