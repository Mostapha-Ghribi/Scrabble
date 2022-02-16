<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;






class StoreMessageRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            "parte"=>"required",
            "envoyeur"=>"required",
            "partie"=>"required"

        ];
    }
}
