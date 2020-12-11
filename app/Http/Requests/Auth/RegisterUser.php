<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUser extends FormRequest
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

    protected function prepareForValidation()
    {
    }

    public function rules()
    {
        return [
            'email' => 'required|string|min:3|max:255|email|unique:App\Models\User,email',
            'password' => 'required|string|min:6|max:100|confirmed',
        ];
    }
}
