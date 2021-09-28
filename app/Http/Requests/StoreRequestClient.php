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
            'email' => 'required|unique:users,email,'.request()->id.'|max:255|email',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            "accept" => 'required',
            "categorie" => 'required',

        ];
        if(request("client_type") == "corporate"){
            $rules["company_name"] = "required";
            $rules["company_head_office"] = "required";
            $rules["siret"] = "required";
            $rules["num_tva"] = "required";
            $rules["company_phone"] = "required";
        }
        if(request()->hasFile("files")){
            $rules["files"] =  'max:5000';
        }
        
        return $rules ;
    }

    public function messages()
    {
        return [
            'email.unique' => 'sdqsdqsdsdqsd',
        ];
    }

    public function withValidator($validator)
    {
        if ($validator->fails()) {
            die(json_encode(["success" => false, "validation" => true,  "message" => $validator->errors()->first()]));
        }
    }
}
