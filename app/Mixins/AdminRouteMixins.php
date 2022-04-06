<?php

namespace App\Mixins;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;

class AdminRouteMixins
{
    public function admin()
    {
        return function () {
            Route::group(['prefix' => config('adminetic.prefix', 'admin'), 'middleware' => config('adminetic.middleware')], function () {
                Route::resource('post', PostController::class);
                Route::resource('category', CategoryController::class);
            });
        };
    }
}
