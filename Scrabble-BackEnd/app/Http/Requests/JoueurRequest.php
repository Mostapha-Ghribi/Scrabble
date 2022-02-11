<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @OA\Schema(schema="JoueurRequest")
 * {
 *   @OA\Property(
 *     property="nom",
 *     type="string",
 *     description="nom de joueur"
 *   ),
 *   @OA\Property(
 *     property="photo",
 *     type="string",
 *     description="Photo de joueur"
 *   ),
 *
 *  @OA\Property(
 *     property="partie",
 *     type="integer",
 *     description="La partie"
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
