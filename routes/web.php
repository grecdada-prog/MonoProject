<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// AUTH
use App\Http\Controllers\Auth\MixedLoginController;
use App\Http\Controllers\Auth\SuperAdminLoginController;
use App\Http\Controllers\Auth\TwoFactorController;
use App\Http\Controllers\Auth\TotpController;
use App\Http\Controllers\Auth\TotpChallengeController;
use App\Http\Controllers\Auth\ConfirmTwoFactorController;

// DASHBOARDS
use App\Http\Controllers\SuperAdmin\DashboardController as SuperAdminDashboardController;
use App\Http\Controllers\Gerant\DashboardController as GerantDashboardController;
use App\Http\Controllers\Vendeur\DashboardController as VendeurDashboardController;

// MODULES
use App\Http\Controllers\SuperAdmin\UserController as SuperAdminUserController;
use App\Http\Controllers\SuperAdmin\ActivityLogController;
use App\Http\Controllers\SuperAdmin\StoreController;
use App\Http\Controllers\Gerant\ProductController as GerantProductController;
use App\Http\Controllers\Gerant\StockSupplyController;
use App\Http\Controllers\Gerant\ActivityController as GerantActivityController;
use App\Http\Controllers\Vendeur\SaleController as VendeurSaleController;
use App\Http\Controllers\Vendeur\ActivityController as VendeurActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\StatisticsController;

// =============================
//   LOGOUT
// =============================
Route::post('/logout', function () {
    Auth::logout();
    return redirect()->route('login.mix');
})->name('logout');


// =============================
//   STATS (pour Chart.js)
// =============================
Route::get('/stats/sales-7days', [StatisticsController::class, 'sales7days'])
    ->middleware('auth');
Route::get('/stats/top-products', [StatisticsController::class, 'topProducts'])
    ->middleware('auth');


// =============================
//   FACTURE PDF rapide (vendeur)
// =============================
Route::get('/vendeur/last-invoice-pdf', [VendeurDashboardController::class, 'lastInvoicePdf'])
    ->middleware(['auth', 'vendeur'])
    ->name('vendeur.dashboard.lastpdf');


// =============================
//   CHALLENGE TOTP AU LOGIN
// =============================
Route::get('/two-factor/totp', [TotpChallengeController::class, 'showForm'])
    ->name('twofactor.form.totp');

Route::post('/two-factor/totp', [TotpChallengeController::class, 'verify'])
    ->name('twofactor.verify.totp');


// =============================
//   2FA EMAIL (OTP SIMPLE)
// =============================
Route::get('/two-factor', [TwoFactorController::class, 'showForm'])
    ->name('twofactor.form');

Route::post('/two-factor', [TwoFactorController::class, 'verify'])
    ->name('twofactor.verify');


// =============================
//   2FA TOTP (Google Authenticator)
// =============================
Route::middleware('auth')->group(function () {
    Route::get('/2fa/totp/setup', [TotpController::class, 'setup'])
        ->name('totp.setup');

    Route::post('/2fa/totp/verify', [TotpController::class, 'verify'])
        ->name('totp.verify');

    Route::post('/2fa/totp/disable', [TotpController::class, 'disable'])
        ->name('totp.disable');
});

// Confirmation TOTP pour actions sensibles
Route::get('/2fa/confirm', [ConfirmTwoFactorController::class, 'showForm'])
    ->name('twofactor.form.confirm');

Route::post('/2fa/confirm', [ConfirmTwoFactorController::class, 'verify'])
    ->name('twofactor.confirm.verify');


// =============================
//   PROFIL
// =============================
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::post('/profile/password', [ProfileController::class, 'updatePassword'])
        ->name('profile.password');
});


// =============================
//   NOTIFICATIONS
// =============================
Route::middleware('auth')->group(function () {

    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])
        ->name('notifications.read');

    Route::post('/notifications/read-all', [NotificationController::class, 'markAllRead'])
        ->name('notifications.readall');

    // API: Total ventes du jour
    Route::get('/api/today-sales', function () {
        $user = auth()->user();

        if ($user->hasRole('vendeur')) {
            // Vendeur : ses ventes uniquement
            $total = \App\Models\Sale::where('seller_id', $user->id)
                ->whereDate('sold_at', today())
                ->sum('total_amount');
        } elseif ($user->hasRole('gerant')) {
            // Gérant : ventes de ses vendeurs
            $vendeursIds = \App\Models\User::role('vendeur')
                ->where('manager_id', $user->id)
                ->pluck('id');

            $total = \App\Models\Sale::whereIn('seller_id', $vendeursIds)
                ->whereDate('sold_at', today())
                ->sum('total_amount');
        } else {
            $total = 0;
        }

        return response()->json(['total' => $total]);
    })->name('api.today-sales');
});


// =============================
//   PAGE D'ACCUEIL -> LOGIN MIXTE
// =============================
Route::get('/', function () {
    return redirect()->route('login.mix');
});


// =============================
//   LOGIN MIXTE GERANT / VENDEUR
// =============================
Route::get('/login', function () {
    return view('auth.login-mix');
})->name('login.mix');

Route::post('/login/mix', [MixedLoginController::class, 'login'])
    ->name('login.mix.submit');


// =============================
//   LOGIN SUPER ADMIN
// =============================
Route::get('/superadmin/login', function () {
    return view('superadmin.login');
})->name('superadmin.login');

Route::post('/superadmin/login', [SuperAdminLoginController::class, 'login'])
    ->name('superadmin.login.submit');


// =============================
//   REDIRECTION GENERIQUE
// =============================
Route::get('/redirect-after-login', function () {

    $user = auth()->user();

    if ($user->hasRole('super-admin')) {
        return redirect()->route('superadmin.dashboard');
    }

    if ($user->hasRole('gerant')) {
        return redirect()->route('gerant.dashboard');
    }

    if ($user->hasRole('vendeur')) {
        return redirect()->route('vendeur.dashboard');
    }

    abort(403, "Rôle non reconnu.");
})->name('redirect');


// =============================
//   SUPER ADMIN
// =============================
Route::middleware(['auth', 'superadmin'])
    ->prefix('superadmin')
    ->name('superadmin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [SuperAdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Utilisateurs
        Route::prefix('users')->name('users.')->group(function () {

            Route::get('/', [SuperAdminUserController::class, 'index'])
                ->name('index');

            Route::get('/create', [SuperAdminUserController::class, 'create'])
                ->name('create');

            Route::post('/store', [SuperAdminUserController::class, 'store'])
                ->middleware('throttle:10,1')
                ->name('store');

            Route::get('/edit/{user}', [SuperAdminUserController::class, 'edit'])
                ->name('edit');

            Route::post('/update/{user}', [SuperAdminUserController::class, 'update'])
                ->name('update');

            Route::post('/toggle/{user}', [SuperAdminUserController::class, 'toggleStatus'])
                ->name('toggle');

            Route::delete('/delete/{user}', [SuperAdminUserController::class, 'destroy'])
                ->name('delete');

            Route::post('/force-logout/{user}', [SuperAdminUserController::class, 'forceLogout'])
                ->name('forceLogout');
        });

        // Historique / Audit
        Route::get('/activity', [ActivityLogController::class, 'index'])
            ->name('activity.index');

        Route::get('/activity/export/pdf', [ActivityLogController::class, 'exportPdf'])
            ->name('activity.export.pdf');

        Route::get('/activity/export/excel', [ActivityLogController::class, 'exportExcel'])
            ->name('activity.export.excel');

        // Magasins / Blocs
        Route::prefix('stores')->name('stores.')->group(function () {

            Route::get('/', [StoreController::class, 'index'])
                ->name('index');

            Route::get('/create', [StoreController::class, 'create'])
                ->name('create');

            Route::post('/store', [StoreController::class, 'store'])
                ->middleware('throttle:10,1')
                ->name('store');

            Route::get('/{store}', [StoreController::class, 'show'])
                ->name('show');

            Route::get('/edit/{store}', [StoreController::class, 'edit'])
                ->name('edit');

            Route::post('/update/{store}', [StoreController::class, 'update'])
                ->name('update');

            Route::post('/toggle/{store}', [StoreController::class, 'toggleStatus'])
                ->name('toggle');

            Route::delete('/delete/{store}', [StoreController::class, 'destroy'])
                ->name('delete');
        });
    });


// =============================
//   GERANT
// =============================
Route::middleware(['auth', 'gerant'])
    ->prefix('gerant')
    ->name('gerant.')
    ->group(function () {

        Route::get('/dashboard', [GerantDashboardController::class, 'index'])
            ->name('dashboard');

        // PRODUITS
        Route::prefix('products')->name('products.')->group(function () {

            Route::get('/', [GerantProductController::class, 'index'])
                ->name('index');

            Route::get('/create', [GerantProductController::class, 'create'])
                ->name('create');

            Route::post('/store', [GerantProductController::class, 'store'])
                ->name('store');

            Route::get('/edit/{product}', [GerantProductController::class, 'edit'])
                ->name('edit');

            Route::post('/update/{product}', [GerantProductController::class, 'update'])
                ->name('update');

            Route::delete('/delete/{product}', [GerantProductController::class, 'destroy'])
                ->name('delete');

            Route::post('/adjust-stock/{product}', [GerantProductController::class, 'adjustStock'])
                ->name('adjustStock');
        });

        // Widget produits en rupture
        Route::get('/widgets/low-stock', [GerantProductController::class, 'lowStockWidget'])
            ->name('widgets.lowStock');

        // VENDEURS
        Route::prefix('vendeurs')->name('vendeurs.')->group(function () {

            Route::get('/', [\App\Http\Controllers\Gerant\VendeurController::class, 'index'])
                ->name('index');

            Route::get('/create', [\App\Http\Controllers\Gerant\VendeurController::class, 'create'])
                ->name('create');

            Route::post('/store', [\App\Http\Controllers\Gerant\VendeurController::class, 'store'])
                ->middleware('throttle:5,1')
                ->name('store');

            Route::get('/edit/{vendeur}', [\App\Http\Controllers\Gerant\VendeurController::class, 'edit'])
                ->name('edit');

            Route::post('/update/{vendeur}', [\App\Http\Controllers\Gerant\VendeurController::class, 'update'])
                ->name('update');

            Route::post('/toggle/{vendeur}', [\App\Http\Controllers\Gerant\VendeurController::class, 'toggleStatus'])
                ->name('toggle');

            Route::delete('/delete/{vendeur}', [\App\Http\Controllers\Gerant\VendeurController::class, 'destroy'])
                ->name('delete');
        });

        // APPROVISIONNEMENT
        Route::prefix('supplies')->name('supplies.')->group(function () {

            Route::get('/', [StockSupplyController::class, 'index'])
                ->name('index');

            Route::get('/create', [StockSupplyController::class, 'create'])
                ->name('create');

            Route::post('/store', [StockSupplyController::class, 'store'])
                ->middleware('throttle:10,1')
                ->name('store');

            Route::get('/{supply}', [StockSupplyController::class, 'show'])
                ->name('show');
        });

        // HISTORIQUE D'ACTIVITÉ
        Route::prefix('activity')->name('activity.')->group(function () {

            Route::get('/', [GerantActivityController::class, 'index'])
                ->name('index');

            Route::get('/export/pdf', [GerantActivityController::class, 'exportPdf'])
                ->name('export.pdf');

            Route::get('/export/excel', [GerantActivityController::class, 'exportExcel'])
                ->name('export.excel');
        });
    });


// =============================
//   VENDEUR
// =============================
Route::middleware(['auth', 'vendeur'])
    ->prefix('vendeur')
    ->name('vendeur.')
    ->group(function () {

        Route::get('/dashboard', [VendeurDashboardController::class, 'index'])
            ->name('dashboard');

        Route::prefix('sales')->name('sales.')->group(function () {

            Route::get('/', [VendeurSaleController::class, 'index'])
                ->name('index');

            Route::get('/create', [VendeurSaleController::class, 'create'])
                ->name('create');

            Route::post('/store', [VendeurSaleController::class, 'store'])
                ->middleware('throttle:20,1') // Max 20 ventes par minute par vendeur
                ->name('store');

            Route::get('/invoice/{sale}', [VendeurSaleController::class, 'invoice'])
                ->name('invoice');

            Route::get('/invoice/{sale}/pdf', [VendeurSaleController::class, 'invoicePdf'])
                ->name('invoice.pdf');
        });

        // HISTORIQUE D'ACTIVITÉ
        Route::prefix('activity')->name('activity.')->group(function () {

            Route::get('/', [VendeurActivityController::class, 'index'])
                ->name('index');

            Route::get('/export/pdf', [VendeurActivityController::class, 'exportPdf'])
                ->name('export.pdf');

            Route::get('/export/excel', [VendeurActivityController::class, 'exportExcel'])
                ->name('export.excel');
        });
    });
