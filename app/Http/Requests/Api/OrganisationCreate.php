<?php

namespace App\Http\Requests\Api;

use App\Models\Organisation;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class OrganisationCreate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('store', Organisation::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */

    public function validationData()
    {
        return $this->json ? $this->json()->all() : $this->all();
    }

    public function rules()
    {
        $rules = Organisation::CREATE_RULES;

        if($this->user()->can('alterAllFields', Organisation::class)) {
            $rules = array_merge($rules, Organisation::GRANTED_RULES);
        }

        return $rules;
    }
}
