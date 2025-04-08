<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Candidat\SkillController ;
use App\Http\Controllers\LanguageController;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobApprovalController;
use App\Http\Controllers\Admin\UserManagementController;



use App\Http\Controllers\Recruiter\CompanyController;
use App\Http\Controllers\Recruiter\OffresController;
use App\Http\Controllers\Recruiter\ProfilRecruterController;
use App\Http\Controllers\Recruiter\SkillOffreController;
use App\Http\Controllers\Recruiter\LanguageOffreController;



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

    Route::resource('resumes.skills', SkillController::class)->except(['index', 'show']);

    Route::resource('language', LanguageController::class)->except(['index', 'show']);
});

// routes pour le profil de candidat
Route::middleware(['auth'])->group(function () {
    
    Route::resource('company', CompanyController::class);

    Route::get('recruiter', [OffresController::class, 'create'])->name('recruiter')->middleware(['auth', 'check.company']);
    
    Route::get('/recruiter/profile', [ProfilRecruterController::class, 'showProfile'])->name('recruiter.profile');
    
    
    Route::resource('recruiter/offers', OffresController::class);
    
    Route::resource('offres.skills', SkillController::class)->except(['index', 'show']);
    Route::resource('offres.language', SkillController::class)->except(['index', 'show']);
    
});




// routes d'admine
Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/UserManagement', [UserManagementController::class, 'index'])->name('admin.UserManagement');
Route::put('/admin/UserManagement/{recruiter}/suspend', [UserManagementController::class, 'suspend'])->name('admin.UserManagement.suspend');
Route::put('/admin/UserManagement/{recruiter}/activate', [UserManagementController::class, 'activate'])->name('admin.UserManagement.activate');
Route::delete('/admin/UserManagement/{recruiter}/destroy', [UserManagementController::class, 'destroy'])->name('admin.UserManagement.destroy');





Route::get('/', function () {
    return view('welcome');
});
