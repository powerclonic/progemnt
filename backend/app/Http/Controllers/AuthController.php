<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuthRequest $request)
    {

        try {
            /** @var User $user */
            $user = User::where('username', $request->identifier)->orWhere('email', $request->identifier)->first();

            if (!$user || !Hash::check($request->password, $user->password)) return response(__('messages.auth.failed'), 401);
        } catch (\Exception $error) {
            return response(__('messages.auth.login_failed'), 500);
        }

        return response()->json([
            'access_token' => $user->createToken('auth_token_' . now()->toISOString())->plainTextToken,
            'name' => $user->name
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $request->user()->currentAccessToken()->delete();

            return response(__('messages.auth.logout'), 200);
        } catch (\Exception $error) {
            return response(__('messages.auth.logout_failed'), 500);
        }
    }
}
