<?php

namespace App\Http\Controllers\backsite;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

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
            'error'=> 'Invalite Credensial',Response::HTTP_UNAUTHORIZED
        ]);
    }
    
}
