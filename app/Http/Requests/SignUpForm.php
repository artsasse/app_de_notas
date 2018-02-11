<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignUpForm extends FormRequest
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
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo [nome] é obrigatório.',
            'email.email' => 'É preciso registrar um email válido.',
            'email.required' => 'O campo [email] é obrigatório.',
            'email.unique:users' => 'Já existe uma conta com esse email.',
            'password.required'  => 'O campo [senha] é obrigatório.',
        ];
    }
}
