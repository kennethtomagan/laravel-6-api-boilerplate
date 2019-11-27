<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Requests\Profile\UpdatePassword;
use App\Http\Resources\User as UserResource;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
     /**
     * Get Login User
     * 
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me(Request $request)
    {
        // Get data of Logged user
        $user = Auth::user();

        // transform user data
        $data = new UserResource($user);

        return response()->json(compact('data'));

    }


     /**
     * Update Profile
     * 
     * 
     * @param UpdateProfileRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateProfileRequest $request)
    {
        // Get data of Logged user
        $user = Auth::user();

        // Update User
        $user->update($request->only('name', 'email'));
        
        // transform user data
        $data = new UserResource($user);

        return response()->json(compact('data'));
        
    }

     /**
     * Update Profile
     * 
     * 
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function updatePassword(UpdatePassword $request)
    {
        // Get Request User
        $user = $request->user();

        // Validate user Password and Request password
        if (!Hash::check($request->current_password, $user->password)) {
            // Validation failed return an error messsage
            return response()->json(['error' => 'Invalid current password'], 422);

        }

        // Update User password
        $user->update([
            'password' =>  Hash::make($request->new_password),
        ]);

        // transform user data
        $data = new UserResource($user);

        return response()->json(compact('data'));
    }
}
