<?php

namespace App\Http\Requests\Location;

use Illuminate\Foundation\Http\FormRequest;

class CreateLocationRequest extends FormRequest
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
            'users'       => 'required',
            'name'        => 'required',
            'address'     => 'required',
            'description' => 'required',
            'phone'       => 'required',
            'latitude'    => 'required',
            'longitude'   => 'required',
            'avatar'      => 'required',
            'types'       => 'required'
        ];
    }
}
