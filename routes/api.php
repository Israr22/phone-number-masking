<?php

use App\Http\Controllers\WebHookController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('sms', [WebHookController::class, 'sms'])->name('sms');
Route::post('voice',  [WebHookController::class, 'voice'])->name('voice');
