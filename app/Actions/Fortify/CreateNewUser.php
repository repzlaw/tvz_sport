<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\Recaptcha;
use Illuminate\Support\Str;
use App\Models\Configuration;
use App\Models\UserProfilePic;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
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
            'country' => ['required'],
            'password' => $this->passwordRules(),
        ])->validate();

        $captcha_enable= Configuration::where('key','captcha_enable')->first();
        $captcha_register= Configuration::where('key','captcha_register')->first();
        if ($captcha_enable) {
            $captcha_enable = $captcha_enable->value;
            if ($captcha_enable) {
                if ($captcha_register) {
                    $captcha_register = $captcha_register->value;
                    if ($captcha_register) {
                        Validator::make($input, [
                            'g-recaptcha-response' => [
                                'required',
                                 new Recaptcha()
                            ],
                        ])->validate();
                    }
                }
            }
        }
        
        $uuid= ((string) Str::uuid());

        $user =  User::create([
            'username' => $input['username'],
            'uuid'=> $uuid,
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $file_path = $input['country'].'.'.'png';

        $pics = UserProfilePic::create([
                'user_id'=>$user->id,
                'alt_name'=>$user->username,
                'file_path'=>$file_path,
        ]);

        return $user;

    }
}
