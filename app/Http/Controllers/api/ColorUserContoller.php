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
     * Bind the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $user_id
     *
     * @return \Illuminate\Http\Response
     */
    public function bind(Request $request, $user_id)
    {



        try{


            $colors = collect($request->colors);

            $userColor = DB::table('color_user')->where('user_id', $user_id)
            ->whereIn('color_id', $request->colors)->first();

            if($userColor){
                return  response()->json(["error"=>"color is already linked to that user"]);
            }


            $user = User::findOrFail($user_id);

            $user->colors()->syncWithoutDetaching($colors->unique());

        return  response()->json(["success"=>"Color binded successfully"]);


        }catch (\Exception $e) {
            return  response()->json(["error"=> $e->getMessage()]);
        }


    }
      /**
     * Unind the specified resource in storage.
     *
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
