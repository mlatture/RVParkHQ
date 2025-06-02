<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CampgroundRequest extends FormRequest
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
        $campgroundId = $this->route('campground') ?? null;

        $rules = [
            'name' => ['required', 'unique:over_pass,name'],
            'state' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'longitude' => 'required',
            'latitude' => 'required',
        ];

        if ($campgroundId) {
            $rules['name'] = [
                'required',
                Rule::unique('over_pass', 'name')->ignore($campgroundId),
            ];
        }

        return $rules;
    }
}
