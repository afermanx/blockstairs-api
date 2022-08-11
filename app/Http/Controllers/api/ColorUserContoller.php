<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ColorUserContoller extends Controller
{
  /**
     * Bind Color User
     * @OA\Post (
     *     path="/api/bind_color/{user_id}",
     *     tags={"Bind and Unbind"},
     *     description="you can bind a color array with one or more colors in object.",
     *     security={{ "sanctum":{} }},
     *   @OA\Parameter(
     *         in="path",
     *         name="user_id",
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
     *                          property="color_id",
     *                          type="int"
     *                      ),
     *
     *
     *                 ),
     *                 example={
     *                  "colors":"[{color_id:int}]",
     *
     *
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Color binded successfully",
     *
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
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     *
     * @return \Illuminate\Http\Response
     */
    public function bind(Request $request, $user_id)
    {
        try{

            $userColor = DB::table('color_user')->where('user_id', $user_id)
            ->whereIn('color_id', $request->colors)->first();

            if($userColor){
                return  response()->json(["error"=>"color is already linked to that user"]);
            }

            $colors = collect($request->colors);
            $user = User::findOrFail($user_id);

            $user->colors()->syncWithoutDetaching($colors->unique());

            return  response()->json(["success"=>"Color binded successfully"]);


        }catch (\Exception $e) {
            return  response()->json(["error"=> $e->getMessage()]);
        }


    }
     /**
     * Bind Color User
     * @OA\post (
     *     path="/api/unbind_color/{user_id}",
     *     tags={"Bind and Unbind"},
     *     description="you can bind a color array with one or more colors in object.",
     *     security={{ "sanctum":{} }},
     *   @OA\Parameter(
     *         in="path",
     *         name="user_id",
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
     *                          property="color_id",
     *                          type="int"
     *                      ),
     *
     *
     *                 ),
     *                 example={
     *                  "colors":"[{color_id:int}]",
     *
     *
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Color binded successfully",
     *
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="invalid",
     *          @OA\JsonContent(
     *              @OA\Property(property="msg", type="string", example="fail"),
     *          )
     *      )
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     *
     * @return \Illuminate\Http\Response
     */
    public function unbind(Request $request, $user_id)
    {
        try{

            $user = User::findOrFail($user_id);

            $user->colors()->detach($request->colors);

            return  response()->json(["success"=>"Color unbind successfully"]);


        }catch (\Exception $e) {
            return  response()->json(["error"=> $e->getMessage()]);
        }
    }
}
