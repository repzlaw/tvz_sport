<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
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
            'team_name' => 'required|unique:teams,team_name|max:255',
            'summary' => 'required',
            'featured_image' => 'file|image|mimes:jpeg,png,jpg,svg|max:2048',
        ];
    }
}
