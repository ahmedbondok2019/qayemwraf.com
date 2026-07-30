<?php

namespace App\Http\Requests\ApiV1\User;

use App\Http\Requests\ApiV1\BaseApiV1Request;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends BaseApiV1Request
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
        $userId = $this->user() ? $this->user()->id : null;

        return [
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'phone' => [
                'sometimes',
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($userId),
            ],
            'country_id' => 'sometimes|required|exists:countries,id',
            'password' => 'nullable|string|min:8|confirmed',
        ];
    }
}
