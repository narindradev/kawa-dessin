<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartProjectRequest extends FormRequest
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
            'dates' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'dates.required' => trans("lang.start_value"),
        ];
    }
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            die(json_encode(["success" => false, "validation" => true,  "message" => $validator->errors()->first()]));
        }
    }
}
