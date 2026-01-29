<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\GetProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function profile(GetProfileRequest $request): JsonResponse
    {
        $user = $request->user()->load('vendor');

        return $this->successResponse([
            'user' => UserResource::make($user),
        ], 'Profile retrieved successfully');
    }
}
