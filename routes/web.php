<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Auth\AuthenticationException;
use App\Http\Controllers\ChatGptController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/register', function () { 
    return view('register');
});
Route::get('/login', function () { 
    return view('login');
});
Route::get('/chat', function () { 

    return view('chat');
});
// Route::get('chat', [ChatGptController::class, 'chat']);