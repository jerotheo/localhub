<?php

namespace Tests\Unit\Services;

use App\Services\Auth\AuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_creates_vendor_when_role_is_vendor(): void
    {
        $service = $this->app->make(AuthService::class);

        $result = $service->register([
            'name' => 'Vendor User',
            'email' => 'vendor@localhub.test',
            'password' => 'password123',
            'role' => 'vendor',
            'store_name' => 'Local Shop',
        ]);

        $this->assertNotEmpty($result['token']);
        $this->assertDatabaseHas('users', ['email' => 'vendor@localhub.test']);
        $this->assertDatabaseHas('vendors', ['store_name' => 'Local Shop']);
    }

    public function test_login_returns_token(): void
    {
        $service = $this->app->make(AuthService::class);

        $service->register([
            'name' => 'Buyer User',
            'email' => 'buyer@localhub.test',
            'password' => 'password123',
            'role' => 'buyer',
        ]);

        $result = $service->login([
            'email' => 'buyer@localhub.test',
            'password' => 'password123',
        ]);

        $this->assertNotEmpty($result['token']);
    }
}
