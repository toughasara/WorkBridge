<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OffreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'nombre_poste' => 'required|integer|min:1',
            'type_contrat' => 'required|string',
            'mode_travail' => 'required|string',
            'description' => 'required|string',
            'date_expiration' => 'nullable|date',
            'salaire' => 'required|integer',
            'experience' => 'required|integer',
            'location' => 'required|string',
            'statut' => 'required|string',
            'skill_ids' => 'required|array',
            'skill_ids.*' => 'exists:skills,id',
            'language_ids' => 'nullable|array',
            'language_ids.*' => 'exists:languages,id',
            'language_levels' => 'nullable|array',
            'language_levels.*' => 'string',
        ];
    }
}
