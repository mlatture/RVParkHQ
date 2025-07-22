<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class eBillRequest extends FormRequest
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
            'send_from'    => 'required|in:WebDaVinci,RVParkHQ',
            'subject'      => 'required|string|max:255',
            'description'  => 'nullable|string',
            'schedule'     => 'required|in:one-time,monthly,yearly',
            'due_date'     => 'required|date|after_or_equal:today',
            'amount'       => 'required|numeric|min:0',
            'user_id'       => 'required',
        ];
    }
}