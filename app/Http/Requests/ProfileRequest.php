<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
        if ($this->method() == 'POST')
        {
            $ref_rule = 'numeric|digits:8|unique:users,phone,' .$this->get('id');
            $username_rule = 'string|unique:users,username,' .$this->get('id');
            $password_rule = '';
            $password_confirmation_rule = '';
        }
        else
        {
            $ref_rule = 'required|numeric|unique:users|digits:8';
            $username_rule = 'required|string|unique:users';
            $password_rule = 'required|min:4|confirmed';
            $password_confirmation_rule = 'required|min:4';
        }

        return [
            'name' => 'required|string|max:255',
            'password' => $password_rule,
            'password_confirmation' => $password_confirmation_rule,
            'phone' => $ref_rule,
            'username' => $username_rule,
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
            'phone.required' => 'Le numéro de Tél est requis!',
            'phone.unique' => 'Le numéro de Tél est déja existe!',
            'username.required' => 'Le nom d\'utilisateur est requis!',
            'username.unique' => 'Le nom d\'utilisateur est déja existe!',
            'password.required' => 'Mot de passe est requis!',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas!'
        ];
    }
}
