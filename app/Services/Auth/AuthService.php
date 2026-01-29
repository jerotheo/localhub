<?php

namespace App\Services\Auth;

use App\Exceptions\UnauthorizedException;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Interfaces\VendorRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthService
{
    public function __construct(
        private readonly UserRepositoryInterface $users,
        private readonly VendorRepositoryInterface $vendors,
    ) {
    }

    /**
     * @return array{user: User, token: string}
     */
    public function register(array $data): array
    {
        $role = $data['role'] ?? 'buyer';

        $user = $this->users->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => $role,
            'is_active' => true,
        ]);

        if ($role === 'vendor') {
            $this->vendors->create([
                'user_id' => $user->id,
                'store_name' => $data['store_name'],
                'description' => $data['description'] ?? null,
                'is_approved' => false,
                'status' => 'pending',
            ]);
        }

        $token = $user->createToken($this->tokenName($user))->plainTextToken;

        return [
            'user' => $user->load('vendor'),
            'token' => $token,
        ];
    }

    /**
     * @return array{user: User, token: string}
     */
    public function login(array $data): array
    {
        $user = $this->users->findByEmail($data['email']);

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            throw new UnauthorizedException('Invalid credentials.');
        }

        if (! $user->is_active) {
            throw new UnauthorizedException('Account is inactive.');
        }

        $token = $user->createToken($this->tokenName($user))->plainTextToken;

        return [
            'user' => $user->load('vendor'),
            'token' => $token,
        ];
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()?->delete();
    }

    private function tokenName(User $user): string
    {
        return Str::slug($user->email).'-token';
    }
}
