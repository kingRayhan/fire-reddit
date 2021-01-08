<?php

namespace App\Http\Requests\Auth;

use App\Rules\LowerCase;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'username' => [
                'required', 'alpha_dash', 'min:3',
                Rule::unique('users')->ignore(auth()->id(), 'id'),
                new LowerCase
            ],
            'email' => ['email', Rule::unique('users')->ignore(auth()->id(), 'id')],
            'password' => 'min:6'
        ];
    }
}
