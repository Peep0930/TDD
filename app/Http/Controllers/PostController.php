<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;

class PostController extends Controller
{
    public function create(PostRequest $request){
        Post::Create($request->all());
    }

    public function Update(Post $post,PostRequest $request){
        $post->update($request->all());
    }
}
