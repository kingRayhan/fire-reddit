<?php

namespace App\Http\Requests\Auth;

use App\Rules\VerifyPreviousPassword;
use Illuminate\Foundation\Http\FormRequest;

class DestroyProfileRequest extends FormRequest
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
            'password' => ['required', new VerifyPreviousPassword]
        ];
    }

}
