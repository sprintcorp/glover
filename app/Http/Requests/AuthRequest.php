<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Route;

class AuthRequest extends FormRequest
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
        if (Route::current()->getName() == 'register') {
            return [
                'firstname' => 'required|string',
                'lastname' => 'required|string',
                'email' => 'required|string|email|max:100|unique:users,email,NULL,id,deleted_at,NULL',
                'password' => 'required|string|min:8',
            ];
        }

        return [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ];
    }
}
