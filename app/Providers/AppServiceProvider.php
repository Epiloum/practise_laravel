<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            \Event::listen(
                'Illuminate\Database\Events\QueryExecuted',
                function ($query) {
                    \Log::info(
                        [
                            'sql' => $query->sql,
                            'bindings' => $query->bindings,
                            'time' => $query->time,
                        ]
                    );
                }
            );
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        DB::listen(function ($query) {
			Log::info('Query: ' . $query->sql . '|Binding: ' . implode(',', $query->bindings));
        });
    }
}
