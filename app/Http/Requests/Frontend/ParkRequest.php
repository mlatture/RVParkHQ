<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ParkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'park_id' => 'required|exists:parks,id',
            'rating' => 'required|integer|min:1|max:5',
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                // Rule::unique('pending_reviews')->where(function ($query) {
                //     return $query->where('park_id', $this->park_id)
                //         ->where('email', $this->email);
                // }),
            ],
            'message' => 'required|string|min:10',
        ];
    }
}
