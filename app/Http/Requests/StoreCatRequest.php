<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCatRequest extends FormRequest
{
    protected $min = 20; // euro 
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
        $rules["name"] ='required|max:255';
        if (request("estimate")) {
            $rules["estimate"] = "required|numeric|min:$this->min";
        }
        return $rules;

    }
    public function messages()
    {
        return [
            'name.required' => sprintf(__("A %s is required.") , __("name")) ,
            'estimate.min' => "La valeur du devis estimatif doit être supérieur à " . format_to_currency($this->min),
        ];
    }
    public function withValidator($validator)
    {
        if ($validator->fails()) {
            die(json_encode(["success" => false, "validation" => true,  "message" => $validator->errors()->first()]));
        }
    }
}
