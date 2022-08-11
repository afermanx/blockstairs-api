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


    /**
     * Register User
     * @OA\Post (
     *     path="/api/auth/register",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="name",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="email",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="password",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="passwordConfirmation",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="token_name",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                  "name":"Username",
     *                  "email":"emailuser@blockstairs.com",
     *                  "password":"123456",
     *                  "passwordConfirmation":"123456",
     *                  "token_name":"Name token"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="name", type="string", example="Joe Doe"),
     *              @OA\Property(property="email", type="string", example="joe@blocstairs.com"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *              @OA\Property(property="passwordConfirmation", type="string", example="123456"),
     *              @OA\Property(property="token_name", type="string", example="Fulano APi"),
     *
     *
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */
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

     /**
     * Login User
     * @OA\Post (
     *     path="/api/auth/login",
     *     tags={"Auth"},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *
     *                 ),
     *                 example={     *
     *                  "email":"emailuser@blockstairs.com",
     *                  "password":"123456",
     *
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="email", type="string", example="joe@blocstairs.com"),
     *              @OA\Property(property="password", type="string", example="123456"),
     *
     *
     *          )
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */
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

    /**
     * Logout User
     * @OA\Post (
     *     path="/api/auth/logout",
     *     tags={"Auth"},
     *     security={{ "sanctum":{}}},     *
     *     description="Logout with bearertoken",
     *      @OA\Response(
     *          response=200,
     *          description="success"     *
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     */
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
