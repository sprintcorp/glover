<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
        if($this->isMethod('PUT')){
            return [
                'firstname' => 'nullable|string',
                'lastname' => 'nullable|string',
                'email' => 'nullable|string|email|max:100|unique:users,email,'.request()->id.',id,deleted_at,NULL',
            ];
        }
        return [
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|string|email|max:100|unique:users,email,NULL,id,deleted_at,NULL',
        ];
    }
}
