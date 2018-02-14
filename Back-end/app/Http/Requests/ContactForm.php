<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactForm extends FormRequest
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
          'subject' => 'required', //assunto
          'message' => 'required', //o texto da mensagem
          'name' => 'nullable', //FRONT!!! nao enviem esse campo no request
          'email' => 'nullable' //FRONT!!! nao enviem esse campo no request
        ];
    }

}
