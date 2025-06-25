<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
        $rules = [
            'title'         => 'required|string|max:255',
            'slug'          => 'required|string|max:255|unique:blogs,slug',
            'excerpt'       => 'nullable|string',
            'content'       => 'required|string',
            'thumbnail'     => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'status'        => 'required|in:draft,published',
            'published_at'  => 'nullable|date',
        ];

        if ($this->isMethod('PUT') || $this->isMethod('PATCH')) {
            $blogId = $this->route('blog')->id ?? null;
            $rules['slug'] = 'required|string|max:255|unique:blogs,slug,' . $blogId;
            $rules['thumbnail'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        } else {
            $rules['thumbnail'] = 'required|image|mimes:jpg,jpeg,png|max:2048';
        }

        return $rules;
    }
}
