<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
   /**
     * Get list Users
     * @OA\Get (
     *     path="/api/users",
     *     tags={"Users"},
     *     security={{ "sanctum":{} }},
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 type="array",
     *                 property="rows",
     *                 @OA\Items(
     *                     type="object",
     *
     *                 )
     *             )
     *         )
     *     )
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $users = User::with('colors')->orderBy('id','desc')->paginate(10);

        return response()->json($users);
    }

   /**
     * Create new User
     * @OA\Post (
     *     path="/api/user",
     *     tags={"Users"},
     *     security={{ "sanctum":{} }},
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
     *                  "name":"Nome do Usuario",
     *                  "email":"email",
     *                  "password":"senha",
     *                  "passwordConfirmation":"confirme a senha",
     *                  "token_name":"nome do token"
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
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserStoreRequest $request)
    {

        try{
            $user = User::firstOrCreate([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password)
            ]);

            return  response()->json(["success"=>"User registered successfully", 'user'=>$user]);
        } catch (\Exception $e) {
            return  response()->json(["error"=> $e->getMessage()]);
        }

    }

      /**
     * Get Detail User
     * @OA\Get (
     *     path="/api/user/{id}",
     *     tags={"Users"},
     *     security={{ "sanctum":{} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *              @OA\Property(property="id", type="number", example=1),
     *              @OA\Property(property="name", type="string", example="name"),
     *              @OA\Property(property="email", type="string", example="email"),
     *              @OA\Property(property="active", type="string", example="active"),     *
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="colors", type="string", example="colors[]")
     *         )
     *     )
     * )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



        try{
        $user = User::with('colors')->find($id);
            return  response()->json(['user'=>$user]);
        }
        catch (\Exception $e) {
            return  response()->json(["error"=> $e->getMessage()]);
        }
    }

 /**
     * Update User
     * @OA\Put (
     *     path="/api/user/{id}",
     *     tags={"Users"},
     *     security={{ "sanctum":{} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
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
     *                       @OA\Property(
     *                          property="passwordConfirmation",
     *                          type="string"
     *                      ),
     *
     *
     *                 ),
     *                 example={
     *                     "name":"example title",
     *                     "email":"example content",
     *                     "password":"example content",
     *                     "passwordConfirmation":"example content"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="success",
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="id", type="string", example="id"),
     *              @OA\Property(property="name", type="string", example="name"),
     *              @OA\Property(property="email", type="string", example="email"),
     *              @OA\Property(property="password", type="string", example="password"),
     *              @OA\Property(property="passwordConfirmation", type="string", example="passwordConfirmation"),
     *              @OA\Property(property="updated_at", type="string", example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string", example="2021-12-11T09:25:53.000000Z")
     *          )
     *      )
     * )
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::find($id);

           if(!$request->password){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);

            $userUpdate = User::findOrFail($id)->update([
                'name'=>$request->name,
                'email'=>$request->email,
            ]);


           }elseif($request->email == $user->email){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required|min:6|same:passwordConfirmation'
            ]);
                $userUpdate = User::findOrFail($id)->update([
                    'name'=>$request->name,
                    'password'=>  Hash::make($request->password)
                ]);

            }else{
                $request->validate([
                    'name' => 'required',
                    'email' => 'required|unique:users|email',
                    'password' => 'required|min:6|same:passwordConfirmation'
                ]);

                $userUpdate = User::findOrFail($id)->update([
                    'name'=>$request->name,
                    'email'=>$request->email,
                    'password'=>  Hash::make($request->password)
                ]);

            }

            return  response()->json(["success"=>"User successfully changed"]);

        }catch (\Exception $e) {

            return  response()->json(["error"=> $e->getMessage()]);

        }



    }

     /**
     * Delete User
     * @OA\Delete (
     *     path="/api/user/{id}",
     *     tags={"Users"},
     *     security={{ "sanctum":{} }},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="success",
     *         @OA\JsonContent(
     *             @OA\Property(property="msg", type="string", example="delete user success")
     *         )
     *     )
     * )
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       try{
        $user = User::findOrFail($id)->delete();

        return  response()->json(["success"=>"User successfully deleted",]);
       }catch (\Exception $e) {
            return  response()->json(["error"=> $e->getMessage()]);
       }
    }
}
