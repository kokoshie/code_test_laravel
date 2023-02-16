<?php

namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Category\CategoryRepository;
use App\Repositories\Category\Interfaces\CategoryInterface;
use App\Repositories\Product\ProductRepository;
use App\Repositories\Product\Interfaces\ProductInterface;
use App\Repositories\Seller\SellerRepository;
use App\Repositories\Seller\Interfaces\SellerInterface;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            CategoryInterface::class,
            CategoryRepository::class
        );

        $this->app->bind(
            ProductInterface::class,
            ProductRepository::class
        );

        $this->app->bind(
            SellerInterface::class,
            SellerRepository::class
        );
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
