<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $data = DB::table('config')->first();
        $kategori = DB::table('kategori')->get();

        
        
        View::share('config', $data);
        View::share('kategori', $kategori);
       
    }
}
