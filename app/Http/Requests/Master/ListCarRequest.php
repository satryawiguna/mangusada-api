<?php

namespace App\Http\Requests\Master;

use App\Http\Requests\Common\ListRequest;

class ListCarRequest extends ListRequest
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
        return array_merge([
            'start_date' => ['date', 'nullable'],
            'end_date' => ['date', 'nullable']
        ], parent::rules());
    }

    public function prepareForValidation()
    {
        $this->merge(array_merge(
            $this->withOrderSort(),
            [
                'start_date' => $this->get('start_date', null),
                'end_date' => $this->get('end_date', null)
            ]
        ));
    }
}
