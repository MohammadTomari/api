<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;

class CommentController extends Controller
{
    public function getCommentsByPostId($post_id) : JsonResponse
    {
        $comments = Comment::find($post_id)
        ->orderBy('created_at', 'DESC')
        ->paginate(2);

        return $this->sendResponse($comments, 'Comments');
    }

    public function index() : JsonResponse
    {
        $comments = Comment::orderBy('created_at','DESC')
        ->paginate(10);

        return $this->sendResponse($comments, 'All Comments');
    }

    public function store(Request $request) : JsonResponse
    {
        $comment = Comment::create([
            'text' => $request->text,
            'user_id' => Auth::id(),
            'post_id' => $request->post_id,
            'reply_to' => $request->reply_to,
            'created_at' => date('Y-m-d H:i'),
            'updated_at' => date('Y-m-d H:i'),
        ]);

        return $this->sendResponse($comment, 'Commented successfully.');
    }
}
