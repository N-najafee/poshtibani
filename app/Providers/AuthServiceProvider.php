<?php

namespace App\Providers;

use App\Models\Response;
use App\Models\Subject;
use App\Models\Ticket;
use App\Models\User;
use App\Policies\ResponsePolicy;
use App\Policies\SubjectPolicy;
use App\Policies\TicketPolicy;
use App\Policies\UserPolicy;
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
         User::class => UserPolicy::class,
         Ticket::class => TicketPolicy::class,
        Subject::class=>SubjectPolicy::class,
        Response::class=>ResponsePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


    }
}
