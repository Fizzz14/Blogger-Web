<?php

namespace App\Providers;

use App\Models\Category;
use App\Observers\CategoryObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Category::observe(CategoryObserver::class);
    }
}
