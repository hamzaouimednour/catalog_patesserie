<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyUserRequest extends FormRequest
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
            $email_rule = 'required|email|max:255|unique:company_users,email,' .$this->get('id'); 
            $phone_rule = 'required|numeric|digits:8|unique:company_users,phone,' .$this->get('id');
            $pwd_rule = 'sometimes|nullable|string|max:255|min:6';
        }
        else 
        {
            $email_rule = 'required|email|unique:company_users|max:255';
            $phone_rule = 'required|numeric|unique:company_users|digits:8';
            $pwd_rule = 'required|string|max:255|min:6';
        }

        return [
            'company_section_id' => 'required',
            'name' => 'required|string|max:255',
            'phone' => $phone_rule,
            'email' => $email_rule,
            'password' => $pwd_rule
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
            'company_section_id.required' => 'La section est requis!',
            'name.required' => 'Le nom est requis!',
            'email.required' => 'Email est requis!',
            'phone.required' => 'Numero du télephone est requis!',
            'phone.numeric' => 'Numero du télephone est numérique!',
            'phone.digits' => 'Numero du télephone est de 8 chiffres!',
            'password.required' => 'Mot de passe est requis!',
            'password.min' => 'Mot de passe doit être au moins 6 caractères.!'
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
            'email' => 'trim|lowercase',
            'name' => 'trim|capitalize|escape'
        ];
    }
}
