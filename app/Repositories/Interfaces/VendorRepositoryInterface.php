<?php

namespace App\Repositories\Interfaces;

use App\Models\Vendor;

interface VendorRepositoryInterface
{
    public function create(array $data): Vendor;

    public function findByUserId(string $userId): ?Vendor;
}
