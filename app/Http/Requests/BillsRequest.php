<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillsRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_name' => ['required', 'string', 'min:3'],
            'customer_address' => ['required', 'string', 'min:3'],
            'order_details' => ['required', 'string', 'min:4'],
            'bill_total' => ['required'],
            'customer_phone' => ['required', 'string'],
        ];
    }
}
