<?php

namespace App\Api\Dto;

use App\Entity\Store;

class ProductDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $storeKey,
        public readonly string $searchTerm,
        public readonly float $maxPrice,
    )
    {
    }
}