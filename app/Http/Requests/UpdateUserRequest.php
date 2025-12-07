<?php

namespace App\Http\Requests;

use App\Rules\CameroonPhoneRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore($userId)],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', Rule::unique('users')->ignore($userId)],
            'phone' => ['nullable', new CameroonPhoneRule()],
            'store_id' => ['nullable', 'exists:stores,id'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'L\'adresse email doit être valide et respecter les normes RFC.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà pris.',
        ];
    }

    /**
     * Préparer les données avant validation
     */
    protected function prepareForValidation(): void
    {
        // Normaliser le numéro de téléphone
        if ($this->has('phone') && !empty($this->phone)) {
            $this->merge([
                'phone' => CameroonPhoneRule::normalize($this->phone)
            ]);
        }
    }
}
