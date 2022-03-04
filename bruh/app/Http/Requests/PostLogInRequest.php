<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class PostLogInRequest extends FormRequest
{
    /**
     * User is authorized to make this request when not authenticated.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return !Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[ArrayShape(['email' => "string[]", 'captcha' => "string"])]
    public function rules(): array
    {
        return [
            'email' => [ 'required', 'email', 'exists:users,email'],

            /* TODO: Add fallback to reCaptcha / Move captcha to sign Up ? */
            'captcha' => 'required|captcha',
        ];
    }
}
