<?php

namespace App\Http\Requests;

use App\Models\HotelBooking;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRoomRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'photo' => ['nullable', 'image', 'mimes:png, jpg, jpeg','max:10240'], //pake sometimes karena tidak wajib diupdate, maksimal 10MB
            'total_people' => ['required', 'integer'],
            'price' => ['required', 'integer'],
        ];
    }
}
