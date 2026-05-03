<?php

use App\Http\Controllers\Api\ClienteController;
use App\Http\Controllers\Api\CobrancaController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DividaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::apiResource('/clientes', ClienteController::class)->except(['create', 'edit']);

    Route::apiResource('/dividas', DividaController::class)->except(['create', 'edit']);
    Route::post('/dividas/{divida}/marcar-pago', [DividaController::class, 'marcarPago']);
    Route::post('/dividas/{divida}/gerar-cobranca', [DividaController::class, 'gerarCobranca']);

    Route::prefix('/cobrancas')->group(function () {
        Route::get('/{cobranca}', [CobrancaController::class, 'show']);
        Route::put('/{cobranca}', [CobrancaController::class, 'update']);
        Route::delete('/{cobranca}', [CobrancaController::class, 'destroy']);
        Route::post('/{cobranca}/marcar-pago', [CobrancaController::class, 'marcarPago']);
        Route::get('/{cobranca}/whatsapp', [CobrancaController::class, 'whatsAppLink']);
    });
});
