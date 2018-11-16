<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;
use App\Session;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Auth::viaRequest('legacy', function ($request) {
            if (isset($request->token)) {
                $session = Session::where('token', $request->token)->where('expired', false)->first();
                if ($session !== null) {
                    return User::where('id', $session->user_id)->firstOrFail();
                }
            }
            return null;
        });
    }
}
