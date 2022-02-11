<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(schema="JoueurRequest")
 * {
 *   @OA\Property(
 *     property="nom",
 *     type="string",
 *     description="joueur nom"
 *   ),
 *   @OA\Property(
 *     property="photo",
 *     type="string",
 *     description="The station title"
 *   ),
 * }
 *  @OA\Property(
 *     property="partie",
 *     type="integer",
 *     description="The station title"
 *   ),
 * }
 */
class JoueurRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
            "nom" => "required|max:50",
            "photo" => "mimes:jpg,bmp,png,jpeg",
            "partie" => "integer"
        ];
    }
}
