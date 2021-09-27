<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePlayerRequest extends FormRequest
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
            'sport_type_id' => 'required',
            'full_name' => 'required|unique:players,full_name|max:255',
            'team_id' => 'required',
            'name' => 'required',
            'status' => 'required',
            'active_since' => 'required',
            'featured_image' => 'file|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
}
