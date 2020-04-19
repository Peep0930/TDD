<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PrivateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Post $Post)
    {
        $Post->setPrivateFor(auth()->user());
    }


}
