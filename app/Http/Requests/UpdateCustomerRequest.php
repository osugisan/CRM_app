<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCustomerRequest extends FormRequest
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
            'name' => ['required', 'max:50'],
            'kana' => ['required', 'regex:/^[ ア-ン゛゜ァ-ォャ-ョー]+$/u', 'max:50'],
            'tel' => ['required', 'max:20', Rule::unique('customers')->ignore($this->customer)],
            'email' => ['required', 'email', 'max:255', Rule::unique('customers')->ignore($this->customer)],
            'postcode' => ['required', 'max:7'],
            'address' => ['required', 'max:100'],
            'birthday' => ['date'],
            'gender' => ['required'],
            'memo' => ['max:1000'],
        ];
    }
}
