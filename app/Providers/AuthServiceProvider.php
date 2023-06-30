<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        'App\Models\Category' => 'App\Policies\CategoryPolicy',
        'App\Models\Profile' => 'App\Policies\ProfilePolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Return true if user type is admin else false
        Gate::define('isAdmin', function($user) {
            return $user->type == 'admin';
        });

        // Return true if user type is admin else false
        Gate::define('isUser', function($user) {
            return $user->type == 'user';
        });

        Gate::define('my-profile', function(User $user){
            return true;
        });
    
        Gate::define('update-profile', function(User $user){
            return true;
        });
    
        Gate::define('user-profile', function($user){
            return $user->type === 'admin';
        });

        

    }
}
