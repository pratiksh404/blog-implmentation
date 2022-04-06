<?php

namespace App\Providers;

use App\Mixins\AdminRouteMixins;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use App\Repositories\CategoryRepository;
use App\Contracts\CategoryRepositoryInterface;
use App\Contracts\PostRepositoryInterface;
use App\Repositories\PostRepository;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /* Repository Interface Binding */
        $this->repos();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Registering Blade Directives
        Paginator::useBootstrap();
        // Mixins
        Route::mixin(new AdminRouteMixins());
    }

    // Repository Interface Binding
    protected function repos()
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
    }
}
