<?php

use App\UI\Http\Auth\LoginController;
use App\UI\Http\Auth\RefreshTokenController;
use App\UI\Http\User\CreateUserAccountController;
use App\UI\Http\User\CreateUserController;
use App\UI\Http\User\GetUserAccountsController;
use App\UI\Http\User\GetUserController;
use App\UI\Http\User\UpdateUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
 * Welcome route - link to any public API documentation here
 */
Route::get('/', function () {
    echo 'Welcome to our API';
});

Route::prefix('api')
    ->middleware('api')
    ->name('api.')
    ->group(function () {
        Route::prefix('v1')
            ->name('v1.')
            ->namespace('\\')
            ->group(function () {
                Route::post('/login', LoginController::class)->name('login');
                Route::post('/users', CreateUserController::class)->name('create_user');

                Route::middleware(['auth:api'])->group(function () {
                    Route::get('/refresh-token', RefreshTokenController::class)->name('refresh_token');
                    Route::get('/users/{id}', GetUserController::class)->name('get_user');
                    Route::patch('/users/{id}', UpdateUserController::class)->name('update_user');
                    Route::get('/users/{id}/accounts', GetUserAccountsController::class)->name('get_user_accounts');
                    Route::post('/users/{id}/accounts', CreateUserAccountController::class)->name('create_user_accounts');
                });
            });
    });
