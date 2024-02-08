<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
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

            return response("Cadastro concluido com sucesso", 200);
        } catch (\Exception $error) {
            Log::error('erro', [$error]);
            return response("Erro ao concluir o cadastro", 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        // TODO
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        // TODO
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy()
    {
        // TODO
    }
}
