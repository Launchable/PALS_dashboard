<?php

namespace App\Http\Requests\Drink;

use Illuminate\Foundation\Http\FormRequest;

class CreateDrinkRequest extends FormRequest
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
            'location_id' => 'required|exists:locations,id',
            'type_id'     => 'required|exists:drink_types,id',
            'title'       => 'required',
            'description' => 'required',
            'price'       => 'required|max:9|regex:/^\d*(\.\d{2})?$/',
            'timed_price' => 'max:9|regex:/^\d*(\.\d{2})?$/',
        ];
    }
}
