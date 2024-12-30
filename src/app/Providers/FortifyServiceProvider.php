<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;
use Laravel\Fortify\Fortify;
use App\Http\Requests\CustomLoginRequest;

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
        Fortify::createUsersUsing(CreateNewUser::class);

        Fortify::registerView(function () {
            return view('auth.register');
        });

        Fortify::loginView(function () {
            return view('auth.login');
        });

        RateLimiter::for('login', function (Request $request) {
            $email = (string) $request->email;

            return Limit::perMinute(10)->by($email . $request->ip());
        });


        // 会員登録ページにリダイレクト
        $this->app->singleton(\Laravel\Fortify\Contracts\RegisterResponse::class, function ($app) {
            return new class implements \Laravel\Fortify\Contracts\RegisterResponse {
                public function toResponse($request)
                {
                    \Log::info('RegisterResponse triggered');
                    \Log::info('User authenticated: ' . (auth()->check() ? 'yes' : 'no'));
                    return redirect('/mypage/profile'); // 登録後にリダイレクトするページ
                }
            };
        });

        // LoginRequestをカスタムクラスに置き換える
        $this->app->bind(
            \Laravel\Fortify\Http\Requests\LoginRequest::class,
            CustomLoginRequest::class
        );
    }
}
