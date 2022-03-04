<?php

namespace App\Http\Requests;

use App\Models\Insurer;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;

class PostSignUpRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
    #[ArrayShape(['email' => "string[]", 'company_name' => "string[]", 'first_name' => "string[]", 'last_name' => "string[]"])]
    public function rules(): array
    {
        return [
            'email' => [ 'required', 'email', 'unique:'. app(User::class)->getTable() . ',email'],
            'company_name' => [ 'required', 'max:255', 'unique:' . app(Insurer::class)->getTable() . ',company_name' ],

            'first_name' => [ 'required', 'max:255' ],
            'last_name' => [ 'required', 'max:255' ],
        ];
    }
}
