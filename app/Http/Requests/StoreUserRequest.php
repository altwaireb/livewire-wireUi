<?php

namespace App\Http\Requests;

use App\Actions\Fortify\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
{
    use PasswordValidationRules;

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
            'username' => [
                'required',
                'string',
                'lowercase',
                'min:5',
                'max:25',
                'regex:/^([a-z])+?([a-z0-9])+?(_)?([a-z0-9])+$/i',
                'unique:users'
            ],
            'name' => [
                'required',
                'string',
                'min:5',
                'max:50'
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users'
            ],
            'password' => $this->passwordRules(),
            // device_name Just to Create Token
            'device_name' => 'required'
        ];
    }
}
