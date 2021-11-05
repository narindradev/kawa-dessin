<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PriceProjectRequest extends FormRequest
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
            'devis' => 'required|numeric|min:100',
        ];
    }
    public function messages()
    {
        return [
            'devis.required' => trans("lang.price_value"),
        ];
    }
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            die(json_encode(["success" => false, "validation" => true,  "message" => $validator->errors()->first()]));
        }
    }
}
