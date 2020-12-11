<?php

namespace App\Http\Requests\Api;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UserUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->user);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    protected function prepareForValidation()
    {
    }

    public function validationData()
    {
        return $this->json ? $this->json()->all() : $this->all();
    }

    public function rules()
    {
        $rules = User::UPDATE_RULES;

        if($this->user()->can('alterAllFields', User::class)) {
            $rules = array_merge($rules, User::GRANTED_RULES);
        }

        return $rules;
    }
}
