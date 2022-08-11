<?php

namespace App\Http\Controllers\api;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ColorController extends Controller
{
/**
     * Get list Colors
     * @OA\Get (
     *     path="/api/colors",
     *     tags={"Colors"},
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
        $colors = Color::with('users')->orderBy('id','desc')->paginate(5);

        return $this->success([
            'users' =>$colors,
        ]);
    }

    /**
     * Create new Color
     * @OA\Post (
     *     path="/api/color",
     *     tags={"Colors"},
     *     security={{ "sanctum":{} }},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                      type="object",
     *                      @OA\Property(
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="hex",
     *                          type="string"
     *                      ),
     *
     *                 ),
     *                 example={
     *                  "description":"Branco",
     *                  "hex":"#ffff"
     *
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Color registered successfully",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="string", example="color id"),
     *              @OA\Property(property="description", type="string", example="description color"),
     *              @OA\Property(property="hex", type="string", example="#fffff"),
     *              @OA\Property(property="rgb", type="string", example="rgb(255 255 0 0)"),
     *              @OA\Property(property="updated_at", type="string",  example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string",  example="2021-12-11T09:25:53.000000Z"),
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        try{

            $request->validate([
                'description'=>'required|unique:colors',
                'hex'=>'required|unique:colors',
            ]);
            $color = Color::firstOrCreate([
                'description'=>$request->description,
                'hex'=>$request->hex,
                'rgb'=>hex2Rgb($request->hex)

            ]);
            return $this->success([
                'users' =>$color,
            ],"Color registered successfully");

        } catch (\Exception $e) {
           return $this->error($e->getMessage(),400);
        }
    }

     /**
     * Get Detail Color
     * @OA\Get (
     *     path="/api/color/{id}",
     *     tags={"Colors"},
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
     *              @OA\Property(property="id", type="string", example="color id"),
     *              @OA\Property(property="description", type="string", example="description color"),
     *              @OA\Property(property="hex", type="string", example="#fffff"),
     *              @OA\Property(property="rgb", type="string", example="rgb(255 255 0 0)"),
     *              @OA\Property(property="updated_at", type="string",  example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string",  example="2021-12-11T09:25:53.000000Z"),
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
            $color = Color::with('users')->findOrFail($id);

            return $this->success([
                'users' =>$color,
            ]);

            }
            catch (\Exception $e) {
               return $this->error($e->getMessage(),400);
        }
    }

   /**
     * Update Color
     * @OA\Put (
     *     path="/api/color/{id}",
     *     tags={"Colors"},
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
     *                          property="description",
     *                          type="string"
     *                      ),
     *                      @OA\Property(
     *                          property="hex",
     *                          type="string"
     *                      ),
     *                 ),
     *                 example={
     *                     "description":"example description",
     *                     "hex":"example #ffff"
     *                }
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Color successfully changed",
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="id", type="string", example="color id"),
     *              @OA\Property(property="description", type="string", example="description color"),
     *              @OA\Property(property="hex", type="string", example="#fffff"),
     *              @OA\Property(property="rgb", type="string", example="rgb(255 255 0 0)"),
     *              @OA\Property(property="updated_at", type="string",  example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="created_at", type="string",  example="2021-12-11T09:25:53.000000Z"),
     *              @OA\Property(property="users", type="string", example="users[]")
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
        $color = Color::findOrFail($id);

        try{

            if($request->description == $color->description && $request->hex == $color->hex){
                $request->validate([
                    'description'=>'required|unique:colors',
                    'hex'=>'required|unique:colors',
                ]);
            }else{
                $request->validate([
                    'description'=>'required',
                    'hex'=>'required',
                ]);

                $colorUpdate = Color::findOrFail($id)->update([
                    'description'=>$request->description,
                    'hex'=>$request->hex,
                    'rgb'=>hex2Rgb($request->hex)

                ]);
            }

            return $this->success([
                'users' =>$color,
            ],"Color successfully changed");

        } catch (\Exception $e) {
           return $this->error($e->getMessage(),400);
        }



    }

         /**
     * Delete Color
     * @OA\Delete (
     *     path="/api/color/{id}",
     *     tags={"Colors"},
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
     *             @OA\Property(property="msg", type="string", example="Color successfully deleted")
     *         )
     *     )
     * )
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = Color::findOrFail($id)->delete();

            return $this->success("Color successfully deleted". 200);



           }catch (\Exception $e) {
               return $this->error($e->getMessage(),400);
           }
    }
}
