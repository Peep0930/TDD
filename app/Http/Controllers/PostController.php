<?php

namespace App\Http\Controllers;

use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    public function create(PostRequest $request){
        $post = Post::Create($request->all());
        return redirect($post->path());
    }

    public function Update(Post $post,PostRequest $request){
        $post->update($request->all());
        return redirect($post->path());
    }

    public function Destory(Post $post){
        $post->delete();
        return redirect('/Posts');
    }
}
