<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
                 // Check Create or Update
        if ($this->method() == 'PATCH') 
        {
            // $name_rules = 'required|string|size:6|unique:books,label,' .$this->id; 
        }
        else 
        {
        }
        return [
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:customers|digits:8',
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
            'name.required' => 'Le nom est requis!',
            'phone.required' => 'Numero du téléphone est invalide!'
        ];
    }

    /**
     *  Filters to be applied to the input.
     *
     * @return array
     */
    public function filters()
    {
        return [
            'name' => 'trim|capitalize|escape'
        ];
    }
}
