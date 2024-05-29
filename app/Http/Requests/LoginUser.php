<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginUser extends FormRequest
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
            'email'=> ['required', 'string', 'email', 'exists:users,email'], 
            'password'=> ['required', 'string'],
        ];
    }

    public function failedValidation(Validator $validator)  
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'statut_code' => 422,
            'error' => true,
            'message' => 'Erreur de validation',
            'errorsList' => $validator->errors()
        ], 422));
    }

    public function messages(){
        return [
            'email.required'=>'Email non founi',
            'email.email'=>'Adresse email non valide',
            'email.exists'=>'Cette adresse email n\'existe pas',

            'password.required'=>'Mot de passe non fourni',
        ];
    } 
}
