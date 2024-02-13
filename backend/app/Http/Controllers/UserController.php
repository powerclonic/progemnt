<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            User::create($request->validated());

            return response(__('messages.user.created'), 200);
        } catch (\Exception $error) {
            return response(__('messages.user.create_failed'), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        if ($request->has('password') && !Hash::check($request->current_password, $request->user()->password)) return response(__('messages.user.password_failed'), 401);

        try {
            $request->user()->update($request->validated());

            return response(__('messages.user.updated'), 200);
        } catch (\Exception $error) {
            return response(__('messages.user.update_failed'), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $request->user()->delete();

            return response(__('messages.user.deleted'), 200);
        } catch (\Exception $error) {
            return response(__('messages.user.delete_failed'), 500);
        }
    }
}
