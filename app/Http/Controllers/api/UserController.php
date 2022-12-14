<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;

class UserController extends Controller
{

    use ApiResponser;
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

        return $this->success([
            'users' =>$users,
        ]);
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
     *                  "name":"Username",
     *                  "email":"emailuser@blockstairs.com",
     *                  "password":"123456",
     *                  "passwordConfirmation":"123456",
     *                  "token_name":"Name Token"
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


            return $this->success([
                'users' =>$user,
            ], 'User registered successfully');

        } catch (\Exception $e) {

            return $this->error($e->getMessage(),400);
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

        return $this->success([
            'users' =>$user,
        ]);

        }
        catch (\Exception $e) {
             return $this->error($e->getMessage(),400);
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

            return $this->success([
                'users' =>$user,
            ],'User successfully changed');

            return  response()->json(["success"=>""]);

        }catch (\Exception $e) {

             return $this->error($e->getMessage(),400);

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

        return $this->success('User successfully deleted', 200);

       }catch (\Exception $e) {
             return $this->error($e->getMessage(),400);
       }
    }
}
