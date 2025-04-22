<?php

namespace App\Providers;

use App\Repositories\Contracts\TagRepositoryInterface;
use App\Repositories\Contracts\TaskRepositoryInterface;
use App\Repositories\Eloquent\TagRepository;
use App\Repositories\Eloquent\TaskRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
        $this->app->bind(TagRepositoryInterface::class, TagRepository::class);
    }


    public function boot(): void
    {
        //
    }
}
