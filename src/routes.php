<?php
use Illuminate\Support\Facades\Route;

Route::post('usercrm/', [\Esatic\activateuser\Controllers\ContactController::class, 'save']);
// Route::get('accounts', [\App\Http\Controllers\Api\AccountController::class, 'index']);
