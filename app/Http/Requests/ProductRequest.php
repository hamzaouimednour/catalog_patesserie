<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            $ref_rule = 'required|max:100|unique:products,ref,' .$this->get('id');
        }
        else 
        {
            $ref_rule = 'required|unique:products|string|max:100';
        }

        return [
            'name' => 'required|string|max:255',
            'ref' => $ref_rule,
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
            'name.required' => 'Le nom du produit est requis!',
            'ref.required' => 'Le reférence est requis!',
            'ref.unique' => 'Le reférence est déja existe!'
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
