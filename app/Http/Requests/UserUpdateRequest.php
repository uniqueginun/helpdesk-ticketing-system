<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($this->get('edited_user_id'))
            ],
            'password' => [
                'nullable',
                Rule::requiredIf((bool) $this->get('update_password')),
                'confirmed',
                Password::defaults()
            ],
            'user_role' => [
                'required',
                'string',
                Rule::in(array_keys(User::$userTypes))
            ]
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'الإسم',
            'email' => 'البريد الإلكتروني',
            'password' => 'كلمة المرور',
            'user_role' => 'نوع المستخدم',
        ];
    }
}
