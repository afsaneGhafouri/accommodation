<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AccommodationCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->user()->type === User::USER_TYPE_OWNER;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'type' => 'required|in:house,room,hustle,apartment',
            'room_count' => 'required',
            'bed_count' => 'required',
            'price' => 'required',
            'address' => 'required'
        ];
    }
}
