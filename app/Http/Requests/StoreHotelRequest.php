<?php

namespace App\Http\Requests;

use App\Models\HotelBooking;
use Illuminate\Foundation\Http\FormRequest;

class StoreHotelRequest extends FormRequest
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
            'address' => ['required', 'string', 'max:500'],
            'link_gmaps' => ['required', 'string', 'max:500'],
            'thumbnail' => ['required', 'image', 'mimes:png,jpg,jpeg','max:5120'], //maksimal 5MB
            'photo.*' => ['required', 'image', 'mimes:png,jpg,jpeg','max:10240'], //maksimal 10MB
            'country_id' => ['required', 'integer'],
            'city_id' => ['required', 'integer'],
            'star_rating' => ['required', 'integer', 'between:1,5'],
            
        ];
    }
}
