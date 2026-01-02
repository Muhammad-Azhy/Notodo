<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\Attachment;
use App\Models\Problem;
use App\Models\Reference;
use App\Models\Task;
use App\Models\User;
use App\Policies\AttachmentPolicy;
use App\Policies\ProblemPolicy;
use App\Policies\ReferencePolicy;
use App\Policies\TaskPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
   protected $policies = [
    Reference::class => ReferencePolicy::class,
    Task::class => TaskPolicy::class,
    Problem::class => ProblemPolicy::class,
    Attachment::class => AttachmentPolicy::class,
    User::class => UserPolicy::class,
];


    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
