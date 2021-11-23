<?php

namespace App\Http\Requests\Account;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
class SettingsEmailRequest extends FormRequest
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
            'current_password' => ['required', new MatchOldPassword],
            'email' => ['required', 'string', 'email', 'max:255',Rule::unique('users')->where(function ($query) {
                return $query->whereDeleted(0)->where("id" ,"<>" , (request("id") ?? auth()->id()));
            })],
        ];
    }
}
