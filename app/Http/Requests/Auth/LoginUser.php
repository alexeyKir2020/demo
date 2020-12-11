<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginUser extends FormRequest
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
        return $this->only('username', 'password');
    }

    public function rules()
    {
        return [
            'username' => 'required|string|min:3|max:255|email',
            'password' => 'required|string|min:6|max:100',
        ];
    }
}
