<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;



class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'userId' => 'required|stirng',
            'password' => 'required|string',
        ]);

        try{
            if( !$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => '접근할 수 없습니다.'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => '토큰 생성 불가'], 500);
        }
        
    }

}
