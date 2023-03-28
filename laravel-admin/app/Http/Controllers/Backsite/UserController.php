<?php

namespace App\Http\Controllers\Backsite;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backsite\StoreUserRequest;
use App\Http\Requests\Backsite\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function index()
    {
       $user=User::paginate();
       return UserResource::collection($user);
    }
    public function show($id)
    {
        $user = User::find($id);
        return new UserResource($user);
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
        return response(new UserResource($user),Response::HTTP_CREATED);
    }
    public function update(User $id, UpdateUserRequest $request)
    {
        $id->update([
            'first_name'=>$request->input('first_name'),
            'last_name'=>$request->input('last_name'),
            'email'=>$request->input('email'),
            'password'=>Hash::make($request->input('password'))
        ]);

        // $id->update(
        //     $request->only('first_name','last_name','email')
        //     +['password'=>Hash::make($request->input('password'))]);
        return response(new UserResource($id),Response::HTTP_ACCEPTED);
    }
    public function destroy(User $id)
    {
        $id->delete();
        return response(new UserResource($id),Response::HTTP_NO_CONTENT);
    }
    public function user()
    {
        
        return new UserResource(Auth::user());
    }
    public function userInfo(Request $request)
    {
        $user = Auth::user();
        $user->update($request->only('first_name','last_name','email'));
        return response(new UserResource($user),Response::HTTP_ACCEPTED); 
    }
    public function userPassword(Request $request)
    {
        $user= Auth::user();
        $user->update([
            'password'=>Hash::make($request->input('password'))
        ]);
        return response(new UserResource($user),Response::HTTP_ACCEPTED);
    }
}
