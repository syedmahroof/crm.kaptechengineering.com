<?php

namespace App\Providers;

use App\Models\Itinerary;
use App\Models\Lead;
use App\Models\LeadAgent;
use App\Policies\ItineraryPolicy;
use App\Policies\LeadAgentPolicy;
use App\Policies\LeadPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        LeadAgent::class => LeadAgentPolicy::class,
        Lead::class => LeadPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
