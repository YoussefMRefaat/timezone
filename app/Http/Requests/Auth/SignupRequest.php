<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class SignupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required' , 'string' , 'max:15'],
            'last_name' => ['required' , 'string' , 'max:15'],
            'email' => ['required' , 'email' , 'unique:users'],
            'password' => ['required' , Password::min(6)->letters()->numbers() , 'confirmed'],
            'gender' => ['required' , Rule::in(['male' , 'female'])],
            'primary_phone' => ['required' , 'string' , 'max:20'],
            'sec_phone' => ['nullable' , 'string' , 'max:20'],
            'primary_address' => ['required' , 'string' , 'max:100'],
            'sec_address' => ['nullable' , 'string' , 'max:100'],
        ];
    }
}
