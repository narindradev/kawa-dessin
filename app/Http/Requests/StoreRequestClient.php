<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequestClient extends FormRequest
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
        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users,email,'.request()->id.'|max:255|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
        ];
        if(request("client_type") == "corporate"){
            $rules["company_name"] = "required";
            $rules["company_head_office"] = "required";
            $rules["siret"] = "required";
            $rules["num_tva"] = "required";
        }
        if(request()->hasFile("files")){
            $rules["files"] =  'max:5000';
        }
        $rules["categorie"] = "required";
        return $rules ;
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            die(json_encode(["success" => false, "validation" => true,  "message" => $validator->errors()->first()]));
        }
    }
}
