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

    public function setPrivateFor($User){
        $this->Privates()->Create([
            'user_id' => $User->id,
            'start_time' => now()
        ]);
    }

    public function CancelPrivate($User){
        $Private = $this->Privates()->where('user_id',$User->id)->whereNull('end_time')->first();
        if(is_null($Private)){
            throw new \Exception();
        }

        $Private->update([
            'end_time' => now(),
        ]);
    }

    public function Privates(){
        return $this->hasMany(PrivateList::class);
    }
}
