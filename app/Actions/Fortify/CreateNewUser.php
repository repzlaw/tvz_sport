<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'username' => ['required', 'string', 'max:255',
                            Rule::unique(User::class),
                        ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'g-recaptcha-response' => [
                'required',
                 new Recaptcha()
            ],

            'password' => $this->passwordRules(),
        ])->validate();
        
        $uuid= ((string) Str::uuid());

        return User::create([
            'username' => $input['username'],
            'uuid'=> $uuid,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
