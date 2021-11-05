<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChexkoutRequest extends FormRequest
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
        $rules = ["payment_method_name" => "required"];
        
        if (request("payment_method_name") == "stripe") {
            $rules["payment_method_id"] =  "required";
        }

        return $rules;
    }
    public function messages()
    {
        return [
            'payment_method_name.required' => trans("lang.choose_a_payment_method"),
            'payment_method_id.required' => trans("lang.error_action"),
        ];
    }
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            die(json_encode(["success" => false, "validation" => true,  "message" => $validator->errors()->first()]));
        }
    }
}
