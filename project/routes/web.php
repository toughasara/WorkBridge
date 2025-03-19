<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Recruiter\CompanyController;
use App\Http\Controllers\Candidat\ProfilCandidatController;


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

// aythentification routes
Route::get('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('store', [AuthController::class, 'store'])->name('store');
Route::post('loginUser', [AuthController::class, 'loginUser'])->name('loginUser');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('Dashboard', [AuthController::class, 'redirectBasedOnRole'])->name('Dashboard');


Route::post('register', [AuthController::class, 'register'])->name('admin');

// candidat
Route::get('candidat', [ProfilCandidatController::class, 'index'])->name('candidat');
Route::post('candidat/information/store', [ProfilCandidatController::class, 'store'])->name('candidat.info.store');


// recruiter
Route::get('recruiter', [CompanyController::class, 'index'])->name('recruter');
Route::post('recruiter/information/store', [CompanyController::class, 'store'])->name('recruiter.info.store');


Route::get('/', function () {
    return view('welcome');
});
