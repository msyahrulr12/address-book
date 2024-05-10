<?php

use App\Http\Controllers\Api\V1\AddressBookController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::middleware(['signature'])->prefix('v1')->group(function() {
    Route::resource('users', UserController::class);
    Route::resource('address-books', AddressBookController::class);
    Route::post('address-books/import', [AddressBookController::class, 'import']);
});
