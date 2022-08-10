<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{

     use ApiResponser;

    public function register(UserStoreRequest $request)
    {

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email
        ]);

        return $this->success([
            'user' =>$user,
            'token' => $user->createToken($request->token_name ?? 'Api Token')->plainTextToken
        ],'User registered successfully');
    }

   public function login(Request $request)
    {
        $attr = $request->validate([
            'email' => 'required|string|email|',
            'password' => 'required|string|min:6'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->error('Credentials not match', 401);
        }



        return $this->success([
            'user' =>auth()->user(),
            'token' => auth()->user()->createToken('Api Token')->plainTextToken
        ], "successfully logged");
    }

   public function logout(Request $request)
    {
        # instaciei class personalAccessToken para pegar o token do user logado para deletar somente o token usado para o login
        $personalAccessToken = new PersonalAccessToken();

        $token = $personalAccessToken->findToken(str_replace('Bearer ', '', $request->header('authorization')));

        $token->delete();

        return [
            'message' => 'Tokens Revoked'
        ];
    }
}
