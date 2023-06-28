<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRol;
use App\Http\Controllers\AdministratorController;
use App\Http\Controllers\OrganizatorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SecurityController;

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

Route::get('/', function () {
    return view('home');
});

Route::get('/user_id', function () {
    return response()->json(['user_id' => auth()->id()]);
});

Route::get('/session-data', function () {
    return response()->json(auth()->user());
});

Route::get('/home', function () {
    return view('account');
});
     
Route::middleware(['auth', 'checkrol:1'])->group(function () {
    Route::get('/branch_office', function () {
        return view('account');
    });

    Route::get('/add_branch_office', function () {
        return view('account');
    });

    Route::get('/cashier', function () {
        return view('account');
    });

    Route::get('/collection', function () {
        return view('account');
    });
    
    Route::get('/administrator', [AdministratorController::class, 'index']);
});

require __DIR__.'/auth.php';
