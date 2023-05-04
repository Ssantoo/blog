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
            'userId' => 'required|string',
            'password' => 'required|string',
        ]);
    
        try {
            if (!$token = JWTAuth::attempt($credentials)){
                return response()->json(['error' => '접근할 수 없습니다.'], 401);
            }
        }  catch (JWTException $e) {
            return response()->json(['error' => '토큰 생성 불가.'], 500);
        }
    
        //사용자 이름을 토큰에 추가
        $user = JWTAuth::user(); //현재 사용자 인스턴스 가져오기
        
        return response()->json([
            'token' => $token,
            'username' => $user->username,
            'userId' => $user->id
        ]);
    }

    public function register(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'userId' => 'required|string|unique:users,userId',
                'username' => 'required|string|unique:users,username',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|confirmed',
            ]);
    
            $user = new User([
                'userId' => $request->userId,
                'username' => $request->username,
                'email' => $request->email,
                'password' => bcrypt($request->password),
            ]);
    
            $user->save();
    
            return response()->json([
                'message' => '회원가입 성공',
                'user' => $user
            ], 201);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('유효성 오류:', ['exception' =>$e]);
            return response()->json([
                'message' => '회원가입 실패',
               // 'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('일반적오류:', ['exception' => $e]);
            return response()->json([
                'message' => '회원가입 실패',
                //'error' => $e->getMessage()
            ], 400);
        }
    }


}
