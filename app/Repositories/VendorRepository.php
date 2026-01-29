<?php

namespace App\Repositories;

use App\Models\Vendor;
use App\Repositories\Interfaces\VendorRepositoryInterface;

class VendorRepository implements VendorRepositoryInterface
{
    public function create(array $data): Vendor
    {
        return Vendor::create($data);
    }

    public function findByUserId(string $userId): ?Vendor
    {
        return Vendor::where('user_id', $userId)->first();
    }
}
