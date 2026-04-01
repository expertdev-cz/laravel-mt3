<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ServicesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PagesController::class, 'index']);

Route::post('/login', [LoginController::class, 'authenticate'])->name('login');

//Route::get('/products-search', [PagesController::class, 'searchProduct']);

$allowMaintenanceEndpoint = function (Request $request): void {
    if (app()->environment('local')) {
        return;
    }

    $expectedToken = (string) env('MAINTENANCE_ENDPOINT_TOKEN', '');
    $providedToken = (string) $request->query('token', '');

    if ($expectedToken === '' || !hash_equals($expectedToken, $providedToken)) {
        abort(404);
    }
};

Route::get('/artisan-route-clean', function (Request $request) use ($allowMaintenanceEndpoint) {
    $allowMaintenanceEndpoint($request);
    $exitCode = Artisan::call('route:clear');
    echo 'code: '. $exitCode.' output: '.Artisan::output();
});

Route::get('/artisan-route-cache', function (Request $request) use ($allowMaintenanceEndpoint) {
    $allowMaintenanceEndpoint($request);
    $exitCode = Artisan::call('route:cache');
    echo 'code: '. $exitCode.' output: '.Artisan::output();
});

Route::get('/artisan-optimize', function (Request $request) use ($allowMaintenanceEndpoint) {
    $allowMaintenanceEndpoint($request);
    $exitCode = Artisan::call('optimize');
    echo 'code: '. $exitCode.' output: '.Artisan::output();
});

/*System mics*/
Route::get('/sitemap-generator', [ServicesController::class, 'sitemapGenerator']);

// Article slug redirect - POZOR: Fallback route se registruje v RouteServiceProvider
// až PO načtení všech page routes, aby měly stránky vždy přednost


