<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => ['required', 'string'],
            'description' => 'nullable|string',
            'critical_level' => 'required|integer',
            'price' => 'required|numeric',
            'cost_price' => 'required|numeric',
            'reward_points' => 'required',
            'quantity' => 'integer',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,svg|max:10014',
        ];
    }
}
