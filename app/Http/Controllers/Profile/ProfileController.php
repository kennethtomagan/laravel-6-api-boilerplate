<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Profile\UpdateProfileRequest;
use App\Http\Resources\User as UserResource;

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
        
        $user = Auth::user();

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
        
        $user = Auth::user();

        $user->update($request->only('name', 'email'));

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
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'password' => 'required|confirmed|min:8',
        ]);

        $user = $request->user();

        $user->update([
            'password' => bcrypt($request->password),
        ]);

        $data = new UserResource($user);

        return response()->json(compact('data'));
    }
}
