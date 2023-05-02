<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        $perPage = $request->input('per_page', 10); //기본적으로 페이지 당 10개씩 
        $posts = Post::with('user')->orderBy('id', 'desc')->paginate($perPage);

        $responseData = $posts->getCollection()->map(function ($post) {
            return [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'username' => $post->user ? $post->user->username : null,
                'created_at' => $post->created_at,
                'updated_at' => $post->updated_at,
            ];
        });

        return response()->json([
            'data' => $responseData,
            'current_page' => $posts->currentPage(),
            'last_page' => $posts->lastPage(),
        ]);
    }

    // 새로운 게시물을 저장하는 메서드
    public function store(Request $request)
    {
        // 입력 데이터 유효성 검사
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // 새로운 Post 객체 생성
        $post = new Post([
            'user_id' => auth()->user()->id, // 현재 로그인한 사용자의 ID
            'username' => auth()->user()->username, // 현재 로그인한 사용자의 이름
            'title' => $request->title, // 제목 입력
            'content' => $request->content,  // 내용 입력
        ]);

        // 게시물 저장 성공 시
        if ($post->save()) {
            return response()->json([
                'message' => '게시물 생성',
                'post' => $post
            ], 201); // HTTP 상태 코드 201 (생성됨)과 함께 JSON 형식으로 반환
        } else {
            return response()->json(['message' => '게시물 생성 실패'], 500); // HTTP 상태 코드 500 (내부 서버 오류)와 함께 반환
        }
    }

    // 특정 게시물을 가져오는 메서드
    public function show($postId)
    {
        $post = Post::find($postId); // 주어진 ID를 가진 게시물을 조회합니다.

        if ($post) {
            return response()->json($post);  // 게시물이 있으면 JSON 형식으로 반환
        } else {
            return response()->json(['message' => '게시물을 찾을 수 없습니다.'], 404); // HTTP 상태 코드 404 (찾을 수 없음)와 함께 반환
        }
        
    }

    // 게시물을 수정하는 메서드
    public function update(Request $request, Post $post)
    {
        // 입력 데이터 유효성 검사
        $request->validate([
            'title' => 'required|string',
            'content' => 'required|string',
        ]);

        // 로그확인
        \Log::info('글정보:' . json_encode($post));
        \Log::info('글쓴이:' . $post->user_id);
        \Log::info('접속자:' . auth()->user()->id);


        // 현재 로그인한 사용자가 게시물 작성자가 아닌 경우
        if ($post->user_id !== auth()->user()->id) {
            return response()->json(['message' => '게시물 수정 권한 없습니다.'], 403);
        }

        // 게시물 업데이트
        $post->update([
            'title' => $request->title,  // 수정된 제목 입력
            'content' => $request->content, // 수정된 내용 입력
        ]);

        return response()->json([
            'message' => '게시물 수정 완료',
            'post' => $post
        ]);
    }

     // 게시물을 삭제하는 메서드
    public function destroy(Post $post)
    {
        // 현재 로그인한 사용자가 게시물 작성자가 아닌 경우
        if($post->user_id !== auth()->user()->id){ 
            return response()->json(['message' => '게시물 삭제 실패'], 403); // HTTP 상태 코드 403 (금지됨)과 함께 반환
        }

        $post->delete(); // 게시물 삭제

        return response()->json([
            'message' => '게시물 삭제 완료',
        ]);
    }

     // 특정 사용자의 게시물 목록을 가져오는 메서드
    public function listByUser(Request $request, $userId)
    {
        $user = User::where('userId', $userId)->first(); // 주어진 ID를 가진 사용자를 조회합니다.

        if (!$user) {
            return response()->json(['message' => '해당 사용자를 찾을 수 없습니다.'], 404); // HTTP 상태 코드 404 (찾을 수 없음)와 함께 반환
        }

        $perPage = $request->input('perPage', 10); // 페이지 당 게시물 수를 설정합니다. 기본값은 10입니다.
        $posts = $user->posts()->paginate($perPage); // 사용자의 게시물을 페이징하여 가져옵니다.

        return response()->json($posts);
    }



}


