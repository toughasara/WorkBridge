<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SkillController ;
use App\Http\Controllers\LanguageController;

use App\Http\Controllers\Recruiter\CompanyController;

use App\Http\Controllers\Candidat\ProfilCandidatController;
use App\Http\Controllers\Candidat\CvController;
use App\Http\Controllers\Candidat\WorkbridgeCVController;
use App\Http\Controllers\Candidat\ExperienceController;
use App\Http\Controllers\Candidat\EducationController;




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

// routes pour la navigation du candidat
Route::middleware(['auth'])->group(function () {
    Route::get('/candidat/home', [ProfilCandidatController::class, 'index'])->name('home');
    
    Route::get('/candidat/interviews', [ProfilCandidatController::class, 'index'])->name('interviews');
    
    Route::get('/candidat/saved-jobs', [ProfilCandidatController::class, 'index'])->name('saved.jobs');
    
    Route::get('/candidat/messages', [ProfilCandidatController::class, 'index'])->name('messages');
    
    Route::get('/candidat/notifications', [ProfilCandidatController::class, 'index'])->name('notifications');
    
    Route::get('/candidat/profile', [ProfilCandidatController::class, 'index'])->name('profile');
    Route::get('/candidat/profile/resume', [ProfilCandidatController::class, 'show'])->name('profile');

});

// routes pour le profil de candidat
Route::middleware(['auth'])->group(function () {

    Route::get('/profil/candidat', [ProfilCandidatController::class, 'showProfil'])->name('profil.candidat');

    Route::get('/profil/candidat/resume', [ProfilCandidatController::class, 'showResume'])->name('resume.view');

    Route::resource('cv', CvController::class)->only(['store', 'update', 'destroy']);

    Route::resource('resume', WorkbridgeCVController::class)->except(['index']);

    Route::resource('resumes.experiences', ExperienceController::class)->except(['index', 'show']);

    Route::resource('education', EducationController::class)->except(['index', 'show']);

    Route::resource('skill', SkillController::class)->except(['index', 'show']);

    Route::resource('language', LanguageController::class)->except(['index', 'show']);
});


// recruiter
Route::get('recruiter', [CompanyController::class, 'index'])->name('recruter');
Route::post('recruiter/information/store', [CompanyController::class, 'store'])->name('recruiter.info.store');


Route::get('/', function () {
    return view('welcome');
});
