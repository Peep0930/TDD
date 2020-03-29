<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class UserRequest extends FormRequest{

    public function authorize()
    {
        return true;
    }
    
    public function rules(){
        return [
            'name' => 'string|required',
            'account' => 'string|required|unique:users',
            'password' => 'string|required|max:15|min:6',
            'Is_Admin' => 'sometimes|boolean',
        ];
    }

}



?>