<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_registers_buyer(): void
    {
        $payload = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'password' => 'password123',
        ];

        $response = $this->postJson('/api/v1/auth/register', $payload);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.email', 'jane@example.com')
            ->assertJsonPath('data.user.role', 'buyer')
            ->assertJsonStructure(['data' => ['token']]);

        $this->assertDatabaseHas('users', [
            'email' => 'jane@example.com',
            'role' => 'buyer',
        ]);
    }

    public function test_registers_vendor_and_creates_vendor_record(): void
    {
        $payload = [
            'name' => 'Vendor User',
            'email' => 'vendor@example.com',
            'password' => 'password123',
            'role' => 'vendor',
            'store_name' => 'Vendor Store',
            'description' => 'Quality products',
        ];

        $response = $this->postJson('/api/v1/auth/register', $payload);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.user.role', 'vendor');

        $this->assertDatabaseHas('vendors', [
            'store_name' => 'Vendor Store',
            'status' => 'pending',
        ]);
    }
}
