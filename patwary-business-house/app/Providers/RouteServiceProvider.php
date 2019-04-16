<?php

namespace App\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider {

    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot() {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map() {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
        $this->mapInventoryRoutes();
        $this->mapRicemillRoutes();
        $this->mapFlourmillRoutes();
        $this->mapDalmillRoutes();
        $this->mapOvenRoutes();
        $this->mapPackagingRoutes();
        $this->mapRentalRoutes();
        $this->mapMurimillRoutes();
        $this->mapChiramillRoutes();
        $this->mapBagmillRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes() {
        Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));
    }

    // inventory routes
    protected function mapInventoryRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/inventory.php'));
    }

    // ricemill routes
    protected function mapRicemillRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/ricemill.php'));
    }

    // flourmill routes
    protected function mapFlourmillRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/flourmill.php'));
    }
    
    // flourmill routes
    protected function mapDalmillRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/dalmill.php'));
    }
    
    // flourmill routes
    protected function mapOvenRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/ovenfactory.php'));
    }
    
    protected function mapPackagingRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/packaging.php'));
    }
    
    // Rental Related routes
    protected function mapRentalRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/rental.php'));
    }

    // murimill routes
    protected function mapMurimillRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/murimill.php'));
    }

    // murimill routes
    protected function mapChiramillRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/chiramill.php'));
    }

    // Bagmill routes
    protected function mapBagmillRoutes() {
        Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/bag.php'));
    }

}
