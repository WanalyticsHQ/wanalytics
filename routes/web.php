<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

use App\Http\Controllers\AccountController;
use App\Http\Controllers\WebsiteController;
use App\Http\Controllers\BillingController;

Route::get('/', function () {
    return redirect(route('login'));
});

Route::group(['middleware' => ['auth', 'verified', 'check.trial']], function () {

    // websites
    Route::get('/websites', [WebsiteController::class, 'index'])->name('websites.index');
    Route::get('/websites/create', [WebsiteController::class, 'create'])->name('websites.create');
    Route::post('/websites', [WebsiteController::class, 'store'])->name('websites.store');
    Route::get('/websites/{id}/edit', [WebsiteController::class, 'edit'])->name('websites.edit');
    Route::put('/websites/{id}', [WebsiteController::class, 'update'])->name('websites.update');
    Route::get('/websites/{id}', [WebsiteController::class, 'show'])->name('websites.show')->withoutMiddleware(['auth', 'verified', 'check.trial']);
    Route::get('/websites/{id}/statistics', [WebsiteController::class, 'statistics'])->name('websites.statistics')->withoutMiddleware(['auth', 'verified', 'check.trial']);

    // account
    Route::get('/account', [AccountController::class, 'edit'])->name('account.edit');
    Route::post('/account', [AccountController::class, 'update'])->name('account.update');
    Route::post('/account/update-password', [AccountController::class, 'updatePassword'])->name('account.update-password');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('account.destroy');

    // billing
    Route::get('/billing', [BillingController::class, 'index'])->name('billing.index');
    Route::get('/billing/redirect-to-portal', [BillingController::class, 'redirectToPortal'])->name('billing.redirect-to-portal');
    Route::post('/billing/generate-checkout-link', [BillingController::class, 'generateCheckoutLink'])->name('billing.generate-checkout-link');
    Route::get('/billing/upgrade-success', [BillingController::class, 'index'])->name('billing.upgrade-success');

    Route::get('/billing/upgrade-success', function () {
        return Inertia::render('Billing/success');
    });
});

require __DIR__.'/auth.php';
