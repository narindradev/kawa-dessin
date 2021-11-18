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
        $rules = [];
        if (request("dates")) {
            $rules['dates'] = "required";
            $dates = explode("-", request("dates"));
            $due_date = str_replace(' ', '', $dates[1]);
            if(request("delivery_date")){
                $rules['delivery_date'] = 'date_format:d/m/Y|after_or_equal:'.$due_date;
            }
        }
        return $rules;
    }
    public function messages()
    {
        return [
            'dates.required' => trans("lang.start_value"),
            'delivery_date.after' => trans("lang.delivery_value"),
        ];
    }
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            die(json_encode(["success" => false, "validation" => true,  "message" => $validator->errors()->first()]));
        }
    }
}
