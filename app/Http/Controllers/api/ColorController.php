<?php

namespace App\Http\Controllers\api;

use App\Models\Color;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::with('users')->orderBy('id','desc')->paginate(5);

        return response()->json($colors);
    }

    /**
     * Store a newly created resource in storage.
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

            return  response()->json(["success"=>"Color registered successfully", 'color'=>$color]);
        } catch (\Exception $e) {
            return  response()->json(["error"=> $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $color = Color::with('users')->findOrFail($id);
                return  response()->json(['color'=>$color]);
            }
            catch (\Exception $e) {
                return  response()->json(["error"=> $e->getMessage()]);
        }
    }

    /**
     * Update the specified resource in storage.
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
            return  response()->json(["success"=>"Color successfully changed"]);
        } catch (\Exception $e) {
            return  response()->json(["error"=> $e->getMessage()]);
        }



    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $user = Color::findOrFail($id)->delete();

            return  response()->json(["success"=>"Color successfully deleted",]);
           }catch (\Exception $e) {
                return  response()->json(["error"=> $e->getMessage()]);
           }
    }
}
