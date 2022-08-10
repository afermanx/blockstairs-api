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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


        $users = User::with('colors')->paginate(10);

        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        try{
        $user = User::with('colors')->findOrFail($id);
            return  response()->json(['user'=>$user]);
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
                    'password'=>  $request->password
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
                    'password'=>  $request->password
                ]);

            }

            return  response()->json(["success"=>"User successfully changed"]);

        }catch (\Exception $e) {

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
        $user = User::findOrFail($id)->delete();

        return  response()->json(["success"=>"User successfully deleted",]);
       }catch (\Exception $e) {
            return  response()->json(["error"=> $e->getMessage()]);
       }
    }
}
