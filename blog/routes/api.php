<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\AuthController;

Route::post('register', []);

//회원가입
Route::post('register', [AuthController::class, 'register']);
//로그인
Route::post('login', [AuthController::class, 'login']);
//토큰
Route::get('refresh', [AuthController::class, 'refreshToken']);


Route::middleware(['jwt.verify'])->group(function () {
    // 로그아웃
    Route::get('logout', [AuthController::class, 'logout']);
    
    // 게시물 CRUD
    //글쓰기
    Route::post('post', [AuthController::class, 'store']);
    //글내용보기
    Route::get('post/{id}', [AuthController::class, 'show']);
    //글수정
    Route::patch('post/{id}', [AuthController::class, 'update']);
    //글삭제
    Route::delete('post/{id}', [AuthController::class, 'destroy']);

    // 특정 사용자 게시물 목록 조회 및 페이징
    Route::get('board/{userId}', [AuthController::class, 'listByUser']);
});