<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use JWTAuth;
use App\Http\Resources\User as UserResource;

class RegisterController extends Controller
{
    
    /**
     * Register
     * 
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        $data = new UserResource($user);

        return response()->json(compact('token', 'data'));

    }
}
