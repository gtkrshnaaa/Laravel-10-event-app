<?php

namespace App\Http\Requests;

use App\Enums\CategoryEnum;
use App\Enums\StatusEnum;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:posts|max:255',
            'description' => 'required|max:1500',
            'category' => [new Enum(CategoryEnum::class)],
            'user_id' => 'required',
            'status' => [new Enum(StatusEnum::class)],
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
            'address' => 'required|string|max:255', // Address validation
            'date' => 'required|date', // Date validation
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A title is required',
            'description.required' => 'A description is required',
            'image.image' => 'The file must be an image',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif',
            'image.max' => 'The image may not be greater than 2048 kilobytes',
            'address.required' => 'The address field is required',
            'address.string' => 'The address must be a string',
            'address.max' => 'The address may not be greater than 255 characters',
            'date.required' => 'The date field is required',
            'date.date' => 'The date must be a valid date',
        ];
    }
}
