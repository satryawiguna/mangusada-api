<?php
namespace App\Http\Requests\Common;

class ListBySearchRequest extends ListRequest
{
    protected function withSearch()
    {
        return array_merge(
            $this->withOrderSort(),
            ['search' => $this->get('search', null)]
        );
    }

    public function rules()
    {
        return array_merge([
            'search' => ['string', 'nullable']
        ], parent::rules());
    }

    public function prepareForValidation()
    {
        $this->merge($this->withSearch());
    }
}
