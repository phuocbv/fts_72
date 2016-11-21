<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\SubjectRepository;
use App\Repositories\Contracts\SubjectRepositoryInterface;
use App;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(SubjectRepositoryInterface::class, SubjectRepository::class);
    }
}
