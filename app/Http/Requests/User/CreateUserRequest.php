<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'first_name' => 'required|max:50',
            'last_name'  => 'required|max:50',
            'age'        => 'required',
            'gender'     => 'required',
            // Login Credentials Validation
            'role'       => 'required|in:administrator,manager,registered',
            'username'   => 'required|alpha_num|max:20|unique:users,username',
            'email'      => 'required|email|max:50|unique:users,email',
            'password'   => 'required|min:6|confirmed',
            'avatar'     => 'required'
        ];
    }
}
