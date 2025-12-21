<?php

namespace App\Providers;

use App\Models\ContactType;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Share contact types with all admin views
        View::composer('layouts.admin', function ($view) {
            $view->with('contactTypes', \App\Models\ContactType::active()
                ->orderBy('sort_order')
                ->get(['id', 'name', 'slug'])
            );
        });
    }
}
