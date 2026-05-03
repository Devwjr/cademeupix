<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CobrancaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DividaController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('clientes', ClienteController::class);

    Route::resource('dividas', DividaController::class);
    Route::post('dividas/{divida}/marcar-pago', [DividaController::class, 'marcarPago'])->name('dividas.marcar-pago');

    Route::resource('cobrancas', CobrancaController::class)->except(['create', 'store']);
    Route::get('cobrancas/divida/{divida}/create', [CobrancaController::class, 'create'])->name('cobrancas.create');
    Route::post('cobrancas/divida/{divida}', [CobrancaController::class, 'store'])->name('cobrancas.store');
    Route::post('cobrancas/{cobranca}/marcar-pago', [CobrancaController::class, 'marcarPago'])->name('cobrancas.marcar-pago');
    Route::get('cobrancas/{cobranca}/whatsapp', [CobrancaController::class, 'enviarWhatsApp'])->name('cobrancas.whatsapp');
});

Route::get('/suporte', [LandingController::class, 'support'])->name('support');
Route::get('/precos', [LandingController::class, 'pricing'])->name('pricing');
Route::get('/marketing', [LandingController::class, 'marketing'])->name('marketing');
Route::post('/assinatura', [LandingController::class, 'createSubscription'])->name('subscription.create');
Route::get('/assinatura/sucesso', [LandingController::class, 'subscriptionSuccess'])->name('subscription.success');
Route::get('/assinatura/cancelar', [LandingController::class, 'subscriptionCancel'])->name('subscription.cancel');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');
