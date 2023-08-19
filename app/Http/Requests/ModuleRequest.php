<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
        // return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'module' => 'required|string|max:255',
        ];
    }

    
    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'module.required' => 'Le nom du module est requis!'
        ];
    }
}
