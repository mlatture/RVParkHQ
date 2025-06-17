<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AmenityRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'category' => 'required|string|in:Water & Recreation,Sports & Games,Convenience & Comfort,Experiences & Events,Kid & Family Friendly,Other Features',
        ];

        if ($this->isMethod('post')) {
            $rules['amenity'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('amenities')->where(function ($query) {
                    return $query->where('category', $this->input('category'));
                }),
            ];
            $rules['blackicon'] = 'required|image|mimes:jpeg,png,jpg,svg|max:2048';
            $rules['whiteicon'] = 'required|image|mimes:jpeg,png,jpg,svg|max:2048';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $amenityId = $this->route('amenity')?->id ?? 'NULL';

            $rules['amenity'] = [
                'required',
                'string',
                'max:255',
                Rule::unique('amenities')->ignore($amenityId)->where(function ($query) {
                    return $query->where('category', $this->input('category'));
                }),
            ];
            $rules['blackicon'] = 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048';
            $rules['whiteicon'] = 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048';
        }

        return $rules;
    }
}
