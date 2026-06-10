<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\AuthorizedAccessController;
use App\Models\AuthorizedAccess\AuthorizedAccessUser;
use App\Models\System\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

Route::get('/autorizovany-pristup/email/verify/{id}/{hash}', function (Request $request, int $id, string $hash) {
    $user = AuthorizedAccessUser::findOrFail($id);

    abort_unless(hash_equals((string) $hash, sha1($user->getEmailForVerification())), 403);

    if (!$user->hasVerifiedEmail()) {
        $user->markEmailAsVerified();
    }

    $locale = $user->lang_locale ?? app()->getLocale();
    $loginSlug = Page::query()
        ->where('type', 'authorized-access-login')
        ->where('lang_locale', $locale)
        ->where('active', 1)
        ->value('slug');

    return redirect('/' . ($loginSlug ?? 'autorizovany-pristup/prihlaseni'));
})->middleware('signed')->name('authorized-access.verification.verify');

Route::post('/autorizovany-pristup/logout', function () {
    Auth::guard('authorized_access')->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->middleware('web')->name('authorized-access.logout');

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


