<?php

namespace App\Providers;

use Carbon\Carbon;
use App\Models\User;
use App\Rules\Recaptcha;
use App\Models\UserLoginLog;
use Illuminate\Http\Request;
use Laravel\Fortify\Fortify;
use App\Models\Configuration;
use App\Models\SecurityQuestion;
use Illuminate\Support\Facades\Hash;
use App\Actions\Fortify\CreateNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use Illuminate\Support\Facades\RateLimiter;
use Laravel\Fortify\Contracts\LogoutResponse;
use App\Actions\Fortify\UpdateUserProfileInformation;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app->instance(LogoutResponse::class, new class implements LogoutResponse {
        //     public function toResponse($request)
        //     {
        //         dd($request->id);
        //         return redirect('/');
        //     }
        // });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(5)->by($request->username.$request->ip());
        });

        RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });

        Fortify::loginView(function () {
            $captcha_enable= Configuration::where('key','captcha_enable')->first();
            $captcha_login= Configuration::where('key','captcha_login')->first();

            if ($captcha_enable) {
                $captcha_enable = $captcha_enable->value;
                if ($captcha_login) {
                    $captcha_login = $captcha_login->value;
                }
            }
            $captcha_site_key= Configuration::where('key','captcha_site_key')->first();
            return view('auth.login')->with(['captcha_site_key'=>$captcha_site_key,'captcha_enable'=>$captcha_enable,
                                                'captcha_login'=>$captcha_login]);
        });

        Fortify::registerView(function () {
            $securityQuestions = SecurityQuestion::all();
            $captcha_enable= Configuration::where('key','captcha_enable')->first();
            $captcha_register= Configuration::where('key','captcha_register')->first();

            if ($captcha_enable) {
                $captcha_enable = $captcha_enable->value;
                if ($captcha_register) {
                    $captcha_register = $captcha_register->value;
                }
            }
            $captcha_site_key= Configuration::where('key','captcha_site_key')->first();
            return view('auth.register')->with(['captcha_site_key'=>$captcha_site_key,'captcha_enable'=>$captcha_enable,
                                                'captcha_register'=>$captcha_register,'securityQuestions'=>$securityQuestions]);
        });

        Fortify::RequestPasswordResetLinkView(function () {
            return view('auth.passwords.forgot-password');
        });

        Fortify::ResetPasswordView(function ($request) {
            return view('auth.passwords.reset', ['request' => $request]);
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify');
        });

        Fortify::confirmPasswordView(function () {
            return view('auth.confirm-password');
        });

        //authentication
        Fortify::authenticateUsing(function (Request $request) {
            $captcha_enable= Configuration::where('key','captcha_enable')->first();
            $captcha_login= Configuration::where('key','captcha_login')->first();
            if ($captcha_enable) {
                $captcha_enable = $captcha_enable->value;
                if ($captcha_enable) {
                    if ($captcha_login) {
                        $captcha_login = $captcha_login->value;
                        if ($captcha_login) {
                            $request->validate([
                                'g-recaptcha-response' => [
                                    'required',
                                    new Recaptcha()
                                ],
                            ]);
                        }
                    }
                }
            }
            $user = User::where('username', $request->username)->first();
            $usermail = User::where('email', $request->username)->first();
            $user = $user ? $user : $usermail;
            
            if ($user && Hash::check($request->password, $user->password)) {
                    $user->update([
                        'last_login_at' => Carbon::now()->toDateTimeString(),
                        'last_login_ip' => $request->getClientIp()
                    ]);
                    //log information on logins table
                    $browser_info = getBrowser();
                    $session_id = session()->getId();
                    
                    $login_log = UserLoginLog::create([
                        'user_id' => $user->id,
                        'last_login_ip' => $request->getClientIp(),
                        'browser_info' => json_encode($browser_info),
                        'session_id' => $session_id,
                    ]);

                return $user;
            }
        });
    }
}
