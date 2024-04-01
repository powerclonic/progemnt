<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\DashboardUserResource;
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

            return response(__('messages.created', ['resource' => 'usuário']), 200);
        } catch (\Exception $error) {
            return response(__('messages.create_failed', ['resource' => 'usuário']), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        return new UserResource($request->user());
    }

    public function dashboard(Request $request)
    {
        return new DashboardUserResource($request->user());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request)
    {
        if (
            $request->has('password') &&
            !Hash::check($request->current_password, $request->user()->password)
        ) return response(__('messages.password_failed'), 401);

        try {
            $request->user()->update($request->validated());

            return response(__('messages.updated', ['resource' => 'usuário']), 200);
        } catch (\Exception $error) {
            return response(__('messages.update_failed', ['resource' => 'usuário']), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $request->user()->delete();

            return response(__('messages.deleted', ['resource' => 'usuário']), 200);
        } catch (\Exception $error) {
            return response(__('messages.delete_failed', ['resource' => 'usuário']), 500);
        }
    }
}
