<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Requests\CreatePostRequest;

class PostController extends Controller
{
    public function create(CreatePostRequest $request){
        Post::Create([
            'title' => $request->title,
            'date' => $request->date,
            'content' => $request->content,
            'url' => $request->url,
            'Is_Public' => $request->Is_Public,
        ]);
    }

    public function Update(Post $post,CreatePostRequest $request){
        $post->update([
            'title' => $request->title,
            'date' => $request->date,
            'content' => $request->content,
            'url' => $request->url,
            'Is_Public' => $request->Is_Public,
        ]);
    }
}
