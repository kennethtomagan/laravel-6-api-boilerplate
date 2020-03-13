<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Hashing\BcryptHasher;
use App\Http\Resources\User as UserResource;

class AuthController extends Controller
{
    /**
     * Login
     * 
     * @param LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(LoginRequest $request)
    {
        // Get User by email
        $user = User::where('email', $request->email)->first();

        // Return error message if user not found.
        if(!$user) return response()->json(['error' => 'User not found.'], 404);

        // Account verification validation
        if(config('url.account_verify')){
            if(!$user->email_verified_at) return response()->json(['error' => 'Account must be verified'], 401);
        }
        // Account Validation
        if (!(new BcryptHasher)->check($request->input('password'), $user->password)) {
            // Return Error message if password is incorrect
            return response()->json(['error' => 'Email or password is incorrect. Authentication failed.'], 401);
        }

        // Get email and password from Request
        $credentials = $request->only('email', 'password');

        try {
            // Login Attempt
            if (! $token = auth()->attempt($credentials)) {
                // Return error message if validation failed
                return response()->json(['error' => 'invalid_credentials'], 401);

            }
        } catch (JWTException $e) {
            // Return Error message if cannot create token. 
            return response()->json(['error' => 'could_not_create_token'], 500);

        }
        
        // transform user data
        $data = new UserResource($user);

        return response()->json(compact('token', 'data'));
    }
}
