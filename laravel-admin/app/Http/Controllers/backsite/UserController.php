<?php

namespace App\Http\Controllers\backsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\StoreUserRequest;
use App\Http\Requests\Backsite\UpdateUserRequest;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
       return User::paginate();
    }
    public function show(User $id)
    {
        return $id;
    }
    public function store(StoreUserRequest $request)
    {
        $input = [
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password'))
        ];
        $user= User::create($input);
        return response($user,Response::HTTP_CREATED);
    }
    public function update(User $id, UpdateUserRequest $request)
    {
        // $id->update([
        //     'first_name'=>$request->input('first_name'),
        //     'last_name'=>$request->input('last_name'),
        //     'email'=>$request->input('email'),
        //     'password'=>Hash::make($request->input('password'))
        // ]);
        $id->update(
            $request->only('first_name','last_name','email')
            +['password'=>Hash::make($request->input('password'))]);
        return response($id,Response::HTTP_ACCEPTED);
    }
    public function destroy(User $id)
    {
        $id->delete();
        $content="Success Deleted";
        return response($content,Response::HTTP_NO_CONTENT);
    }
    public function user()
    {
        return Auth::user();
    }
    public function userInfo(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only('first_name','last_name','email'));
        return response($user,Response::HTTP_ACCEPTED); 
    }
    public function userPassword(Request $request)
    {
        $user= Auth::user();
        $user->update([
            'password'=>Hash::make($request->input('password'))
        ]);
        return response($user,Response::HTTP_ACCEPTED);
    }
}
