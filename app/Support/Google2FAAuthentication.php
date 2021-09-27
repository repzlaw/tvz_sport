<?php

namespace App\Support;

use Illuminate\Support\Facades\Auth;
use PragmaRX\Google2FALaravel\Exceptions\InvalidSecretKey;
use PragmaRX\Google2FALaravel\Support\Authenticator;

class Google2FAAuthentication extends Authenticator
{
    protected function canPassWithoutChecking()
    {
        $guard = activeGuard();
        $getUser =Auth::guard($guard)->user();
        if (!Auth::guard($guard)->user()->passwordSecurity) {
            return true;
        } 
        return !$getUser->passwordSecurity->google2fa_enable || !$this->isEnabled() || $this->noUserIsAuthenticated() || $this->twoFactorAuthStillValid();
    }

    protected function getGoogle2FASecretKey()
    {
        $guard = activeGuard();
        $secret = Auth::guard($guard)->user()->passwordSecurity->{$this->config('otp_secret_column')};

        if (is_null($secret) || empty($secret)) {
            throw new InvalidSecretKey('Secret key cannot be empty');

        }

        return $secret;
    }
}