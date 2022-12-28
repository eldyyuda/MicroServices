<?php

namespace App\Http\Controllers\backsite;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function Login(Request $request)
    {
        if(Auth::attempt($request->only('email','password')))
        {
            $user= Auth::user();
            $token = $user->createToken('admin')->accessToken;
            return [
                'token'=>$token
                ];
        }
        return response([
            'error'=> 'Invalided Credential',Response::HTTP_UNAUTHORIZED
        ]);
    }
    public function Register(RegisterRequest $request)
    {
        $user=User::Create(
            $request->only('first_name','last_name','email','role_id')+
            ['password'=>Hash::make($request->input('password'))]
        );
        return response($user,Response::HTTP_CREATED);
    }
}
