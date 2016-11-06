<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EditarVisitaRequest extends Request
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
            'visita' => 'required|in:1,2|min:1|max:1',
            'motivo' => 'required|min:1|max:2',
            'otro_motivo' => 'regex:/^[a-záéóóúàèìòùäëïöüñ\s]+$/i|min:3|max:25',
            'destino' => 'required|min:1|max:2',
        ];
    }
}
