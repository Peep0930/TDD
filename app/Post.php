<?php

namespace App;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $guarded = [];

    public function path(){
        return '/Posts/'.$this->id;
    }

    public function setUserIdAttribute($User){
        $this->attributes['user_id'] = User::firstOrCreate([
            'account' => $User,
            'password' => bcrypt('123456'),
            'name' => $User
        ])->id;
    }
}
