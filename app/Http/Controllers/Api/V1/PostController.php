<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Post;
use App\Models\Comment;

class PostController extends Controller
{
    public function index() : JsonResponse
    {
        $posts = Post::orderBy('created_at', 'DESC')->paginate(5);
        $comments = Comment::orderBy('created_at', 'DESC')->paginate(2);

        $result = [
            'posts' => $posts,
            'comments' => $comments,
        ];

        return $this->sendResponse($result, 'All posts with 2 newer comments');
    }

    public function store(Request $request) : JsonResponse
    {
        $input = $request->all();
        $input['user_id'] = Auth::id();

        $validator = Validator::make($input, [
            'title' => 'required',
            'text' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Error! ', $validator->errors());
        }

        $post = Post::create($input);

        return $this->sendResponse($post, 'Post created!');
    }

    public function update(Request $request) : JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'title' => 'required',
            'text' => 'required',
        ]);

        if($validator->fails())
        {
            return $this->sendError('Error! ', $validator->errors());
        }

        $post = Post::find($input['post_id']);

        $post->update([
            'title' => $input['title'],
            'text' => $input['text'],
        ]);

        $post->save();

        return $this->sendResponse($post, 'Post edited.');
    }

    public function delete(Request $request) : JsonResponse
    {
        $post = Post::find($request->post_id);
        $post->delete();

        return $this->sendResponse($post, 'Post deleted.');
    }

    public function userPosts() : JsonResponse
    {
        $post = Post::where('user_id', Auth::id())->get();

        return $this->sendResponse($post, 'All of user posts.');
    }
}
