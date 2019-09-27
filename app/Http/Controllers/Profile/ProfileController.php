<?php

namespace App\Http\Controllers\Profile;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Profile\UpdateProfileRequest;

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

        return response()->json(compact('user'));
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

        return response()->json(compact('user'));
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

        return response()->json(compact('user'));
    }
}
