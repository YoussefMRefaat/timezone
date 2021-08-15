<?php

namespace App\Http\Requests\Watches;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => ['required' , 'string' , 'max:20'],
            'description' => ['required' , 'string' , 'max:255'],
            'price' => ['required' , 'numeric' , 'max:99999.99' , 'min:1'],
            'quantity' => ['required' , 'integer'],
        ];
    }
}
