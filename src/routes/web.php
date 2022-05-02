<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/**
 * token生成
 */
Route::get('/token', function () {
    return response()->json(
        [
            'token' => csrf_token(),
        ]
    );
});

Route::get('/rest', [\App\Http\Controllers\RestappController::class, 'index']);
Route::post('/rest', [\App\Http\Controllers\RestappController::class, 'create']);
