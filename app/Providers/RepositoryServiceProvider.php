<?php

namespace App\Providers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\AdminInterface;
use App\Interfaces\BannerInterface;
use App\Interfaces\UserInterface;
use App\Interfaces\PainterInterface;
use App\Interfaces\CustomerInterface;
use App\Interfaces\ProductInterface;
use App\Interfaces\RewardProductInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\BannerRepository;
use App\Repositories\UserRepository;
use App\Repositories\PainterRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\RewardProductRepository;
use App\Repositories\AdminRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(BannerInterface::class, BannerRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(PainterInterface::class, PainterRepository::class);
        $this->app->bind(CustomerInterface::class, CustomerRepository::class);
        $this->app->bind(ProductInterface::class, ProductRepository::class);
        $this->app->bind(RewardProductInterface::class, RewardProductRepository::class);
        $this->app->bind(AdminInterface::class, AdminRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
