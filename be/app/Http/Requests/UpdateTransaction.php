<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UpdateTransaction extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        if ($this->request->get('type') == 'name') {
            $rules['value'] = 'required|min:4';
        }
        if ($this->request->get('type') == 'balance') {
            $rules['value'] = 'required|min:1';
        }

        if ($this->request->get('type') == 'type') {
            $rules['value'] = 'required|exists:App\TransactionTypes,type';
        }

        if ($this->request->get('type') == 'amount') {
            $rules['value'] = 'required|min:1';
        }

        if (empty($rules)){
            throw new HttpResponseException(response()->json('Send type must be name/balance/type/amount)', 400));
        }
        return $rules;
    }
}
