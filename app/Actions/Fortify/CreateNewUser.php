<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $input['email'] = mb_strtolower(trim($input['email'] ?? ''));
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', function ($attribute, $value, $fail): void {
                if (User::query()->whereRaw('LOWER(TRIM(email)) = ?', [mb_strtolower(trim((string) $value))])->exists()) {
                    $fail('An account already exists for this email address.');
                }
            }],
            'phone' => ['nullable', 'string', 'regex:/^[0-9+()\-\s]{8,24}$/'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone' => isset($input['phone']) ? trim($input['phone']) : null,
            'password' => Hash::make($input['password']),
        ]);
    }
}
