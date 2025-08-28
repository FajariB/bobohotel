<?php

namespace App\Http\Requests;

use App\Models\HotelBooking;
use Illuminate\Foundation\Http\FormRequest;

class StoreSearchHotelRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'keyword' => ['nullable', 'string', 'max:255'],
            'checkin_at' => ['nullable', 'date'],
            'checkout_at' => ['nullable', 'date', 'after:today'],
        ];  
    }
}
