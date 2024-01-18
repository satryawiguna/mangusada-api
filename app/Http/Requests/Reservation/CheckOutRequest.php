<?php

namespace App\Http\Requests\Reservation;

use App\Http\Requests\Common\AuditableRequest;
use Illuminate\Contracts\Validation\Validator;

class CheckOutRequest extends AuditableRequest
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
            'user_id' => ['required'],
            'car_id' => ['required'],
            'checkout_start_date' => ['required'],
            'checkout_end_date' => ['required']
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
