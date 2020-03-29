<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function Create(UserRequest $reuqest){
        User::Create([
            'name' => $reuqest->name,
            'account' => $reuqest->account,
            'password' => bcrypt($reuqest->password),
            'Is_Admin' => $reuqest->Is_Admin,
        ]);
    }
}
