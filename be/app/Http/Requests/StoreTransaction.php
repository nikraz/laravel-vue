<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransaction extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string|min:4|exists:App\User,name",
            "type" => "required|string|min:2|exists:App\TransactionTypes,type",
            "amount" => "required",
        ];
    }
}
