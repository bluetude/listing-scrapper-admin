<?php

namespace App\Service;

use App\Entity\Store;
use App\Repository\StoreRepository;
use Exception;

class StoreService
{
    public function __construct(
        private readonly StoreRepository $storeRepository,
    )
    {
    }

    public function findStoreByKey(string $key): Store
    {
        $store = $this->storeRepository->findOneBy(['key' => $key]);

        if (!$store instanceof Store) {
            throw new Exception('Store not found');
        }

        return $store;
    }
}