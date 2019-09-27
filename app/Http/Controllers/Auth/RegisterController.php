<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterFormRequest;
use App\User;
use Illuminate\Support\Facades\Hash;
use JWTAuth;

class RegisterController extends Controller
{
    
    /**
     * Register
     * 
     * @param RegisterFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function register(RegisterFormRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(compact('token', 'user'));

    }
}
