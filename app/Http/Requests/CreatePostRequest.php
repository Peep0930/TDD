<?php

namespace App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;


class CreatePostRequest extends FormRequest{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            'title' => 'required|string|unique:posts',
            'date' => 'required|date',
            'content' => 'nullable|string',
            'url' => 'nullable|string',
            'Is_Public' => 'required|boolean',
        ];
    }


}

?>
