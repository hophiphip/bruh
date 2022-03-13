<?php

namespace App\Http\Requests;

use App\Models\Offer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;


class PostNewOfferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    #[Pure] #[ArrayShape(['cases' => "string", 'description' => "string"])]
    public function rules(): array
    {
        return [
            'cases'       => 'required|in:' . Offer::allCases(),
            'description' => 'required',
        ];
    }
}
