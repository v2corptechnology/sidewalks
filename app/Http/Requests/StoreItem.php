<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreItem extends FormRequest
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
        return [
            'title'         => 'required|between:3,255',
            'description'   => 'required',
            'amount'        => [
                'required',
                'min:1',
                'regex:#^\d+(.|,)?\d{0,2}$#isU',
            ],
            'symbol'        => 'required',
            'quantity'      => 'required|numeric|between:1,100',
            'categories'    => 'required|array|min:1',
            'images'        => 'required|array|min:1',
            'user_id'       => 'required|integer|exists:users,id',
            'shop_id'       => 'required|integer|exists:shops,id',
        ];
    }
}
