<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProviderRequest extends FormRequest
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
            'eng_name' => ['required', 'string', 'min:4'],
            'image'=>'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'service_type' => ['required', 'string', 'min:4'],
            'phone' => ['required', 'string', 'min:8'],
            'whatsapp' => ['required', 'string', 'min:8'],
        ];
    }
}
