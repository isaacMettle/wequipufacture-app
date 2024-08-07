<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email'=> 'required|email|string',
            'password'=> 'required|min:4'
        ];
    }

    public function messages(){
        return[
            'email.required'=>'l\'email est requis',
            'email.email'=>'Entrez un email valide. Exemple:example@gmail.com',
            'password.required'=>'Le mot de passes est requis',

        ];

    }
}