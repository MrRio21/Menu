<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'string', 'min:4'],
        'en_name' => ['required', 'string', 'min:4'],
        'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'details' => ['required', 'string'],
        'en_details' => ['required', 'string'],
        'price' => 'required',
        'is_active' => ['required'],
        'position' => ['required', 'string'],
        ];
    }
}
