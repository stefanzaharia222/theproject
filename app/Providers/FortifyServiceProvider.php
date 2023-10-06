<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Helpers\Helpers;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Contracts\LoginResponse;
use Laravel\Fortify\Fortify;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->instance(LoginResponse::class, new class implements LoginResponse {
            public function toResponse($request)
            {
                $routeDefined = (Auth::user()->hasRole('super-admin')) ? route('super-admin') : route('client-admin');

                return redirect($routeDefined);
            }
        });

        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(5)->by($email.$request->ip());
        });

        Fortify::loginView(function () {
            $configData = Helpers::appClasses();
            $customizerHidden = 'customizer-hide';
            $pageConfigs = ['myLayout' => 'blank'];
            return view('auth.login', compact('configData', 'customizerHidden', 'pageConfigs'));
        });

        Fortify::authenticateUsing(function (Request $request) {
            $user = User::where('email', $request->email)->first();

            if ($user &&
                Hash::check($request->password, $user->password)) {
                return $user;
            }
        });

        Fortify::registerView(function () {
            return redirect()->back();
        });

        Fortify::requestPasswordResetLinkView(function () {
            $configData = Helpers::appClasses();
            $customizerHidden = 'customizer-hide';
            $pageConfigs = ['myLayout' => 'blank'];
            return view('auth.forgot-password', compact('configData', 'customizerHidden', 'pageConfigs'));
        });

        Fortify::resetPasswordView(function ($request) {
            $configData = Helpers::appClasses();
            $customizerHidden = 'customizer-hide';
            $pageConfigs = ['myLayout' => 'blank'];
            return view('auth.reset-password', compact('configData', 'customizerHidden', 'pageConfigs', 'request'));
        });

        Fortify::verifyEmailView(function () {
            return view('auth.verify-email');
        });
    }
}
