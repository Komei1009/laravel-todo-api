<?php

declare(strict_types=1);

use App\Http\Controllers\WeeklyReport;
use Illuminate\Http\JsonResponse;
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

Route::get('health', fn(): string => '');

Route::middleware(['auth.basic'])->group(function (): void {
    Route::get('ping', fn(): JsonResponse => response()->json(['pong1']));
    Route::post('weekly-reports', WeeklyReport\StoreController::class)
        ->name('weekly-reports.store');
});
