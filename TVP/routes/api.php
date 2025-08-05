<?php

declare(strict_types=1);

use App\Http\Controllers\Api\ClientUpdateApiController;
use App\Http\Controllers\Api\MediviaCoinsApiController;
use App\Http\Controllers\Api\MercadoPagoApiController;
use App\Http\Controllers\Api\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use PragmaRX\Google2FA\Google2FA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Account;

use App\Http\Controllers\TwitchWebhookController;
Route::post('/twitch/webhook', [TwitchWebhookController::class, 'handle']);

Route::get('/send-email', [MailController::class, 'sendEmail']);

Route::post('/2fa/verify', function (Request $request) {
    $request->validate([
        'account_number' => 'required|integer'
    ]);

    $google2fa = new Google2FA();
    $account = DB::table('accounts')->where('id', $request->account_number)->first();

    if (!$account) {
        return response()->json([
            'message' => 'Conta não encontrada!',
            'status_code' => 404
        ], 404);
    }

    if (is_null($account->google2fa_secret)) {
        return response()->json([
            'message' => '2FA não configurado, acesso permitido!',
            'status_code' => 201
        ], 201);
    }

    if (!$request->has('code')) {
        return response()->json([
            'message' => '2FA está ativado para esta conta.',
            'status_code' => 202
        ], 202);
    }

    $isValid = $google2fa->verifyKey($account->google2fa_secret, $request->code);

    if ($isValid) {
        return response()->json([
            'message' => '2FA verificado com sucesso!',
            'status_code' => 200
        ], 200);
    }

    return response()->json([
        'message' => 'Código inválido!',
        'status_code' => 422
    ], 422);
});

Route::group(['prefix' => 'v1', 'as' => 'v1.'], function () {
    Route::group(['prefix' => 'payment-method', 'as' => 'payment-method.'], function () {
        Route::group(['prefix' => 'mercado-pago', 'as' => 'mercado-pago.'], function () {
            Route::post('/notify', [MercadoPagoApiController::class, 'notify'])->name('notify');
            Route::get('/status', [MercadoPagoApiController::class, 'status'])->name('status');
        });
        Route::group(['prefix' => 'medivia-coins', 'as' => 'medivia-coins.'], function () {
            Route::group(['prefix' => 'server', 'as' => 'server.'], function () {
                Route::get('/{id}', [MediviaCoinsApiController::class, 'info'])->name('info');
            });
        });
    });
});

Route::group(['prefix' => 'client', 'as' => 'client.'], function () {
    Route::group(['prefix' => 'update', 'as' => 'update.'], function () {
        Route::post('/', [ClientUpdateApiController::class, 'update']);
    });
    Route::group(['prefix' => 'file', 'as' => 'file.'], function () {
        Route::get('/{path}', [ClientUpdateApiController::class, 'file'])->where('path', '.*');
    });
});

// Route::group(['prefix' => 'api/client'], function () {
//     Route::post('/updater.php', [ClientUpdateApiController::class, 'update']);
//     Route::get('/file/{path}', [ClientUpdateApiController::class, 'file'])->where('path', '.*');
// });


// Route::post('/client/update', [ClientUpdateApiController::class, 'update']);
// Route::get('/client/file/{path}', [ClientUpdateApiController::class, 'file'])->where('path', '.*');


Route::post('/accounts', [AccountController::class, 'getAllAccountIds']);
