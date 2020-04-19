<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class CancelPrivateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Post $Post)
    {
        try{
            $Post->CancelPrivate(auth()->user());
        }
        catch(\Exception $e){
            return response([],404);
        }

    }
}
