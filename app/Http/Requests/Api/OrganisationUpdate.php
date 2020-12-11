<?php

namespace App\Http\Requests\Api;

use App\Models\Organisation;
use Illuminate\Foundation\Http\FormRequest;

class OrganisationUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->organisation);
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
        return $this->json()->all();
    }

    public function rules()
    {
        $rules = Organisation::UPDATE_RULES;

        if($this->user()->can('alterAllFields', Organisation::class)) {
            $rules = array_merge($rules, Organisation::GRANTED_RULES);
        }

        return $rules;
    }
}
