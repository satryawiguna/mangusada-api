<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\Common\AuditableRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class CreateCarRequest extends AuditableRequest
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
        $rules = [
            'brand' => ['required'],
            'model' => ['required'],
            'year' => ['required', 'numeric', 'digits:4'],
            'license_plate' => ['required'],
            'rental_rate' => ['required', 'numeric']
        ];

        return $this->setRuleAuthor($rules);
    }

    public function prepareForValidation()
    {
        $this->setValueAuthor($this);
    }

    public function failedValidation(Validator $validator)
    {
        parent::failedValidation($validator);
    }
}
