<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
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
            "name"=> "required|string|max:255",
            "email"=> "required|email",
            "password"=> "required",
            "age"=>  "required|integer",
            "phone"=> "required",
            "gender"=> "required|boolean",
            "blood_type"=> "required",
            "location"=> "required",
            //"date_and_time"=> "required",

        ];
    }
}
