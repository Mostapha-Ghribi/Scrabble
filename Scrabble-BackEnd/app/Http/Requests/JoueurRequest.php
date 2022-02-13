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
 *     type="text",
 *     description="Photo de joueur"
 *   ),
 *
 *  @OA\Property(
 *     property="partie",
 *     type="integer",
 *     description="La partie"
 *   ),
 *  @OA\Response(
 *          response=422,
 *          description="L'un des champs est invalide",
 *      ),
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
            "photo" => "string",
            "partie" => "integer"
        ];
    }
}
