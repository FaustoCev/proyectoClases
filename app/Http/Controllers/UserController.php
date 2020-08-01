<?php

namespace App\Http\Controllers;

use App\Company;
use App\User;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{

    public function layout(){

        if( !Auth::user()->isAdmin() ){
            return response()->json(['data'=>'Acceso no autorizado']);
        }

        return view('users');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( !Auth::user()->isAdmin() ){
            return response()->json(['data'=>'Acceso no autorizado']);
        }

        $users = User::with(['roles:id'])->get();
        return response()->json(['data'=>$users]);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validation = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:10',
            'password' => 'required|confirmed|min:8',
            'roles' => 'required|array|min:1'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $company = Company::find(1);
        $user->company()->associate($company);
        $user->save();

        $user->roles()->sync($request->roles);

        return ['status'=>'registro agregado exitosamente'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $validation = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone' => 'required|string|max:10',
            'password' => 'nullable|confirmed|min:8',
            'roles' => 'required|array|min:1'
        ]);

        $user = User::findOrFail($id);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if(!empty($request->password)){
            $user->password = bcrypt($request->password);
        }

        $company = Company::find(1);
        $user->company()->dissociate($company);
        $user->company()->associate($company);

        $user->save();

        $user->roles()->sync($request->roles);

        return ['status'=>'registro editado exitosamente'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        $user->roles()->sync([]);

        $user->delete();

        return ['status'=>'registro eliminado exitosamente'];
    }
}
