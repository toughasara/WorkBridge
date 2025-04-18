voici le fichier Models/Application.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'offer_id',
        'resume_id',
        'status',
        'match_score',
        'feedback',
        'applied_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($application) {
            $application->applied_at = now();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function offer()
    {
        return $this->belongsTo(Offre::class, 'offer_id');
    }

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
"
voici le fichier Models/Company.php :
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'pays', 'ville', 'sector', 'size', 'website', 'description'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
"
 voici le fichier Models/Cv.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'filePath',
    ];

    // Relation belongsTo avec le modèle `User`
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
"
voici le fichier Models/Education.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'institution_name',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
    ];

    // Relation belongsTo avec le modèle `Resume`
    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }

}
"
voici le fichier Models/Experience.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'resume_id',
        'company_name',
        'job_title',
        'start_date',
        'end_date',
        'description',
    ];

    public function resume()
    {
        return $this->belongsTo(Resume::class);
    }
}
"
voici le fichier Models/Language.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function resumes()
    {
        return $this->belongsToMany(Resume::class, 'resume_skill');
    }

    public function offres()
    {
        return $this->belongsToMany(Resume::class, 'offer_id');
    }

}
"
voici le fichier Models/MatchingPreference.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MatchingPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'offer_id',
        'use_ai',
        'skills_weight',
        'languages_weight',
        'experience_weight',
        'location_weight'
    ];

    public static function defaultWeights(): array
    {
        return [
            'skills' => 0.40,
            'languages' => 0.20,
            'experience' => 0.25,
            'location' => 0.15,
        ];
    }

    public function offer()
    {
        return $this->belongsTo(Offre::class, 'offer_id');
    }

}
"
voici le fichier Models/Offre.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offre extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'title', 'nombre_poste', 'type_contrat', 'mode_travail', 'description',
        'date_expiration', 'salaire', 'experience', 'location', 'statut', 'candidatures_count', 'company_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation many-to-many avec la table `skills`
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'offer_skill', 'offer_id', 'skill_id');
    }

    // Relation many-to-many avec la table `languages`
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'offer_language', 'offer_id', 'language_id')
                    ->withPivot('level');
    }

    public function company()
    {
        return $this->hasOneThrough(
            Company::class,
            User::class,
            'id', // Clé étrangère sur la table users
            'user_id', // Clé étrangère sur la table companies
            'user_id', // Clé locale sur la table offres
            'id' // Clé locale sur la table users
        );
    }

    public function matchingPreference()
    {
        return $this->hasOne(MatchingPreference::class, 'offer_id');
    }
    
}
"
voici le fichier Models/Resume.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'pays',
        'ville',
        'phone',
        'birthDate',
        'relocation_possible',
    ];

    // Relation belongsTo avec le modèle `User`
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relation one-to-many avec la table `experiences`
    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    // Relation one-to-many avec la table `education`
    public function education()
    {
        return $this->hasMany(Education::class);
    }

    // Relation many-to-many avec la table `skills`
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'resume_skill');
    }

    // Relation many-to-many avec la table `languages`
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'resume_language');
    }
    
}
"
voici le fichier Models/Role.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function users() {
        return $this->hasMany(User::class);
    }
    
}
"
voici le fichier Models/Skill.php : 
"<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function resumes()
    {
        return $this->belongsToMany(Resume::class, 'resume_skill');
    }

    public function offres()
    {
        return $this->belongsToMany(Resume::class, 'offer_id');
    }
    
}
"
voici le fichier Models/User.php : 
"<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'statut',
        'role_id',
    ];

    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role() {
        return $this->belongsTo(Role::class);
    }

    // Relation one-to-many avec la table `company`
    public function company()
    {
        return $this->hasOne(Company::class);
    }

    // Relation one-to-many avec la table `cvs`
    public function cvs()
    {
        return $this->hasMany(Cv::class);
    }

    // Relation one-to-one avec la table `resumes`
    public function resume()
    {
        return $this->hasOne(Resume::class);
    }

    // Relation one-to-many avec la table `offres`
    public function offres()
    {
        return $this->hasMany(Offre::class);
    }

    public function hasAppliedToJob($offerId)
    {
        return $this->applications()->where('offer_id', $offerId)->exists();
    }

    public function applications()
    {
        return $this->hasMany(\App\Models\Application::class);
    }
}
"

voici le fichier Controllers/Admin/DashboardController.php : 
"<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Offre;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques simplifiées
        $totalUsers = User::count();

        $totalCandidates = User::whereHas('role', function($q) {
            $q->where('title', 'candidat');
        })->count();

        $totalRecruiters = User::whereHas('role', function($q) {
            $q->where('title', 'recruteur');
        })->count();
        
        $totalJobs = Offre::count();
        $pendingJobs = Offre::where('statut', 'en attente')->count();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalRecruiters',
            'totalCandidates',
            'totalJobs',
            'pendingJobs'
        ));
    }
}
"
voici le fichier Controllers/Admin/JobApprovalController.php : 
"<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Offre;
use App\Models\Company;
use Illuminate\Http\Request;

class JobApprovalController extends Controller
{
    public function index()
    {
        $pendingJobs = Offre::with(['user.company'])
            ->where('statut', 'en attente')
            ->latest()
            ->paginate(8);

        return view('admin.jobapproval', compact('pendingJobs'));
    }

    public function approve(Request $request, Offre $job)
    {
        $validated = $request->validate([
            'comment' => 'nullable|string|max:500'
        ]);

        $job->update([
            'statut' => 'publiée',
        ]);

        return redirect()->route('admin.JobApproval')->with('success', 'Offre approuvée avec succès.');
    }

    public function reject(Request $request, Offre $job)
    {

        $job->update([
            'statut' => 'rejected',
        ]);

        return redirect()->route('admin.JobApproval')->with('success', 'Offre rejetée avec succès.');
    }
}
"
voici le fichier Controllers/Admin/UserManagementController.php : 
"<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserManagementController extends Controller
{

    public function index(Request $request)
    {
        $query = User::whereHas('role', function($q) {
            $q->where('title', 'recruteur');
        })->with('Company')->latest();

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        $recruiters = $query->paginate(15);

        return view('admin.usermanagement', compact('recruiters'));
    }

    public function suspend(User $recruiter)
    {
        $recruiter->update(['statut' => 'suspended']);
        return redirect()->back()->with('success', 'Recruteur suspendu avec succès.');
    }

    public function activate(User $recruiter)
    {
        $recruiter->update(['statut' => 'active']);
        return redirect()->back()->with('success', 'Recruteur activé avec succès.');
    }

    public function destroy(User $recruiter)
    {
        $recruiter->delete();
        return redirect()->back()->with('success', 'Recruteur supprimé avec succès.');
    }
}
"
voici le fichier Controllers/Candidat/CondidatureController.php : 
"<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use App\Models\Offre;
use App\Models\applications;
use Illuminate\Http\Request;

class CondidatureController extends Controller
{
    public function postuler(){}
}
"
voici le fichier Controllers/Candidat/CvController.php : 
"<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class CvController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'cv_file' => 'required|mimes:pdf|max:2048',
        ]);

        $user = Auth::user();
        $filePath = $request->file('cv_file')->store('cvs');

        Cv::create([
            'user_id' => $user->id,
            'filePath' => $filePath,
        ]);

        return redirect()->route('profil.candidat')->with('success', 'CV uploaded successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cv = Cv::findOrFail($id);

        $filePath = Storage::path($cv->filePath);
        
        return response()->file($filePath, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="'.$cv->filename.'"'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'cv_file' => 'required|mimes:pdf|max:2048',
        ]);

        $cv = Cv::findOrFail($id);
        Storage::delete($cv->filePath);

        $filePath = $request->file('cv_file')->store('cvs');
        $cv->update(['filePath' => $filePath]);

        return redirect()->route('profil.candidat')->with('success', 'CV updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cv = Cv::findOrFail($id);
        Storage::delete($cv->filePath);
        $cv->delete();

        return redirect()->route('profil.candidat')->with('success', 'CV deleted successfully.');
    }
}
"
voici le fichier Controllers/Candidat/EducationController.php : 
"<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
"
voici le fichier Controllers/Candidat/ExperienceController.php : 
"<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Experience;
use App\Models\Resume;


class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Resume $resume)
    {
        return view('candidat/experiencecreate', compact('resume'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Resume $resume)
    {
        // dd($request->all());
        // dd($resume);
        // dd($request);
        $request->validate([
            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable',
        ]);

        $resume->experiences()->create($request->all());

        return redirect()->route('resume.view')->with('success', 'Experience added successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Resume $resume, Experience $experience)
    {
        return view('candidat/experienceedit', compact('experience', 'resume'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resume $resume, Experience $experience)
    {
        $request->validate([
            'company_name' => 'required',
            'job_title' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable',
        ]);

        $experience->update($request->all());

        return redirect()->route('resume.view')->with('success', 'Experience updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resume $resume, Experience $experience)
    {
        // Vérifier que l'expérience appartient bien au CV
        if ($experience->resume_id !== $resume->id) {
            return redirect()->route('resume.view')->with('error', 'Unauthorized action.');
        }

        // Suppression
        $experience->delete();

        return redirect()->route('resume.view')->with('success', 'Experience deleted successfully.');
    }
}
"
voici le fichier Controllers/Candidat/JobController.php : 
"<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Offre;
use App\Models\Resume;
use App\Services\MatchService;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    protected $matchService;

    public function __construct(MatchService $matchService)
    {
        $this->matchService = $matchService;
    }

    // affichier les offres d'emploie recommander qui on plus de 50% de scor de matching
    public function index(Request $request)
    {
        $user = Auth::user();
        $resume = Resume::where('user_id', $user->id)->first();

        if (!$resume) {
            return redirect()->route('resume.create')
                ->with('warning', 'Veuillez d\'abord créer votre CV pour voir les offres recommandées.');
        }

        // recuperer toutes les offres publiées
        $allOffers = Offre::with(['company', 'skills', 'languages'])
            ->where('statut', 'publiée')
            ->get();

        // filter les offres avec score de matching plus que 50%
        $matchedOffers = collect();
        foreach ($allOffers as $offre) {
            $score = $this->matchService->calculate($resume, $offre);
            if ($score >= 1) {
                $offre->match_score = $score;
                $matchedOffers->push($offre);
            }
        }

        // classer les offres par score
        $jobs = $matchedOffers->sortByDesc('match_score');

        
        return view('candidat.pageaccueil', compact('jobs'));

    }

    public function getOfferDetails($id)
    {
        // try {
            $offer = Offre::with(['company', 'skills', 'languages'])
                ->where('id', $id)
                ->where('statut', 'publiée')
                ->first();

            if (!$offer) {
                return response()->json([
                    'success' => false,
                    'message' => 'Offre non trouvée ou non publiée'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'html' => view('candidat.offerdetails', compact('offer'))->render()
            ]);
            
        // } catch (\Exception $e) {
        //     \Log::error("Erreur dans getOfferDetails: " . $e->getMessage());
        //     return response()->json([
        //         'success' => false,
        //         'message' => 'Erreur serveur'
        //     ], 500);
        // }
    }

}
"
voici le fichier Controllers/Candidat/LanguageController.php : 
"<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\Language;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Resume $resume)
    {
        $languages = Language::all();
        $selectedLanguages = $resume->languages()->withPivot('level')->get();
        
        return view('candidat.languagecreat', [
            'resume' => $resume,
            'languages' => $languages,
            'selectedLanguages' => $selectedLanguages,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Resume $resume)
    {
        $request->validate([
            'languages' => 'required|array',
            'languages.*.selected' => 'sometimes|boolean',
            'languages.*.level' => 'required_with:languages.*.selected|in:débutant,intermédiaire,avancé,courant,natif',
            'new_language_name' => 'sometimes|string|max:255|unique:languages,name',
            'new_language_level' => 'required_with:new_language_name|in:débutant,intermédiaire,avancé,courant,natif',
        ]);

        // Préparer les données pour sync
        $languagesToSync = [];
        
        // Traiter les langues existantes
        foreach ($request->languages as $languageId => $data) {
            if (isset($data['selected']) && $data['selected']) {
                $languagesToSync[$languageId] = ['level' => $data['level']];
            }
        }
        
        // Traiter la nouvelle langue si elle existe
        if ($request->filled('new_language_name')) {
            $newLanguage = Language::firstOrCreate([
                'name' => $request->new_language_name
            ]);
            
            $languagesToSync[$newLanguage->id] = ['level' => $request->new_language_level];
        }
        
        // Synchroniser les langues avec le CV
        $resume->languages()->sync($languagesToSync);

        return redirect()
            ->route('resume.view', $resume->id)
            ->with('success', 'Vos langues ont été mises à jour avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
"
voici le fichier Controllers/Candidat/ProfilCandidatController.php : 
"<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cv;
use App\Models\User;
use App\Models\Resume;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class ProfilCandidatController extends Controller
{
    // formulaire info campany
    public function index()
    {
        return view('recruter/inforecruteur');
    }

    public function showProfil()
    {
        $user = Auth::user();
        $cv = Cv::where('user_id', $user->id)->first();
        $resume = $user->resume;

        return view('candidat/profilcandidat', compact('cv', 'resume'));
    }

    public function showResume()
    {
        $user = Auth::user();
        $resume = $user->resume;

        if (!$resume) {
            return redirect()->route('profil.candidat')->with('error', 'Aucun CV WorkBridge trouvé.');
        }

        $experiences = $resume->experiences;
        $educations = $resume->education;
        $skills = $resume->skills;
        $languages = $resume->languages;

        return view('candidat.candidatresume', compact('user', 'resume', 'experiences', 'educations', 'skills', 'languages'));
    }


}
"
voici le fichier Controllers/Candidat/SkillController.php : 
"<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Resume;
use App\Models\Skill;


class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Resume $resume)
    {
        $skills = Skill::all();

        $selectedSkills = $resume->skills;
        
        return view('candidat.skillcreat', [
            'resume' => $resume,
            'skills' => $skills,
            'selectedSkills' => $selectedSkills,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Resume $resume)
    {
        $request->validate([
            'skills' => 'required|array',
            'skills.*' => 'exists:skills,id',
        ]);

        $resume->skills()->sync($request->skills);

        return redirect()->route('resume.view')->with('success', 'Compétences mises à jour avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Resume $resume, Skill $skill)
    {
        $resume->skills()->detach($skill->id);

        return redirect()->route('resume.view')->with('success', 'Compétence supprimée avec succès.');
    }
}
"
voici le fichier Controllers/Candidat/WorkbridgeCVController.php : 
"<?php

namespace App\Http\Controllers\Candidat;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResumeRequest;
use App\Interfaces\Repositories\ResumeRepositoryInterface;
use Illuminate\Support\Facades\Auth;

class WorkbridgeCVController extends Controller
{

    private $resumeRepository;

    public function __construct(ResumeRepositoryInterface $resumeRepository)
    {
        $this->resumeRepository = $resumeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('candidat/resumecreate');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ResumeRequest  $request)
    {
        $this->resumeRepository->createForUser(
            Auth::id(),
            $request->validated()
        );

        return redirect()->route('resume.view')->with('success', 'Resume created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $resume = $this->resumeRepository->findById($id);
        return view('candidat/resumeedit', compact('resume'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ResumeRequest  $request, $id)
    {
        $this->resumeRepository->updateResume($id, $request->validated());
        
        return redirect()->route('resume.view')->with('success', 'Resume updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->resumeRepository->deleteResume($id);
        return redirect()->route('profil.candidat')->with('success', 'Resume deleted successfully.');
    }
}
"

voici le fichier Controllers/Recruiter/CompanyController.php : 
"<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if recruiter params contain  manual
             //Manual MatchService 
                // if manual wheight params are present  
                   // true
                   // false : use array decalared in Model 
        // Recruiter params contain  AI
           // call openAI service (you can give manual wheights or let gpt decide)  

        // 

        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('recruter/companiecreat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'pays' => 'required|string|max:255',
            'ville' => 'required|string|max:255',
            'sector' => 'required|string|max:255',
            'size' => 'required|string|max:255',
            // 'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        $user = Auth::user();

        $company = Company::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'pays' => $request->pays,
            'ville' => $request->ville,
            'sector' => $request->sector,
            'size' => $request->size,
            'website' => $request->website,
            'description' => $request->description,
        ]);


        return redirect()->route('recruiter')->with('success', 'Informations de l\'entreprise enregistrées avec succès !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($companyId)
    {
        $company = Company::findOrFail($companyId);
        
        return view('recruter.companieedit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'pays' => 'required|string|max:255',
                'ville' => 'required|string|max:255',
                'sector' => 'required|string|max:255',
                'size' => 'required|string|max:255',
                // 'website' => 'nullable|url|max:255',
                'description' => 'nullable|string',
            ]);
    
            $company = Auth::user()->company;
            $company->update($validatedData);
    
            return redirect()->route('recruiter.profile')->with('success', 'Les informations de votre entreprise ont été mises à jour.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
"
voici le fichier Controllers/Recruiter/MatchingPreferenceController.php : 
"<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MatchingPreference;
use App\Models\Offre;
use Illuminate\Support\Facades\Auth;

class MatchingPreferenceController extends Controller
{
    /**
     * Affiche la page des préférences de matching pour une offre
     */
    public function index($offreId)
    {
        $offre = Offre::findOrFail($offreId);
        
        $preference = MatchingPreference::where('offer_id', $offreId)->first();
        
        return view('recruter.preference', compact('offre', 'preference'));
    }
    
    /**
     * Enregistre ou met à jour les préférences de matching
     */
    public function storePreference(Request $request, $offreId)
    {
        // Récupérer l'offre
        $offre = Offre::findOrFail($offreId);

        $preference = MatchingPreference::where('offer_id', $offreId)->first();

        $useAi = $request->has('use_ai');

        if($useAi){
            $rules = ['use_ai' => 'sometimes',];
        }
        else{
            $rules['skills_weight'] = 'required|numeric|min:0|max:100';
            $rules['languages_weight'] = 'required|numeric|min:0|max:100';
            $rules['experience_weight'] = 'required|numeric|min:0|max:100';
            $rules['location_weight'] = 'required|numeric|min:0|max:100';
        }

        $validated = $request->validate($rules);

        if ($preference) {
            // modification si il existe 
            $this->updatePreference($preference, $request);
        } else {
            // creation si il n'existe pas 
            $this->createPreference($offreId, $request);
        }
        
        return redirect()->route('offers.index')->with('success', 'Les préférences de matching ont été enregistrées avec succès.');
    }

    // creation si il n'existe pas 
    private function createPreference($offreId, Request $request)
    {
        $useAi = $request->has('use_ai');

        if ($useAi) {
            // ajouter valeur par defaut si ai est utiliser 
            $skillsWeight = 0.40;
            $languagesWeight = 0.20;
            $experienceWeight = 0.25;
            $locationWeight = 0.15;
        } else {
            // changer les pois 0-1
            $skillsWeight = (float)$request->skills_weight / 100;
            $languagesWeight = (float)$request->languages_weight / 100;
            $experienceWeight = (float)$request->experience_weight / 100;
            $locationWeight = (float)$request->location_weight / 100;
        }
        
        MatchingPreference::create([
            'offer_id' => $offreId,
            'use_ai' => $useAi,
            'skills_weight' => $skillsWeight,
            'languages_weight' => $languagesWeight,
            'experience_weight' => $experienceWeight,
            'location_weight' => $locationWeight,
        ]);
    }

    // modification si il existe 
    private function updatePreference(MatchingPreference $preference, Request $request)
    {
        $useAi = $request->has('use_ai');
        
        if ($useAi) {
            // definie valeur par defaut si ai est utiliser 
            $skillsWeight = 0.40;
            $languagesWeight = 0.20;
            $experienceWeight = 0.25;
            $locationWeight = 0.15;
        } else {
            // changer les pois 0-1
            $skillsWeight = (float)$request->skills_weight / 100;
            $languagesWeight = (float)$request->languages_weight / 100;
            $experienceWeight = (float)$request->experience_weight / 100;
            $locationWeight = (float)$request->location_weight / 100;
        }
        
        $preference->update([
            'use_ai' => $useAi,
            'skills_weight' => $skillsWeight,
            'languages_weight' => $languagesWeight,
            'experience_weight' => $experienceWeight,
            'location_weight' => $locationWeight,
        ]);
    }
}
"
voici le fichier Controllers/Recruiter/OffresController.php : 
"<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use App\Http\Requests\OffreRequest;
use App\Interfaces\Services\OffreServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Skill;
use App\Models\Language;
use App\Services\MatchService;



class OffresController extends Controller
{

    private OffreServiceInterface $offreService;
    protected $matchService;

    public function __construct(OffreServiceInterface $offreService, MatchService $matchService)
    {
        $this->offreService = $offreService;
        $this->matchService = $matchService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): View
    {
        $offres = $this->offreService->getUserOffres(Auth::id());
        return view('recruter.offres', compact('offres'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $skills = Skill::all();
        $languages = Language::all();
        return view('recruter.offrecreat', compact('skills', 'languages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(OffreRequest $request): RedirectResponse
    {
        try {
            $offre = $this->offreService->createOffre($request->validated(), Auth::id());
            
            $message = 'Offre créée avec succès!';
            if ($request->statut === 'en attente') {
                $message .= ' (Votre offre est en attente de validation)';
            }

            return redirect()->route('offers.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View|RedirectResponse
    {
        try {
            $offre = $this->offreService->getOffreWithRelations($id, Auth::id());
            return view('recruter.offreshow', compact('offre'));
        } catch (\Exception $e) {
            return redirect()->route('offers.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View|RedirectResponse
    {
        try {
            $offre = $this->offreService->getOffreWithRelations($id, Auth::id());
            $skills = Skill::all();
            $languages = Language::all();
            return view('recruter.offreedit', compact('offre', 'skills', 'languages'));
        } catch (\Exception $e) {
            return redirect()->route('offers.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OffreRequest $request, $id): RedirectResponse
    {
        try {
            $this->offreService->updateOffre($id, $request->validated(), Auth::id());
            
            $message = 'Offre mise à jour avec succès!';
            if ($request->statut === 'en attente') {
                $message .= ' (Votre offre est en attente de validation)';
            }

            return redirect()->route('offers.index')->with('success', $message);
        } catch (\Exception $e) {
            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        try {
            $this->offreService->deleteOffre($id, Auth::id());
            return redirect()->route('offers.index')->with('success', 'Offre supprimée avec succès!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

}
"
voici le fichier Controllers/Recruiter/ProfilRecruterController.php : 
"<?php

namespace App\Http\Controllers\Recruiter;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class ProfilRecruterController extends Controller
{

    public function showProfile()
    {
        $user = Auth::user();
        
        $company = $user->company;
        
        return view('recruter.profilrecruteur', compact('user', 'company'));
    }
}
"

voici le fichier Controllers/AuthController.php : 
"<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    // formulaire login
    public function login()
    {
        return view('auth/login');
    }

    // formulaire register
    public function register()
    {
        return view('auth/register');
    }

    // Inscription
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|in:2,3',
        ]);

        // Création de l'utilisateur avec les nouveaux champs
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $request->role_id,
            'statut' => 'active',
        ]);

        // Connexion de l'utilisateur après l'inscription
        Auth::login($user);

        return $this->redirectBasedOnRole($user);
    }

    // Connexion
    public function loginUser(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->statut !== 'active') {
                Auth::logout();
                return back()->withErrors([
                    'email' => 'Votre compte est désactivé.',
                ]);
            }

            return $this->redirectBasedOnRole($user);     
        }

        return back()->withErrors([
            'email' => 'Les informations d\'identification sont incorrectes.',
        ]);
    }

    public function logout()
    {
        Auth::logout();

        return redirect()->route('login');
    }

    protected function redirectBasedOnRole($user)
    {
        switch ($user->role_id) {
            case 1:
                return redirect()->route('admin.dashboard');
            case 2:
                return redirect()->route('profil.candidat');
            case 3:
                return redirect()->route('recruiter');
            default:
                return redirect()->route('home');
        }
    }
}

"

voici le fichier Middleware/CheckCompanyInfo.php : 
"<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckCompanyInfo
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if (!$user->company) {
            return redirect()->route('company.create');
        }

        return $next($request);
    }
}
"
voici le fichier Middleware/CheckProfileCompletion.php : 
"<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        // Vérification si l'utilisateur a un profil complet
        if ($role === 'recruteur') {
            // Si l'utilisateur est recruteur, vérifie s'il a des informations sur l'entreprise
            if (!$user->company) { // Vérifie s'il a un enregistrement dans la table company
                return redirect()->route('recruter.completeProfile');
            }
        }

        if ($role === 'candidat') {
            // Si l'utilisateur est candidat, vérifie s'il a un CV
            if (!$user->resume) { // Vérifie s'il a un enregistrement dans la table resume
                return redirect()->route('candidat.completeProfile');
            }
        }

        // Si le profil est complété, autorise l'accès à la route demandée
        return $next($request);
    }
}
"
voici le fichier Kernel.php : 
"<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    /**
     * The application's global HTTP middleware stack.
     *
     * These middleware are run during every request to your application.
     *
     * @var array<int, class-string|string>
     */
    protected $middleware = [
        // \App\Http\Middleware\TrustHosts::class,
        \App\Http\Middleware\TrustProxies::class,
        \Fruitcake\Cors\HandleCors::class,
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        \App\Http\Middleware\TrimStrings::class,
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array<string, array<int, class-string|string>>
     */
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array<string, class-string|string>
     */
    protected $routeMiddleware = [
        'check.company' => \App\Http\Middleware\CheckCompanyInfo::class,
        'check.profile' => \App\Http\Middleware\CheckProfileCompletion::class,
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'cache.headers' => \Illuminate\Http\Middleware\SetCacheHeaders::class,
        'can' => \Illuminate\Auth\Middleware\Authorize::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'password.confirm' => \Illuminate\Auth\Middleware\RequirePassword::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,
    ];
}
"

voici le fichier Interfaces/Repositories/OffreRepositoryInterface.php : 
"<?php


namespace App\Interfaces\Repositories;

interface OffreRepositoryInterface
{
    public function getByUser(int $userId);
    public function findWithRelations(int $id, array $relations = []);
    public function create(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function attachSkills(int $offreId, array $skillIds);
    public function syncLanguages(int $offreId, array $languageData);
}"
voici le fichier Interfaces/Repositories/ResumeRepositoryInterface.php : 
"<?php


namespace App\Interfaces\Repositories;

interface ResumeRepositoryInterface
{
    public function createForUser(int $userId, array $data);
    public function updateResume(int $id, array $data);
    public function deleteResume(int $id);
    public function findUserResume(int $userId);
    public function findById(int $id);
}


"
voici le fichier Interfaces/Servises/OffreServiceInterface.php : 
"<?php


namespace App\Interfaces\Services;

interface OffreServiceInterface
{
    public function getUserOffres(int $userId);
    public function getOffreWithRelations(int $id, int $userId);
    public function createOffre(array $data, int $userId);
    public function updateOffre(int $id, array $data, int $userId);
    public function deleteOffre(int $id, int $userId);
}"

voici le fichier Repositories/OffreRepository.php : 
"<?php


namespace App\Repositories;

use App\Interfaces\Repositories\OffreRepositoryInterface;
use App\Models\Offre;

class OffreRepository implements OffreRepositoryInterface
{
    public function getByUser(int $userId)
    {
        return Offre::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function findWithRelations(int $id, array $relations = [])
    {
        return Offre::with($relations)->findOrFail($id);
    }

    public function create(array $data)
    {
        return Offre::create($data);
    }

    public function update(int $id, array $data)
    {
        $offre = Offre::findOrFail($id);
        $offre->update($data);
        return $offre;
    }

    public function delete(int $id)
    {
        $offre = Offre::findOrFail($id);
        $offre->skills()->detach();
        $offre->languages()->detach();
        return $offre->delete();
    }

    public function attachSkills(int $offreId, array $skillIds)
    {
        $offre = Offre::findOrFail($offreId);
        $offre->skills()->sync($skillIds);
    }

    public function syncLanguages(int $offreId, array $languageData)
    {
        $offre = Offre::findOrFail($offreId);
        $offre->languages()->sync($languageData);
    }
}"
voici le fichier Repositories/ResumeRepository.php : 
"<?php

namespace App\Repositories;

use App\Interfaces\Repositories\ResumeRepositoryInterface;
use App\Models\Resume;

class ResumeRepository implements ResumeRepositoryInterface
{
    
    public function createForUser(int $userId, array $data)
    {
        return Resume::create(array_merge($data, ['user_id' => $userId]));
    }

    public function updateResume(int $id, array $data)
    {
        $resume = Resume::findOrFail($id);
        $resume->update($data);
        return $resume;
    }

    public function deleteResume(int $id)
    {
        Resume::destroy($id);
    }

    public function findUserResume(int $userId)
    {
        return Resume::where('user_id', $userId)->first();
    }

    public function findById(int $id)
    {
        return Resume::findOrFail($id);
    }

}
"

voici le fichier Providers/AppServiceProvider.php : 
"<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;

// Offres
use App\Interfaces\Repositories\OffreRepositoryInterface;
use App\Repositories\OffreRepository;
use App\Interfaces\Services\OffreServiceInterface;
use App\Services\OffreService;

// Resumes
use App\Interfaces\Repositories\ResumeRepositoryInterface;
use App\Repositories\ResumeRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Resumes
        $this->app->bind(
            ResumeRepositoryInterface::class,
            ResumeRepository::class
        );

        // Offres
        $this->app->bind(
            OffreRepositoryInterface::class,
            OffreRepository::class
        );
        
        $this->app->bind(
            OffreServiceInterface::class,
            OffreService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useTailwind();
    }
}
"

voici le fichier Services/LangueService.php : 
"<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class LangueService
{
    public static function fetchLangues()
    {
        $response = Http::get('https://restcountries.com/v3.1/all?fields=languages');

        if ($response->successful()) {
            $data = $response->json();
            $langues = [];

            foreach ($data as $country) {
                if (isset($country['languages'])) {
                    foreach ($country['languages'] as $code => $langue) {
                        $langues[$code] = $langue; 
                    }
                }
            }

            return array_values(array_unique($langues));
        }

        return [];
    }
}
"
voici le fichier Services/ManualMatchService.php : 
"<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Offre;
use Illuminate\Support\Facades\Cache;

class ManualMatchService
{
    public function calculate(int $resumeId, int $OfferId, array $weights): int
    {
        // $cacheKey = "manual_match_{$resumeId}_{$OfferId}_" . md5(json_encode($weights));
        
        // return Cache::remember($cacheKey, now()->addHours(1), function() use ($resumeId, $OfferId, $weights) {
            $resume = Resume::with(['skills', 'languages', 'experiences'])->findOrFail($resumeId);
            $Offre = Offre::with(['skills', 'languages'])->findOrFail($OfferId);

            $skillsScore = $this->calculateSkillsScore($resume, $Offre);
            $languagesScore = $this->calculateLanguagesScore($resume, $Offre);
            $experienceScore = $this->calculateExperienceScore($resume, $Offre);
            $locationScore = $this->calculateLocationScore($resume, $Offre);

            $totalScore = (
                ($skillsScore * $weights['skills']) +
                ($languagesScore * $weights['languages']) +
                ($experienceScore * $weights['experience']) +
                ($locationScore * $weights['location'])
            ) * 100;

            return min(100, max(0, (int) round($totalScore)));
        // });
    }

    protected function calculateSkillsScore(Resume $resume, Offre $Offre): float
    {
        $requiredSkills = $Offre->skills->pluck('id')->toArray();
        
        if (empty($requiredSkills)) {
            return 1.0;
        }

        $userSkills = $resume->skills->pluck('id')->toArray();
        $matchingSkills = array_intersect($requiredSkills, $userSkills);

        return count($matchingSkills) / count($requiredSkills);
    }

    protected function calculateLanguagesScore(Resume $resume, Offre $Offre): float
    {
        $requiredLanguages = $Offre->languages->mapWithKeys(function($lang) {
            return [$lang->id => strtolower($lang->pivot->level)];
        });

        if ($requiredLanguages->isEmpty()) {
            return 1.0;
        }

        $userLanguages = $resume->languages->mapWithKeys(function($lang) {
            return [$lang->id => strtolower($lang->pivot->level)];
        });

        $scores = [];
        $levelWeights = [
            'débutant' => 0.3,
            'intermédiaire' => 0.6,
            'avancé' => 0.8,
            'courant' => 1.0,
            'bilingue' => 1.2
        ];

        foreach ($requiredLanguages as $langId => $requiredLevel) {
            if ($userLanguages->has($langId)) {
                $userLevel = $userLanguages->get($langId);
                $requiredWeight = $levelWeights[$requiredLevel] ?? 0.6;
                $userWeight = $levelWeights[$userLevel] ?? 0.3;
                
                $scores[] = min(1.0, $userWeight / $requiredWeight);
            } else {
                $scores[] = 0;
            }
        }

        return array_sum($scores) / count($scores);
    }

    protected function calculateExperienceScore(Resume $resume, Offre $Offre): float
    {
        $requiredExperience = $Offre->experience;
        $userExperience = $resume->experiences->sum(function($exp) {
            return $exp->end_date 
                ? $exp->start_date->diffInYears($exp->end_date)
                : $exp->start_date->diffInYears(now());
        });

        if ($requiredExperience <= 0) {
            return 1.0;
        }

        if ($userExperience >= $requiredExperience) {
            return 1.0;
        }

        return min(1.0, $userExperience / $requiredExperience);
    }

    protected function calculateLocationScore(Resume $resume, Offre $Offre): float
    {
        if (strtolower($resume->ville) === strtolower($Offre->location)) {
            return 1.0;
        }

        if ($resume->relocation_possible) {
            if (strtolower($resume->pays) === strtolower($Offre->pays)) {
                return 0.8;
            }
            return 0.6;
        }

        if (strtolower($Offre->mode_travail) === 'remote') {
            return 0.9;
        }

        return 0;
    }
}
"
voici le fichier Services/MatchService.php : 
"<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Offre;
use App\Models\MatchingPreference;
use Illuminate\Support\Facades\Cache;

class MatchService
{
    public function __construct(
        private ManualMatchService $manualService,
        private OpenAIMatchService $aiService,
        private OpenAIDataPreparer $dataPreparer
    ) {}

    public function calculate(Resume $resume, Offre $offer): int
    {
        // $cacheKey = "match_{$resume->id}_{$offer->id}";
        
        // return Cache::remember($cacheKey, now()->addHours(1), function() use ($resume, $offer) {
            $preferences = $offer->matchingPreference;

            if ($preferences && $preferences->use_ai) {
                try {
                    $data = $this->dataPreparer->prepare($resume, $offer);
                    $result = $this->aiService->calculate($data);
                    dd(hhhhhhh);
                    return $this->aiService->calculate($data);
                } catch (\Exception $e) {
                    $weights = MatchingPreference::defaultWeights();
                    return $this->manualService->calculate($resume->id, $offer->id, $weights);
                }
            }

            $weights = $preferences ? [
                'skills' => $preferences->skills_weight ?? MatchingPreference::defaultWeights()['skills'],
                'languages' => $preferences->languages_weight ?? MatchingPreference::defaultWeights()['languages'],
                'experience' => $preferences->experience_weight ?? MatchingPreference::defaultWeights()['experience'],
                'location' => $preferences->location_weight ?? MatchingPreference::defaultWeights()['location'],
            ] : MatchingPreference::defaultWeights();

            return $this->manualService->calculate($resume->id, $offer->id, $weights);
        // });
    }
}
"
voici le fichier Services/OffreService.php : 
"<?php


namespace App\Services;

use App\Interfaces\Repositories\OffreRepositoryInterface;
use App\Interfaces\Services\OffreServiceInterface;
use Illuminate\Support\Facades\DB;

class OffreService implements OffreServiceInterface
{
    public function __construct(
        private OffreRepositoryInterface $offreRepository
    ) {}

    public function getUserOffres(int $userId)
    {
        return $this->offreRepository->getByUser($userId);
    }

    public function getOffreWithRelations(int $id, int $userId)
    {
        $offre = $this->offreRepository->findWithRelations($id, ['skills', 'languages', 'user']);
        
        if ($offre->user_id !== $userId) {
            throw new \Exception('Unauthorized access to this offer');
        }

        return $offre;
    }

    public function createOffre(array $data, int $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $offreData = array_merge($data, ['user_id' => $userId]);
            $offre = $this->offreRepository->create($offreData);
            
            $this->offreRepository->attachSkills($offre->id, $data['skill_ids']);
            
            $languageData = [];
            if (isset($data['language_ids']) && isset($data['language_levels'])) {
                foreach ($data['language_ids'] as $index => $languageId) {
                    $languageData[$languageId] = ['level' => $data['language_levels'][$index] ?? 'débutant'];
                }
                $this->offreRepository->syncLanguages($offre->id, $languageData);
            }

            return $offre;
        });
    }

    public function updateOffre(int $id, array $data, int $userId)
    {
        return DB::transaction(function () use ($id, $data, $userId) {
            $offre = $this->offreRepository->findWithRelations($id);
            
            if ($offre->user_id !== $userId) {
                throw new \Exception('Unauthorized access to this offer');
            }

            // Gestion du statut
            if ($data['statut'] === 'publiée') {
                $data['statut'] = 'en attente';
            }

            $this->offreRepository->update($id, $data);
            $this->offreRepository->attachSkills($id, $data['skill_ids']);
            
            $languageData = [];
            if (!empty($data['language_ids'])) {
                foreach ($data['language_ids'] as $index => $languageId) {
                    $languageData[$languageId] = ['level' => $data['language_levels'][$index] ?? 'débutant'];
                }
                $this->offreRepository->syncLanguages($id, $languageData);
            }

            return $offre;
        });
    }

    public function deleteOffre(int $id, int $userId)
    {
        return DB::transaction(function () use ($id, $userId) {
            $offre = $this->offreRepository->findWithRelations($id);
            
            if ($offre->user_id !== $userId) {
                throw new \Exception('Unauthorized access to this offer');
            }

            return $this->offreRepository->delete($id);
        });
    }
    
}
"
voici le fichier Services/OpenAIDataPreparer.php : 
"<?php

namespace App\Services;

use App\Models\Resume;
use App\Models\Offre;

class OpenAIDataPreparer
{
    public function prepare(Resume $resume, Offre $offre): array
    {
        return [
            'resume' => [
                'skills' => $resume->skills->pluck('name')->toArray(),
                'languages' => $resume->languages->map(function($lang) {
                    return [
                        'name' => $lang->name,
                        'level' => $lang->pivot->level
                    ];
                })->toArray(),
                'experience' => $resume->experiences->sum(function($exp) {
                    return $exp->end_date 
                        ? $exp->start_date->diffInYears($exp->end_date)
                        : $exp->start_date->diffInYears(now());
                }),
                'location' => [
                    'city' => $resume->ville,
                    'country' => $resume->pays,
                    'relocation' => $resume->relocation_possible
                ]
            ],
            'offre' => [
                'requirements' => [
                    'skills' => $offre->skills->pluck('name')->toArray(),
                    'languages' => $offre->languages->map(function($lang) {
                        return [
                            'name' => $lang->name,
                            'level' => $lang->pivot->level
                        ];
                    })->toArray(),
                    'experience' => $offre->experience,
                    'location' => $offre->location,
                    'work_mode' => $offre->mode_travail
                ]
            ]
        ];
    }
}
"
voici le fichier Services/OpenAIMatchService.php : 
"<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class OpenAIMatchService
{

    public function calculate(array $data): int
    {
        // $cacheKey = "ai_match_" . md5(json_encode($data));
        
        // return Cache::remember($cacheKey, now()->addHours(6), function() use ($data) {
            $prompt = $this->generatePrompt($data);

            $response = Http::withHeaders([
                'Authorization' => 'Bearer '.config('services.openai.key'),
                'Content-Type' => 'application/json'
            ])->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are an HR expert. Reply only with a number between 0-100.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.2,
                'max_tokens' => 5
            ]);

            $responseData = $response->json();

            if (!isset($responseData['choices'][0]['message']['content'])) {
                throw new \Exception("Invalid OpenAI API response format");
            }

            return $this->parseResponse($responseData);
        // });
    }

    protected function generatePrompt(array $data): string
    {
        $resume = $data['resume'];
        $offer = $data['offre'];

        $prompt = "Calculate matching score (0-100) between candidate and job:\n\n";
        $prompt .= "Candidate Skills: " . implode(', ', $resume['skills']) . "\n";
        $prompt .= "Candidate Languages:\n";

        foreach ($resume['languages'] as $lang) {
            $prompt .= "- {$lang['name']} ({$lang['level']})\n";
        }
        $prompt .= "Total Experience: {$resume['experience']} years\n";
        $prompt .= "Location: {$resume['location']['city']}, {$resume['location']['country']}";
        $prompt .= $resume['location']['relocation'] ? " (open to relocate)\n\n" : "\n\n";

        $prompt .= "Job Requirements:\n";
        $prompt .= "Required Skills: " . implode(', ', $offer['requirements']['skills']) . "\n";
        $prompt .= "Required Languages:\n";
        
        foreach ($offer['requirements']['languages'] as $lang) {
            $prompt .= "- {$lang['name']} ({$lang['level']})\n";
        }
        $prompt .= "Required Experience: {$offer['requirements']['experience']} years\n";
        $prompt .= "Location: {$offer['requirements']['location']}\n";
        $prompt .= "Work Mode: {$offer['requirements']['work_mode']}\n\n";
        $prompt .= "Provide only the matching score (0-100) based on these factors:";

        return $prompt;
    }

    protected function parseResponse($response): int
    {
        if (!isset($response['choices'][0]['message']['content'])) {
            throw new \Exception("Invalid OpenAI API response structure");
        }
        $score = (int) trim($response->choices[0]->message->content);
        return min(100, max(0, $score));
    }
}
"

voici le fichier routes/web.php : 
"<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobApprovalController;
use App\Http\Controllers\Admin\UserManagementController;



use App\Http\Controllers\Recruiter\CompanyController;
use App\Http\Controllers\Recruiter\OffresController;
use App\Http\Controllers\Recruiter\ProfilRecruterController;
use App\Http\Controllers\Recruiter\SkillOffreController;
use App\Http\Controllers\Recruiter\MatchingPreferenceController;



use App\Http\Controllers\Candidat\ProfilCandidatController;
use App\Http\Controllers\Candidat\CvController;
use App\Http\Controllers\Candidat\WorkbridgeCVController;
use App\Http\Controllers\Candidat\ExperienceController;
use App\Http\Controllers\Candidat\EducationController;
use App\Http\Controllers\Candidat\SkillController ;
use App\Http\Controllers\Candidat\LanguageController;
use App\Http\Controllers\Candidat\JobController;
use App\Http\Controllers\Candidat\CondidatureController;





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
    
    
    // affichier details d'une offres
    Route::get('/candidat/offres/{id}', [JobController::class, 'getOfferDetails'])->name('candidat.offres.details');

    //affichier les offres
    Route::get('/candidat/offres', [JobController::class, 'index'])->name('candidat.offres.index');

    // application
    Route::post('/candidat/offres/{id}/postuler', [CondidatureController::class, 'postuler'])->name('candidat.offres.postuler');

});

// routes pour le profil de candidat
Route::middleware(['auth'])->group(function () {

    Route::get('/profil/candidat', [ProfilCandidatController::class, 'showProfil'])->name('profil.candidat');

    Route::get('/profil/candidat/resume', [ProfilCandidatController::class, 'showResume'])->name('resume.view');

    Route::resource('cv', CvController::class)->except(['index']);

    Route::resource('resume', WorkbridgeCVController::class)->except(['index']);

    Route::resource('resumes.experiences', ExperienceController::class)->except(['index', 'show']);

    Route::resource('education', EducationController::class)->except(['index', 'show']);

    Route::resource('resumes.skills', SkillController::class)->except(['index', 'show']);

    Route::resource('resumes.language', LanguageController::class)->except(['index', 'show']);

});

// routes pour le profil de recruiter
Route::middleware(['auth'])->group(function () {
    
    Route::resource('company', CompanyController::class);

    Route::get('recruiter', [OffresController::class, 'create'])->name('recruiter')->middleware(['auth', 'check.company']);
    
    Route::get('/recruiter/profile', [ProfilRecruterController::class, 'showProfile'])->name('recruiter.profile');
    
    Route::resource('recruiter/offers', OffresController::class);
    
    Route::resource('offres.skills', SkillController::class)->except(['index', 'show']);
    Route::resource('offres.language', SkillController::class)->except(['index', 'show']);

    Route::get('/preference', [OffresController::class, 'create'])->name('preference.index');

    // Routes pour les préférences de matching
    Route::get('/offers/{offreId}/preferences', [MatchingPreferenceController::class, 'index'])->name('preference.index');
    Route::post('/offers/{offreId}/preferences', [MatchingPreferenceController::class, 'storePreference'])->name('preference.store');
});




// routes d'admine
// Route::middleware(['auth'])->group(function () {

    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/UserManagement', [UserManagementController::class, 'index'])->name('admin.UserManagement');
    Route::put('/admin/UserManagement/{recruiter}/suspend', [UserManagementController::class, 'suspend'])->name('admin.UserManagement.suspend');
    Route::put('/admin/UserManagement/{recruiter}/activate', [UserManagementController::class, 'activate'])->name('admin.UserManagement.activate');
    Route::delete('/admin/UserManagement/{recruiter}/destroy', [UserManagementController::class, 'destroy'])->name('admin.UserManagement.destroy');

    Route::get('/admin/JobApproval', [JobApprovalController::class, 'index'])->name('admin.JobApproval');
    Route::post('/admin/JobApproval/{job}/approve', [JobApprovalController::class, 'approve'])->name('admin.JobApproval.approve');
    Route::post('/admin/JobApproval/{job}/reject', [JobApprovalController::class, 'reject'])->name('admin.JobApproval.reject');

// });




Route::get('/', function () {
    return view('welcome');
});
"

voici le fichier views/admin/dashboard.blade.php : 
"@extends('layouts.admin')

@section('title', 'Tableau de bord administrateur')

@section('header-title', 'Tableau de bord')

@section('styles')
<style>
    .stats-card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .stats-icon {
        width: 3rem;
        height: 3rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 1rem;
    }
    
    .stats-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    
    .stats-label {
        font-size: 0.875rem;
        color: #6b7280;
        font-weight: 500;
    }
    
    .chart-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .chart-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    
    .recent-activity {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-top: 2rem;
    }
    
    .activity-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    
    .activity-item {
        padding: 1rem 0;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .activity-item:last-child {
        border-bottom: none;
    }
    
    .activity-icon {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .activity-content {
        flex: 1;
    }
    
    .activity-message {
        font-weight: 500;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }
    
    .activity-time {
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-blue {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .badge-green {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .badge-yellow {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .badge-red {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .badge-purple {
        background-color: #ede9fe;
        color: #5b21b6;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
        <!-- Total Users -->
        <div class="stats-card">
            <div class="stats-icon bg-blue-100 text-blue-600">
                <i class="fas fa-users"></i>
            </div>
            <div class="stats-value">{{ $totalUsers }}</div>
            <div class="stats-label">Utilisateurs totaux</div>
        </div>
        
        <!-- Total Recruiters -->
        <div class="stats-card">
            <div class="stats-icon bg-green-100 text-green-600">
                <i class="fas fa-user-tie"></i>
            </div>
            <div class="stats-value">{{ $totalRecruiters }}</div>
            <div class="stats-label">Recruteurs</div>
        </div>
        
        <!-- Total Candidates -->
        <div class="stats-card">
            <div class="stats-icon bg-purple-100 text-purple-600">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="stats-value">{{ $totalCandidates }}</div>
            <div class="stats-label">Candidats</div>
        </div>
        
        <!-- Total Jobs -->
        <div class="stats-card">
            <div class="stats-icon bg-yellow-100 text-yellow-600">
                <i class="fas fa-briefcase"></i>
            </div>
            <div class="stats-value">{{ $totalJobs }}</div>
            <div class="stats-label">Offres d'emploi</div>
        </div>
        
        <!-- Pending Jobs -->
        <div class="stats-card">
            <div class="stats-icon bg-red-100 text-red-600">
                <i class="fas fa-clock"></i>
            </div>
            <div class="stats-value">{{ $pendingJobs }}</div>
            <div class="stats-label">Offres en attente</div>
            @if($pendingJobs > 0)
                <a href="{{ route('admin.dashboard') }}" class="mt-2 inline-block text-sm text-blue-600 hover:text-blue-800">
                    Voir les offres en attente →
                </a>
            @endif
        </div>
    </div>
    
    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-8">
        <!-- User Registration Chart -->
        <div class="chart-container">
            <h3 class="chart-title">Inscriptions mensuelles</h3>
            <canvas id="registrationChart" height="300"></canvas>
        </div>
        
        <!-- Job Postings Chart -->
        <div class="chart-container">
            <h3 class="chart-title">Offres d'emploi publiées</h3>
            <canvas id="jobsChart" height="300"></canvas>
        </div>
    </div>
    
    <!-- Recent Activity -->
    
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@endsection

"
voici le fichier views/admin/jobapproval.blade.php : 
"@extends('layouts.admin')

@section('title', 'Approbation des offres d\'emploi')

@section('header-title', 'Approbation des offres d\'emploi')

@section('styles')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .table-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .jobs-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .jobs-table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 500;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .jobs-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    
    .jobs-table tr:last-child td {
        border-bottom: none;
    }
    
    .jobs-table tr:hover {
        background-color: #f9fafb;
    }
    
    .sortable {
        cursor: pointer;
        position: relative;
    }
    
    .sortable::after {
        content: '↕';
        position: absolute;
        right: 0.5rem;
        color: #9ca3af;
    }
    
    .badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .badge-yellow {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .btn-approve {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #10B981;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
        margin-right: 0.5rem;
    }
    
    .btn-approve:hover {
        background-color: #059669;
    }
    
    .btn-reject {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #EF4444;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-reject:hover {
        background-color: #DC2626;
    }
    
    .btn-view {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 0.5rem;
    }
    
    .btn-view:hover {
        background-color: #e5e7eb;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
    
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 100;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.5);
    }
    
    .modal-content {
        background-color: white;
        margin: 10% auto;
        padding: 1.5rem;
        border-radius: 0.5rem;
        max-width: 500px;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    .modal-close {
        font-size: 1.5rem;
        font-weight: 700;
        color: #9ca3af;
        cursor: pointer;
    }
    
    .modal-close:hover {
        color: #1f2937;
    }
    
    .modal-body {
        margin-bottom: 1.5rem;
    }
    
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }
    
    .form-group {
        margin-bottom: 1rem;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    
    .form-textarea {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        resize: vertical;
    }
    
    .form-textarea:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .pagination-container {
        margin-top: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto">
    <!-- Header -->
    <div class="header-container">
        <h1 class="text-2xl font-bold text-gray-900">Offres d'emploi en attente d'approbation</h1>
    </div>
    
    <!-- Table -->
    <div class="table-container">
        @if(count($pendingJobs) > 0)
            <table class="jobs-table">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="title">Intitulé du poste</th>
                        <th>Entreprise</th>
                        <th class="sortable" data-sort="created_at">Date de soumission</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingJobs as $job)
                        <tr>
                            <td>
                                <div class="font-medium">{{ $job->title }}</div>
                                <div class="text-sm text-gray-500">{{ $job->location }}</div>
                            </td>
                            <td>
                                <div class="font-medium">{{ $job->user->company->name ?? 'Entreprise non spécifiée' }}</div>
                                <div class="text-sm text-gray-500">{{ $job->user->name ?? 'Utilisateur inconnu'}}</div>
                            </td>
                            <td>
                                {{ $job->created_at->format('d/m/Y H:i') }}
                                <div class="text-sm text-gray-500">{{ $job->created_at->diffForHumans() }}</div>
                            </td>
                            <td>
                                <span class="badge badge-yellow">En attente</span>
                            </td>
                            <td>
                                <div class="flex">
                                    <a href="{{ route('admin.JobApproval', $job->id) }}" class="btn-view">
                                        <i class="fas fa-eye mr-2"></i> Voir
                                    </a>
                                    <form action="{{ route('admin.JobApproval.approve', $job->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-approve">
                                            <i class="fas fa-check mr-2"></i> Approuver
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.JobApproval.reject', $job->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="btn-reject">
                                            <i class="fas fa-times  mr-2"></i> Rejeter
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3 class="text-lg font-medium mb-2">Aucune offre en attente</h3>
                <p>Toutes les offres d'emploi ont été traitées.</p>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if(count($pendingJobs) > 0)
        <div class="pagination-container">
            {{ $pendingJobs->links() }}
        </div>
    @endif
    
    <!-- Approve Modal -->
    <div id="approve-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Approuver l'offre d'emploi</h2>
                <span class="modal-close" onclick="closeModal('approve-modal')">&times;</span>
            </div>
            <form id="approve-form" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir approuver cette offre d'emploi ? Elle sera publiée et visible par tous les candidats.</p>
                    
                    <div class="form-group mt-4">
                        <label for="approve-comment" class="form-label">Commentaire (optionnel)</label>
                        <textarea id="approve-comment" name="comment" class="form-textarea" rows="3" placeholder="Ajouter un commentaire pour le recruteur..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-view" onclick="closeModal('approve-modal')">Annuler</button>
                    <button type="submit" class="btn-approve">Approuver</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Reject Modal -->
    <div id="reject-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="modal-title">Rejeter l'offre d'emploi</h2>
                <span class="modal-close" onclick="closeModal('reject-modal')">&times;</span>
            </div>
            <form id="reject-form" method="POST" action="">
                @csrf
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir rejeter cette offre d'emploi ? Elle ne sera pas publiée.</p>
                    
                    <div class="form-group mt-4">
                        <label for="reject-reason" class="form-label">Motif du rejet <span class="text-red-500">*</span></label>
                        <textarea id="reject-reason" name="reason" class="form-textarea" rows="3" placeholder="Expliquez pourquoi cette offre est rejetée..." required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-view" onclick="closeModal('reject-modal')">Annuler</button>
                    <button type="submit" class="btn-reject">Rejeter</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection


"
voici le fichier views/admin/usermanagement.blade.php : 
"@extends('layouts.admin')

@section('title', 'Gestion des recruteurs')

@section('header-title', 'Gestion des recruteurs')

@section('styles')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .search-container {
        display: flex;
        margin-left: auto;
    }
    
    .search-input {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem 0 0 0.375rem;
        min-width: 250px;
    }
    
    .search-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        border-left: none;
        border-radius: 0 0.375rem 0.375rem 0;
        padding: 0 0.75rem;
        cursor: pointer;
    }
    
    .search-button:hover {
        background-color: #e5e7eb;
    }
    
    .table-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .users-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .users-table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 500;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .users-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    
    .users-table tr:last-child td {
        border-bottom: none;
    }
    
    .users-table tr:hover {
        background-color: #f9fafb;
    }
    
    .sortable {
        cursor: pointer;
        position: relative;
    }
    
    .sortable::after {
        content: '↕';
        position: absolute;
        right: 0.5rem;
        color: #9ca3af;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-active {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-suspended {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem 1rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
        font-size: 0.875rem;
    }
    
    .btn-sm {
        padding: 0.25rem 0.75rem;
        font-size: 0.75rem;
    }
    
    .btn-primary {
        background-color: #4f46e5;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #4338ca;
    }
    
    .btn-danger {
        background-color: #ef4444;
        color: white;
    }
    
    .btn-danger:hover {
        background-color: #dc2626;
    }
    
    .btn-warning {
        background-color: #f59e0b;
        color: white;
    }
    
    .btn-warning:hover {
        background-color: #d97706;
    }
    
    .btn-success {
        background-color: #10b981;
        color: white;
    }
    
    .btn-success:hover {
        background-color: #059669;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }
    
    .user-info {
        display: flex;
        align-items: center;
    }
    
    .user-avatar {
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        background-color: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-weight: bold;
        color: #4f46e5;
    }
    
    .pagination-container {
        margin-top: 1.5rem;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto py-6 px-4">
    <!-- Header -->
    <div class="header-container">
        <h1 class="text-2xl font-bold text-gray-900">Gestion des recruteurs</h1>
        
        <div class="search-container">
            <input type="text" class="search-input" id="search-input" placeholder="Rechercher des recruteurs..." value="{{ request('search') }}">
            <button class="search-button" id="search-button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    
    <!-- Table -->
    <div class="table-container">
        @if(count($recruiters) > 0)
            <table class="users-table">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="name">Nom / Entreprise</th>
                        <th>Email</th>
                        <th class="sortable" data-sort="created_at">Date d'inscription</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recruiters as $recruiter)
                        <tr>
                            <td>
                                <div class="user-info">
                                    <div class="user-avatar">
                                        @if($recruiter->avatar)
                                            <img src="{{ asset('storage/' . $recruiter->avatar) }}" alt="{{ $recruiter->name }}" class="w-full h-full object-cover rounded-full">
                                        @else
                                            {{ substr($recruiter->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <div class="font-medium">{{ $recruiter->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $recruiter->company->name ?? 'Aucune entreprise' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $recruiter->email }}</td>
                            <td>{{ $recruiter->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($recruiter->statut == 'active')
                                    <span class="statut-badge statut-active">Actif</span>
                                @elseif($recruiter->statut == 'suspended')
                                    <span class="statut-badge statut-suspended">Suspendu</span>
                                @elseif($recruiter->statut == 'en attente')
                                    <span class="statut-badge statut-pending">En attente</span>
                                @else
                                    <span class="statut-badge">{{ $recruiter->statut }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    @if($recruiter->statut == 'active')
                                        <form action="{{ route('admin.UserManagement.suspend', $recruiter->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-warning" onclick="return confirm('Êtes-vous sûr de vouloir suspendre ce compte ?')">
                                                <i class="fas fa-ban mr-1"></i> Suspendre
                                            </button>
                                        </form>
                                    @elseif($recruiter->statut == 'suspended' || $recruiter->statut == 'pending')
                                        <form action="{{ route('admin.UserManagement.activate', $recruiter->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-success">
                                                <i class="fas fa-check mr-1"></i> Activer
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('admin.UserManagement.destroy', $recruiter->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce compte ? Cette action est irréversible.')">
                                            <i class="fas fa-trash-alt mr-1"></i> Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <h3 class="text-lg font-medium mb-2">Aucun recruteur trouvé</h3>
                <p class="mb-4">Aucun recruteur ne correspond à vos critères de recherche.</p>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if(count($recruiters) > 0)
        <div class="pagination-container">
            {{ $recruiters->links() }}
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
    // Handle search
    document.getElementById('search-button').addEventListener('click', function() {
        const searchValue = document.getElementById('search-input').value;
        
        let url = '{{ route("admin.UserManagement") }}?';
        if (searchValue) {
            url += 'search=' + encodeURIComponent(searchValue);
        }
        
        window.location.href = url;
    });
    
    // Handle enter key in search input
    document.getElementById('search-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('search-button').click();
        }
    });
    
    // Handle sorting
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sort = this.dataset.sort;
            const currentSort = new URLSearchParams(window.location.search).get('sort') || '';
            const currentDirection = new URLSearchParams(window.location.search).get('direction') || 'asc';
            
            let direction = 'asc';
            if (sort === currentSort && currentDirection === 'asc') {
                direction = 'desc';
            }
            
            const searchValue = document.getElementById('search-input').value;
            
            let url = '{{ route("admin.UserManagement") }}?sort=' + sort + '&direction=' + direction;
            
            if (searchValue) {
                url += '&search=' + encodeURIComponent(searchValue);
            }
            
            window.location.href = url;
        });
    });
</script>
@endsection

"

voici le fichier views/auth/login.blade.php : 
"@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white py-8 px-6 shadow-md rounded-lg auth-card">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Sign in to your account</h2>
            <p class="mt-2 text-sm text-gray-600">
                Or
                <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    create a new account
                </a>
            </p>
        </div>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-sm text-red-600 rounded-md p-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('loginUser') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email address
                </label>
                <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}" 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>
                <input id="password" name="password" type="password" autocomplete="current-password" required 
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                    <label for="remember_me" class="ml-2 block text-sm text-gray-900">
                        Remember me
                    </label>
                </div>

                @if (Route::has('password.request'))
                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                            Forgot your password?
                        </a>
                    </div>
                @endif
            </div>

            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Sign in
                </button>
            </div>
        </form>

        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">
                        Or continue with
                    </span>
                </div>
            </div>

            <div class="mt-6 grid grid-cols-2 gap-3">
                <div>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fab fa-google mr-2"></i>
                        Google
                    </a>
                </div>

                <div>
                    <a href="#" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                        <i class="fab fa-linkedin mr-2"></i>
                        LinkedIn
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

"
voici le fichier views/auth/register.blade.php : 
"@extends('layouts.auth')

@section('title', 'Inscription')

@section('styles')
<style>
    .role-btn {
        transition: all 0.3s ease;
        transform: translateY(0);
    }
    .role-btn:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    .role-btn.active {
        background-color: #4f46e5;
        color: white;
        border-color: #4f46e5;
    }
    .form-step {
        display: none;
    }
    .form-step.active {
        display: block;
        animation: fadeIn 0.5s ease-in-out;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .input-field {
        transition: all 0.3s ease;
    }
    .input-field:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        display: none;
    }
</style>
@endsection

@section('content')
<div class="w-full max-w-md">
    <div class="bg-white py-8 px-6 shadow-xl rounded-xl">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Créer votre compte</h2>
            <p class="mt-2 text-sm text-gray-600">
                Vous avez déjà un compte?
                <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Connectez-vous
                </a>
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-sm text-red-600 rounded-md p-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('store') }}" id="register-form" class="space-y-6">
            @csrf
            <input type="hidden" id="role_id" name="role_id" value="{{ old('role_id') }}">

            <!-- Étape 1: Sélection du rôle -->
            <div id="step-1" class="form-step {{ old('role_id') ? '' : 'active' }}">
                <div class="text-center mb-6">
                    <h3 class="text-lg font-medium text-gray-900">Qui êtes-vous?</h3>
                    <p class="text-sm text-gray-500 mt-1">Sélectionnez votre rôle pour commencer</p>
                </div>
                
                <div class="grid grid-cols-2 gap-6 mt-8">
                    <button type="button" id="candidate-btn" class="role-btn flex flex-col items-center justify-center p-6 border-2 border-gray-200 rounded-xl bg-white hover:border-indigo-500 {{ old('role_id') == '2' ? 'active' : '' }}">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-user-tie text-indigo-600 text-2xl"></i>
                        </div>
                        <span class="font-medium text-lg">Candidat</span>
                        <span class="text-sm text-gray-500 mt-1">Je cherche un emploi</span>
                    </button>
                    <button type="button" id="recruiter-btn" class="role-btn flex flex-col items-center justify-center p-6 border-2 border-gray-200 rounded-xl bg-white hover:border-indigo-500 {{ old('role_id') == '3' ? 'active' : '' }}">
                        <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                            <i class="fas fa-building text-indigo-600 text-2xl"></i>
                        </div>
                        <span class="font-medium text-lg">Recruteur</span>
                        <span class="text-sm text-gray-500 mt-1">Je recrute des talents</span>
                    </button>
                </div>
            </div>

            <!-- Étape 2: Formulaire d'inscription -->
            <div id="step-2" class="form-step {{ old('role_id') ? 'active' : '' }}">
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <button type="button" id="back-btn" class="text-indigo-600 hover:text-indigo-800 mr-2">
                            <i class="fas fa-arrow-left"></i>
                        </button>
                        <h3 class="text-lg font-medium text-gray-900" id="role-title">Inscription</h3>
                    </div>
                    <div id="role-badge" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ old('role_id') == '3' ? 'bg-purple-100 text-purple-800' : 'bg-indigo-100 text-indigo-800' }}">
                        <i class="fas {{ old('role_id') == '3' ? 'fa-building' : 'fa-user-tie' }} mr-2"></i>
                        <span id="role-text">{{ old('role_id') == '3' ? 'Recruteur' : 'Candidat' }}</span>
                    </div>
                </div>

                <!-- Nom complet -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                        Nom complet
                    </label>
                    <input id="name" name="name" type="text" required value="{{ old('name') }}"
                        class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="name-error" class="error-message">Veuillez entrer votre nom complet</div>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Adresse email
                    </label>
                    <input id="email" name="email" type="email" required value="{{ old('email') }}"
                        class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="email-error" class="error-message">Veuillez entrer une adresse email valide</div>
                </div>

                <!-- Mot de passe -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                        Mot de passe
                    </label>
                    <input id="password" name="password" type="password" required
                        class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('password') border-red-500 @enderror">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div id="password-error" class="error-message">Le mot de passe doit contenir au moins 6 caractères</div>
                </div>

                <!-- Confirmation du mot de passe -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                        Confirmer le mot de passe
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                        class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none">
                    <div id="password-confirmation-error" class="error-message">Les mots de passe ne correspondent pas</div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                        Créer mon compte
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du DOM
        const roleInput = document.getElementById('role_id');
        const candidateBtn = document.getElementById('candidate-btn');
        const recruiterBtn = document.getElementById('recruiter-btn');
        const step1 = document.getElementById('step-1');
        const step2 = document.getElementById('step-2');
        const backBtn = document.getElementById('back-btn');
        const roleTitle = document.getElementById('role-title');
        const roleText = document.getElementById('role-text');
        const roleBadge = document.getElementById('role-badge');
        const form = document.getElementById('register-form');
        
        // Champs de formulaire et messages d'erreur
        const nameInput = document.getElementById('name');
        const emailInput = document.getElementById('email');
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        const nameError = document.getElementById('name-error');
        const emailError = document.getElementById('email-error');
        const passwordError = document.getElementById('password-error');
        const passwordConfirmError = document.getElementById('password-confirmation-error');
        
        // Fonction pour passer à l'étape 2
        function goToStep2(role, roleLabel) {
            console.log('Rôle sélectionné :', role);
            roleInput.value = role;
            step1.classList.remove('active');
            step2.classList.add('active');
            
            // Mettre à jour le titre et le badge
            roleTitle.textContent = `Inscription en tant que ${roleLabel}`;
            roleText.textContent = roleLabel;
            
            // Mettre à jour l'icône du badge
            const badgeIcon = roleBadge.querySelector('i');
            if (role === '2') { // Candidat
                badgeIcon.className = 'fas fa-user-tie mr-2';
                roleBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800';
            } else { // Recruteur
                badgeIcon.className = 'fas fa-building mr-2';
                roleBadge.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800';
            }
        }
        
        // Événements pour les boutons de rôle
        candidateBtn.addEventListener('click', function() {
            goToStep2('2', 'Candidat');
        });
        
        recruiterBtn.addEventListener('click', function() {
            goToStep2('3', 'Recruteur');
        });
        
        // Retour à l'étape 1
        backBtn.addEventListener('click', function() {
            step2.classList.remove('active');
            step1.classList.add('active');
            roleInput.value = '';
            
            // Réinitialiser les erreurs
            nameError.style.display = 'none';
            emailError.style.display = 'none';
            passwordError.style.display = 'none';
            passwordConfirmError.style.display = 'none';
        });
        
        // Validation du formulaire
        form.addEventListener('submit', function(event) {
            if (!roleInput.value) {
                event.preventDefault();
                alert('Veuillez sélectionner un rôle (Candidat ou Recruteur)');
                return;
            }
            
            // La validation côté serveur de Laravel prendra le relais
            // Mais nous pouvons ajouter une validation côté client pour une meilleure expérience utilisateur
            let isValid = true;
            
            // Validation du nom
            if (nameInput.value.trim() === '') {
                nameError.style.display = 'block';
                nameInput.classList.add('border-red-500');
                isValid = false;
            }
            
            // Validation de l'email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(emailInput.value)) {
                emailError.style.display = 'block';
                emailInput.classList.add('border-red-500');
                isValid = false;
            }
            
            // Validation du mot de passe
            if (passwordInput.value.length < 6) {
                passwordError.style.display = 'block';
                passwordInput.classList.add('border-red-500');
                isValid = false;
            }
            
            // Validation de la confirmation du mot de passe
            if (passwordInput.value !== passwordConfirmInput.value) {
                passwordConfirmError.style.display = 'block';
                passwordConfirmInput.classList.add('border-red-500');
                isValid = false;
            }
            
            if (!isValid) {
                event.preventDefault();
            }
        });
        
        // Validation en temps réel
        nameInput.addEventListener('input', function() {
            if (this.value.trim() !== '') {
                nameError.style.display = 'none';
                this.classList.remove('border-red-500');
            }
        });
        
        emailInput.addEventListener('input', function() {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (emailRegex.test(this.value)) {
                emailError.style.display = 'none';
                this.classList.remove('border-red-500');
            }
        });
        
        passwordInput.addEventListener('input', function() {
            if (this.value.length >= 6) {
                passwordError.style.display = 'none';
                this.classList.remove('border-red-500');
            }
            
            // Vérifier la correspondance avec la confirmation
            if (this.value === passwordConfirmInput.value) {
                passwordConfirmError.style.display = 'none';
                passwordConfirmInput.classList.remove('border-red-500');
            }
        });
        
        passwordConfirmInput.addEventListener('input', function() {
            if (this.value === passwordInput.value) {
                passwordConfirmError.style.display = 'none';
                this.classList.remove('border-red-500');
            }
        });
    });
</script>
@endsection

"

voici le fichier views/candidat/candidatresume.blade.php : 
"@extends('layouts.candidat')

@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 bg-white shadow-md rounded-lg">
    <div class="mb-6">
        <a href="{{ route('profil.candidat') }}" class="inline-flex items-center text-gray-700 hover:text-gray-900 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Retour</span>
        </a>
    </div>

    <!-- Informations personnelles -->
    <div class="mb-8 border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $resume->user->name }}</h1>
                <div class="mt-3 text-gray-600 space-y-2">
                    <p>{{ $resume->phone }}</p>
                    <p>{{ $resume->user->email }}</p>
                    <p>{{ $resume->ville }}, {{ $resume->pays }}</p>
                    <p>Né(e) le {{ \Carbon\Carbon::parse($resume->birthDate)->format('d/m/Y') }}</p>
                    <p>
                        @if($resume->relocation_possible)
                            Déménagement possible n'importe où
                        @else
                            Pas de déménagement possible
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('resume.edit', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Modifier">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </a>
                <form action="{{ route('resume.destroy', $resume->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre CV?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>    

    <!-- Expérience professionnelle -->
    <div class="mb-8 border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Expérience professionnelle</h2>
            <a href="{{ route('resumes.experiences.create', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Ajouter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a> 
                </svg>
            </a>
        </div>

        @if(count($resume->experiences) > 0)
            <div class="space-y-4">
                @foreach($resume->experiences as $experience)
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 relative">
                        <div class="absolute right-3 top-3 flex space-x-3">
                            <a href="{{ route('resumes.experiences.edit', [$resume->id, $experience->id]) }}" class="text-blue-800 hover:text-blue-600" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('resumes.experiences.destroy', [$resume->id, $experience->id]) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="pr-16">
                            <h3 class="font-semibold text-lg text-gray-800">{{ $experience->job_title }}</h3>
                            <p class="text-gray-600">{{ $experience->company_name }}</p>
                            <p class="text-gray-500 text-sm">
                                {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                                @if($experience->end_date)
                                    {{ \Carbon\Carbon::parse($experience->end_date)->format('M Y') }}
                                @else
                                    Actuellement
                                @endif
                            </p>
                            @if($experience->description)
                                <p class="mt-2 text-gray-700">{{ $experience->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500 bg-white rounded-lg shadow-sm border border-gray-200">
                <p>Aucune expérience professionnelle ajoutée</p>
            </div>
        @endif
    </div>

    <!-- Éducation -->
    <div class="mb-8 border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Éducation</h2>
            <a href="{{ route('education.create', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Ajouter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>

        @if(count($resume->education) > 0)
            <div class="space-y-4">
                @foreach($resume->education as $edu)
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 relative">
                        <div class="absolute right-3 top-3 flex space-x-3">
                            <a href="{{ route('education.update', $edu->id) }}" class="text-blue-800 hover:text-blue-600" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('education.delete', $edu->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="pr-16">
                            <h3 class="font-semibold text-lg text-gray-800">{{ $edu->degree }} en {{ $edu->field_of_study }}</h3>
                            <p class="text-gray-600">{{ $edu->institution_name }}</p>
                            <p class="text-gray-500 text-sm">
                                {{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - 
                                {{ \Carbon\Carbon::parse($edu->end_date)->format('Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500 bg-white rounded-lg shadow-sm border border-gray-200">
                <p>Aucune formation ajoutée</p>
            </div>
        @endif
    </div>

    <!-- Compétences -->
    <div class="mb-8 border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Compétences</h2>
            <a href="{{ route('resumes.skills.create', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Ajouter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>

        @if(count($resume->skills) > 0)
            <div class="flex flex-wrap gap-2">
                @foreach($resume->skills as $skill)
                    <div class="bg-white rounded-full px-4 py-2 shadow-sm border border-gray-200 flex items-center">
                        <span class="text-gray-700">{{ $skill->name }}</span>
                        <form action="{{ route('resumes.skills.destroy', ['resume' => $resume->id, 'skill' => $skill->id]) }}" method="POST" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500 bg-white rounded-lg shadow-sm border border-gray-200">
                <p>Aucune compétence ajoutée</p>
            </div>
        @endif
    </div>

    <!-- Langues -->
    <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Langues</h2>
            <a href="{{ route('resumes.language.create', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Ajouter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>

        @if(count($resume->languages) > 0)
            <div class="flex flex-wrap gap-2">
                @foreach($resume->languages as $language)
                    <div class="bg-white rounded-full px-4 py-2 shadow-sm border border-gray-200 flex items-center">
                        <span class="text-gray-700">{{ $language->name }}</span>
                        <form action="{{ route('resumes.language.destroy', ['resume' => $resume->id, 'language' => $language->id]) }}" method="POST" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500 bg-white rounded-lg shadow-sm border border-gray-200">
                <p>Aucune langue ajoutée</p>
            </div>
        @endif
    </div>
</div>
@endsection

"
voici le fichier views/candidat/experiencecreate.blade.php : 
"@extends('layouts.candidat')

@section('title', 'Ajouter une expérience professionnelle')

@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        border-color: #2557a7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 87, 167, 0.1);
    }
    
    .form-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #d1d5db;
        cursor: pointer;
    }
    
    .form-checkbox:checked {
        background-color: #2557a7;
        border-color: #2557a7;
    }
    
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #2557a7;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-save:hover {
        background-color: #1e4b8f;
    }
    
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 1rem;
    }
    
    .btn-cancel:hover {
        background-color: #e5e7eb;
    }
    
    .form-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        background-color: white;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Ajouter une expérience professionnelle</h1>
        <p class="mt-2 text-gray-600">Complétez les informations ci-dessous pour ajouter une expérience à votre CV.</p>
    </div>
    
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    
    <form action="{{ route('resumes.experiences.store', $resume->id) }}" method="POST">
        @csrf
        
        <div class="form-section">
            <h2 class="form-section-title">Détails de l'expérience</h2>
            
            <div class="form-group">
                <label for="job_title" class="form-label">Intitulé du poste</label>
                <input type="text" id="job_title" name="job_title" class="form-input" value="{{ old('job_title') }}" required>
                @error('job_title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="company_name" class="form-label">Nom de l'entreprise</label>
                <input type="text" id="company_name" name="company_name" class="form-input" value="{{ old('company_name') }}" required>
                @error('company_name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="start_date" class="form-label">Date de début</label>
                    <input type="date" id="start_date" name="start_date" class="form-input" value="{{ old('start_date') }}" required>
                    @error('start_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="end_date" class="form-label">Date de fin</label>
                    <input type="date" id="end_date" name="end_date" class="form-input" value="{{ old('end_date') }}">
                    <div class="flex items-center mt-2">
                        <input type="checkbox" id="current_job" name="current_job" class="form-checkbox" value="1" {{ old('current_job') ? 'checked' : '' }}>
                        <label for="current_job" class="ml-2 text-gray-700">Je travaille actuellement à ce poste</label>
                    </div>
                    @error('end_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">Description des responsabilités et réalisations</label>
                <textarea id="description" name="description" rows="4" class="form-input" placeholder="Décrivez vos principales responsabilités, réalisations et compétences utilisées...">{{ old('description') }}</textarea>
                <p class="form-help-text">Soyez concis et mettez en avant vos accomplissements les plus significatifs.</p>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end mt-8">
            <a href="{{ route('resume.view', $resume->id) }}" class="btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                Annuler
            </a>
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentJobCheckbox = document.getElementById('current_job');
        const endDateField = document.getElementById('end_date');
        
        // Fonction pour gérer l'état du champ de date de fin
        function toggleEndDateField() {
            if (currentJobCheckbox.checked) {
                endDateField.disabled = true;
                endDateField.value = '';
            } else {
                endDateField.disabled = false;
            }
        }
        
        // Initialiser l'état du champ
        toggleEndDateField();
        
        // Ajouter un écouteur d'événement pour le changement d'état de la case à cocher
        currentJobCheckbox.addEventListener('change', toggleEndDateField);
    });
</script>
@endsection

"
voici le fichier views/candidat/experienceedit.blade.php : 
"@extends('layouts.candidat')

@section('title', 'Modifier une expérience professionnelle')

@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        border-color: #2557a7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 87, 167, 0.1);
    }
    
    .form-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #d1d5db;
        cursor: pointer;
    }
    
    .form-checkbox:checked {
        background-color: #2557a7;
        border-color: #2557a7;
    }
    
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #2557a7;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-save:hover {
        background-color: #1e4b8f;
    }
    
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 1rem;
    }
    
    .btn-cancel:hover {
        background-color: #e5e7eb;
    }
    
    .form-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        background-color: white;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Modifier une expérience professionnelle</h1>
        <p class="mt-2 text-gray-600">Modifiez les informations ci-dessous pour mettre à jour cette expérience sur votre CV.</p>
    </div>
    
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    
    <form action="{{ route('resumes.experiences.update', ['resume' => $resume->id, 'experience' => $experience->id]) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-section">
            <h2 class="form-section-title">Détails de l'expérience</h2>
            
            <div class="form-group">
                <label for="job_title" class="form-label">Intitulé du poste</label>
                <input type="text" id="job_title" name="job_title" class="form-input" value="{{ old('job_title', $experience->job_title) }}" required>
                @error('job_title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="form-group">
                <label for="company_name" class="form-label">Nom de l'entreprise</label>
                <input type="text" id="company_name" name="company_name" class="form-input" value="{{ old('company_name', $experience->company_name) }}" required>
                @error('company_name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="start_date" class="form-label">Date de début</label>
                    <input type="date" id="start_date" name="start_date" class="form-input" value="{{ old('start_date', $experience->start_date) }}" required>
                    @error('start_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="end_date" class="form-label">Date de fin</label>
                    <input type="date" id="end_date" name="end_date" class="form-input" value="{{ old('end_date', $experience->end_date) }}">
                    <div class="flex items-center mt-2">
                        <input type="checkbox" id="current_job" name="current_job" class="form-checkbox" value="1" {{ old('current_job', $experience->current_job) ? 'checked' : '' }}>
                        <label for="current_job" class="ml-2 text-gray-700">Je travaille actuellement à ce poste</label>
                    </div>
                    @error('end_date')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="form-group">
                <label for="description" class="form-label">Description des responsabilités et réalisations</label>
                <textarea id="description" name="description" rows="4" class="form-input" placeholder="Décrivez vos principales responsabilités, réalisations et compétences utilisées...">{{ old('description', $experience->description) }}</textarea>
                <p class="form-help-text">Soyez concis et mettez en avant vos accomplissements les plus significatifs.</p>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end mt-8">
            <a href="{{ route('resume.view', $resume->id) }}" class="btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                Annuler
            </a>
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const currentJobCheckbox = document.getElementById('current_job');
        const endDateField = document.getElementById('end_date');
        
        // Fonction pour gérer l'état du champ de date de fin
        function toggleEndDateField() {
            if (currentJobCheckbox.checked) {
                endDateField.disabled = true;
                endDateField.value = '';
            } else {
                endDateField.disabled = false;
            }
        }
        
        // Initialiser l'état du champ
        toggleEndDateField();
        
        // Ajouter un écouteur d'événement pour le changement d'état de la case à cocher
        currentJobCheckbox.addEventListener('change', toggleEndDateField);
    });
</script>
@endsection
"
voici le fichier views/candidat/languagecreat.blade.php : 
"@extends('layouts.candidat')

@section('title', 'Ajouter des langues')

@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        border-color: #2557a7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 87, 167, 0.1);
    }
    
    .form-select {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    .form-select:focus {
        border-color: #2557a7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 87, 167, 0.1);
    }
    
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #2557a7;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-save:hover {
        background-color: #1e4b8f;
    }
    
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 1rem;
    }
    
    .btn-cancel:hover {
        background-color: #e5e7eb;
    }
    
    .form-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        background-color: white;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .search-container {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    
    .search-input {
        padding-left: 2.5rem;
    }
    
    .language-item {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-bottom: 1rem;
        transition: all 0.2s;
    }
    
    .language-item:hover {
        background-color: #f9fafb;
    }
    
    .language-item.selected {
        background-color: #f0f9ff;
        border-color: #bae6fd;
    }
    
    .language-checkbox {
        margin-right: 1rem;
    }
    
    .language-info {
        flex: 1;
    }
    
    .language-name {
        font-weight: 500;
        color: #111827;
    }
    
    .language-level-select {
        width: 200px;
    }
    
    .selected-languages {
        margin-top: 1.5rem;
        padding: 1rem;
        background-color: #f3f4f6;
        border-radius: 0.375rem;
    }
    
    .selected-languages-title {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.75rem;
    }
    
    .selected-language-tag {
        display: inline-flex;
        align-items: center;
        background-color: #dbeafe;
        border: 1px solid #93c5fd;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        color: #1e40af;
    }
    
    .remove-language {
        margin-left: 0.5rem;
        cursor: pointer;
        color: #1e40af;
    }
    
    .language-level-badge {
        display: inline-flex;
        align-items: center;
        background-color: #e0f2fe;
        border-radius: 9999px;
        padding: 0.125rem 0.5rem;
        margin-left: 0.5rem;
        font-size: 0.75rem;
        color: #0369a1;
    }
    
    .no-results {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
        font-style: italic;
    }
    
    .loading {
        text-align: center;
        padding: 1rem;
        color: #6b7280;
    }
    
    .spinner {
        display: inline-block;
        width: 1.5rem;
        height: 1.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        border-top-color: #2557a7;
        animation: spin 1s linear infinite;
        margin-right: 0.5rem;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
    
    .show-more-btn {
        display: block;
        width: 100%;
        padding: 0.75rem;
        text-align: center;
        background-color: #f3f4f6;
        border: 1px dashed #d1d5db;
        border-radius: 0.375rem;
        color: #4b5563;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        margin-top: 1rem;
    }
    
    .show-more-btn:hover {
        background-color: #e5e7eb;
        color: #374151;
    }
</style>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Ajouter des langues</h1>
        <p class="mt-2 text-gray-600">Sélectionnez les langues que vous maîtrisez et indiquez votre niveau.</p>
    </div>
    
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    
    <form action="{{ route('resumes.language.store', $resume->id) }}" method="POST">
        @csrf
        
        <div class="form-section">
            <h2 class="form-section-title">Langues disponibles</h2>
            <p class="text-gray-600 mb-4">Sélectionnez les langues que vous maîtrisez et indiquez votre niveau pour chacune d'elles.</p>
            
            <div class="search-container">
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" id="search-languages" class="form-input search-input" placeholder="Rechercher des langues...">
            </div>
            
            <div id="languages-list" class="space-y-4">
                @foreach($languages->take(5) as $language)
                    <div class="language-item {{ $selectedLanguages->contains('id', $language->id) ? 'selected' : '' }}" id="language-item-{{ $language->id }}">
                        <input type="checkbox" id="language-{{ $language->id }}" name="languages[{{ $language->id }}][selected]" value="1" class="language-checkbox" {{ $selectedLanguages->contains('id', $language->id) ? 'checked' : '' }}>
                        <div class="language-info">
                            <div class="language-name">{{ $language->name }}</div>
                        </div>
                        <div class="language-level-select">
                            <select name="languages[{{ $language->id }}][level]" class="form-select" {{ $selectedLanguages->contains('id', $language->id) ? '' : 'disabled' }}>
                                <option value="débutant" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'débutant' ? 'selected' : '' }}>Débutant</option>
                                <option value="intermédiaire" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="avancé" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'avancé' ? 'selected' : '' }}>Avancé</option>
                                <option value="courant" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'courant' ? 'selected' : '' }}>Courant</option>
                                <option value="natif" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'natif' ? 'selected' : '' }}>Langue maternelle</option>
                            </select>
                        </div>
                    </div>
                @endforeach
                
                @foreach($languages->skip(10) as $language)
                    <div class="language-item {{ $selectedLanguages->contains('id', $language->id) ? 'selected' : '' }} hidden-language" id="language-item-{{ $language->id }}" style="display: none;">
                        <input type="checkbox" id="language-{{ $language->id }}" name="languages[{{ $language->id }}][selected]" value="1" class="language-checkbox" {{ $selectedLanguages->contains('id', $language->id) ? 'checked' : '' }}>
                        <div class="language-info">
                            <div class="language-name">{{ $language->name }}</div>
                        </div>
                        <div class="language-level-select">
                            <select name="languages[{{ $language->id }}][level]" class="form-select" {{ $selectedLanguages->contains('id', $language->id) ? '' : 'disabled' }}>
                                <option value="débutant" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'débutant' ? 'selected' : '' }}>Débutant</option>
                                <option value="intermédiaire" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="avancé" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'avancé' ? 'selected' : '' }}>Avancé</option>
                                <option value="courant" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'courant' ? 'selected' : '' }}>Courant</option>
                                <option value="natif" {{ $selectedLanguages->where('id', $language->id)->first() && $selectedLanguages->where('id', $language->id)->first()->pivot->level == 'natif' ? 'selected' : '' }}>Langue maternelle</option>
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>
            
            @if($languages->count() > 10)
                <button type="button" id="show-more-btn" class="show-more-btn">
                    Afficher plus de langues
                </button>
            @endif
            
            <div id="no-results" class="no-results" style="display: none;">
                <p>Aucune langue trouvée correspondant à votre recherche.</p>
            </div>
            
            <div id="selected-languages-container" class="selected-languages" style="{{ count($selectedLanguages) > 0 ? '' : 'display: none;' }}">
                <div class="selected-languages-title">Langues sélectionnées</div>
                <div id="selected-languages-list" class="flex flex-wrap">
                    @foreach($selectedLanguages as $language)
                        <div class="selected-language-tag" data-language-id="{{ $language->id }}">
                            {{ $language->name }}
                            <span class="language-level-badge">{{ $language->pivot->level }}</span>
                            <span class="remove-language" data-language-id="{{ $language->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="flex justify-end mt-8">
            <a href="{{ route('resume.view', $resume->id) }}" class="btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                Annuler
            </a>
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-languages');
        const languagesList = document.getElementById('languages-list');
        const noResultsElement = document.getElementById('no-results');
        const selectedLanguagesContainer = document.getElementById('selected-languages-container');
        const selectedLanguagesList = document.getElementById('selected-languages-list');
        const showMoreBtn = document.getElementById('show-more-btn');
        
        // Ensemble pour suivre les langues sélectionnées
        const selectedLanguages = new Set();
        
        // Initialiser les langues déjà sélectionnées
        document.querySelectorAll('.language-item.selected').forEach(item => {
            const checkbox = item.querySelector('.language-checkbox');
            if (checkbox && checkbox.checked) {
                selectedLanguages.add(checkbox.id.split('-')[1]);
            }
        });
        
        // Fonction pour mettre à jour l'affichage des langues sélectionnées
        function updateSelectedLanguagesDisplay() {
            if (selectedLanguages.size > 0) {
                selectedLanguagesContainer.style.display = '';
            } else {
                selectedLanguagesContainer.style.display = 'none';
            }
        }
        
        // Fonction pour rechercher des langues
        function searchLanguages(query) {
            query = query.toLowerCase();
            let hasResults = false;
            let allHidden = true;
            
            // Afficher toutes les langues si la recherche est active
            const isSearchActive = query.length > 0;
            
            // Parcourir toutes les langues et filtrer
            document.querySelectorAll('.language-item').forEach(item => {
                const languageName = item.querySelector('.language-name').textContent.toLowerCase();
                
                if (isSearchActive) {
                    // Mode recherche: afficher uniquement les correspondances
                    if (languageName.includes(query)) {
                        item.style.display = '';
                        hasResults = true;
                        allHidden = false;
                    } else {
                        item.style.display = 'none';
                    }
                } else {
                    // Mode normal: respecter la limite initiale
                    if (item.classList.contains('hidden-language')) {
                        item.style.display = 'none';
                    } else {
                        item.style.display = '';
                        allHidden = false;
                    }
                }
            });
            
            // Afficher ou masquer le message "Aucun résultat"
            if (isSearchActive && !hasResults) {
                noResultsElement.style.display = '';
            } else {
                noResultsElement.style.display = 'none';
            }
            
            // Afficher ou masquer le bouton "Afficher plus"
            if (showMoreBtn) {
                showMoreBtn.style.display = isSearchActive ? 'none' : '';
            }
        }
        
        // Fonction pour gérer la sélection d'une langue
        function handleLanguageSelection(event) {
            const checkbox = event.target;
            const languageItem = checkbox.closest('.language-item');
            const languageId = checkbox.id.split('-')[1];
            const languageName = languageItem.querySelector('.language-name').textContent;
            const levelSelect = languageItem.querySelector('select');
            
            if (checkbox.checked) {
                // Ajouter la langue à la liste des sélectionnées
                selectedLanguages.add(languageId);
                languageItem.classList.add('selected');
                levelSelect.disabled = false;
                
                // Ajouter le tag de langue sélectionnée
                const languageTag = document.createElement('div');
                languageTag.className = 'selected-language-tag';
                languageTag.dataset.languageId = languageId;
                languageTag.innerHTML = `
                    ${languageName}
                    <span class="language-level-badge">${levelSelect.value}</span>
                    <span class="remove-language" data-language-id="${languageId}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </span>
                `;
                selectedLanguagesList.appendChild(languageTag);
                
                // Ajouter l'événement de suppression
                languageTag.querySelector('.remove-language').addEventListener('click', handleRemoveLanguage);
                
                // Ajouter l'événement de changement de niveau
                levelSelect.addEventListener('change', function() {
                    const levelBadge = languageTag.querySelector('.language-level-badge');
                    levelBadge.textContent = this.value;
                });
            } else {
                // Supprimer la langue de la liste des sélectionnées
                selectedLanguages.delete(languageId);
                languageItem.classList.remove('selected');
                levelSelect.disabled = true;
                
                // Supprimer le tag de langue
                const languageTag = selectedLanguagesList.querySelector(`.selected-language-tag[data-language-id="${languageId}"]`);
                if (languageTag) {
                    languageTag.remove();
                }
            }
            
            updateSelectedLanguagesDisplay();
        }
        
        // Fonction pour gérer la suppression d'une langue
        function handleRemoveLanguage(event) {
            const languageId = event.currentTarget.dataset.languageId;
            
            // Supprimer la langue de la liste des sélectionnées
            selectedLanguages.delete(languageId);
            
            // Décocher la case à cocher correspondante
            const checkbox = document.getElementById(`language-${languageId}`);
            if (checkbox) {
                checkbox.checked = false;
                const languageItem = checkbox.closest('.language-item');
                languageItem.classList.remove('selected');
                const levelSelect = languageItem.querySelector('select');
                levelSelect.disabled = true;
            }
            
            // Supprimer le tag de langue
            const languageTag = event.currentTarget.closest('.selected-language-tag');
            if (languageTag) {
                languageTag.remove();
            }
            
            updateSelectedLanguagesDisplay();
        }
        
        // Ajouter les écouteurs d'événements
        searchInput.addEventListener('input', function() {
            searchLanguages(this.value.trim());
        });
        
        // Ajouter l'événement pour afficher plus de langues
        if (showMoreBtn) {
            showMoreBtn.addEventListener('click', function() {
                document.querySelectorAll('.hidden-language').forEach(item => {
                    item.style.display = '';
                    item.classList.remove('hidden-language');
                });
                this.style.display = 'none';
            });
        }
        
        // Ajouter l'événement de sélection aux langues
        document.querySelectorAll('.language-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', handleLanguageSelection);
        });
        
        // Ajouter l'événement de suppression aux langues sélectionnées
        document.querySelectorAll('.remove-language').forEach(button => {
            button.addEventListener('click', handleRemoveLanguage);
        });
        
        // Ajouter l'événement de clic sur les éléments de langue
        document.querySelectorAll('.language-item').forEach(function(item) {
            item.addEventListener('click', function(e) {
                // Ne pas déclencher si on clique sur la case à cocher ou le sélecteur
                if (!e.target.classList.contains('language-checkbox') && !e.target.classList.contains('form-select')) {
                    const checkbox = this.querySelector('.language-checkbox');
                    checkbox.checked = !checkbox.checked;
                    
                    // Déclencher l'événement change manuellement
                    const event = new Event('change');
                    checkbox.dispatchEvent(event);
                }
            });
        });
        
        // Mettre à jour l'affichage initial
        updateSelectedLanguagesDisplay();
    });
</script>
@endsection
"
voici le fichier views/candidat/offerdetails.blade.php : 
"<div class="job-details p-6">
    <div class="flex items-start justify-between mb-6">
        <div class="flex items-start">
            <div class="company-logo mr-4">
                @if($offer->company->name)
                    <div class="company-logo-placeholder">{{ substr($offer->company->name, 0, 1) }}</div>
                @else
                    <div class="company-logo-placeholder">Ent</div>
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $offer->title }}</h1>
                @if($offer->company->name)
                    <p class="text-gray-600">{{ $offer->company->name }} • {{ $offer->location }}</p>
                @else
                    <p class="text-gray-600">Entreprise non spécifiée • {{ $offer->location }}</p>                
                @endif
                <div class="flex items-center text-gray-500 text-sm mt-1">
                    <span class="mr-3"><i class="far fa-clock mr-1"></i> {{ $offer->mode_travail }}</span>
                    <span><i class="far fa-calendar-alt mr-1"></i> Publié {{ $offer->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
        <div class="flex space-x-2">
            <button class="btn-secondary text-sm">
                <i class="far fa-bookmark"></i>
            </button>
            <button class="btn-secondary text-sm">
                <i class="fas fa-share-alt"></i>
            </button>
        </div>
    </div>

    <div class="px-6 py-4">
        <div class="flex flex-wrap gap-2 mb-6">
            @foreach($offer->skills as $skill)
                <span class="bg-sky-100 text-sky-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $skill->name }}</span>
            @endforeach
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Description du poste</h2>
        <div class="prose max-w-none text-gray-700">
            {!! $offer->description !!}
        </div>
    </div>

    <div class="border-t pt-6 mt-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm">Soyez parmi les premiers à postuler</p>
            </div>
                <form method="POST" action="{{ route('candidat.offres.postuler', $offer->id) }}">
                    @csrf
                    <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                        <i class="fas fa-paper-plane mr-2"></i> Postuler maintenant
                    </button>
                </form>
        </div>
    </div>
</div>
"
voici le fichier views/candidat/pageaccueil.blade.php : 
"@extends('layouts.candidat')

@section('title', 'Recherche d\'emploi')

@section('styles')
<style>
    .job-card {
        transition: all 0.2s;
        cursor: pointer;
    }
    .job-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .job-card.active {
        border-color: #4f46e5;
        background-color: #f9f9ff;
    }
    .job-details {
        height: calc(100vh - 16rem);
        overflow-y: auto;
    }
    .search-container {
        background: linear-gradient(to right, #4f46e5, #6366f1);
    }
    .badge-skill {
        @apply bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full;
    }
    .badge-language {
        @apply bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full;
    }
    .company-logo {
        width: 50px;
        height: 50px;
        background-color: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        overflow: hidden;
    }
    .company-logo img {
        max-width: 100%;
        max-height: 100%;
    }
    .company-logo-placeholder {
        font-size: 1.5rem;
        font-weight: bold;
        color: #6b7280;
    }
    .search-input {
        @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500;
    }
    .search-button {
        @apply bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
    }
    .job-list {
        height: calc(100vh - 16rem);
        overflow-y: auto;
    }
    .job-list::-webkit-scrollbar, .job-details::-webkit-scrollbar {
        width: 6px;
    }
    .job-list::-webkit-scrollbar-track, .job-details::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .job-list::-webkit-scrollbar-thumb, .job-details::-webkit-scrollbar-thumb {
        background: #c5c5c5;
        border-radius: 3px;
    }
    .job-list::-webkit-scrollbar-thumb:hover, .job-details::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-align: center;
        padding: 2rem;
    }
    .empty-icon {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
</style>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Search Section -->
    <div class="search-container py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <form action="{{ route('candidat.offres.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="keywords" class="block text-sm font-medium text-gray-700 mb-1">Mots-clés</label>
                        <input type="text" name="keywords" id="keywords" placeholder="Titre, compétences ou entreprise" 
                            class="search-input" value="{{ request('keywords') }}">
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lieu</label>
                        <input type="text" name="location" id="location" placeholder="Ville ou région" 
                            class="search-input" value="{{ request('location') }}">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="search-button w-full">
                            <i class="fas fa-search mr-2"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jobs Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">
                @if(isset($searchResults))
                    {{ $jobs->total() }} offres trouvées
                @else
                    Offres d'emploi recommandées
                @endif
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Job Listings -->
            <div class="lg:col-span-1">
                <div class="job-list">
                    @if(count($jobs) > 0)
                        @foreach($jobs as $job)
                        <div class="job-card bg-white rounded-lg border p-4 mb-4 {{ request('job_id') == $job->id ? 'active' : '' }}" 
                            data-job-id="{{ $job->id }}">                               
                            <div class="flex items-start">
                                    <div class="company-logo mr-4">
                                    @if($job->company)
                                        <p class="text-gray-600 text-sm">{{ $job->company->name }}</p>
                                    @else
                                        <p class="text-gray-600 text-sm">Entreprise non spécifiée</p>
                                    @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $job->title }}</h3>
                                        @if($job->company)
                                            <p class="text-gray-600 text-sm">{{ $job->company->name }}</p>
                                        @else
                                            <p class="text-gray-600 text-sm">Entreprise non spécifiée</p>
                                        @endif
                                        <p class="text-gray-500 text-sm">{{ $job->location }}</p>
                                    </div>
                                    @if(isset($job->match_score))
                                        <div class="mt-3">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-xs font-medium text-indigo-700">Score de matching</span>
                                                <span class="text-xs font-medium text-indigo-700">{{ $job->match_score }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $job->match_score }}%"></div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="text-gray-500 text-xs">
                                        {{ $job->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="mt-4">
                        </div>
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Aucune offre trouvée</h3>
                            <p class="text-gray-500 mt-1">Essayez de modifier vos critères de recherche</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Job Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border h-full" id="job-details-container">
                    @if(isset($selectedJob))
                        @include('candidat.partials.offer_details', ['offer' => $selectedJob])
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="far fa-file-alt"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Sélectionnez une offre</h3>
                            <p class="text-gray-500 mt-1">Cliquez sur une offre pour voir les détails</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function loadOfferDetails(jobId, element) {
    // Afficher le loader
    const detailsContainer = document.getElementById('job-details-container');
    detailsContainer.innerHTML = `
        <div class="empty-state">
            <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500 mx-auto"></div>
            <p class="text-gray-500 mt-4">Chargement des détails...</p>
        </div>
    `;

    // Configuration de la requête
    const headers = {
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
    };

    fetch(`/candidat/offres/${jobId}`, { headers })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Erreur serveur');
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                detailsContainer.innerHTML = data.html;
                // Mettre à jour l'URL
                const url = new URL(window.location);
                url.searchParams.set('job_id', jobId);
                window.history.pushState({}, '', url);
                
                // Gestion des classes actives
                document.querySelectorAll('.job-card').forEach(card => {
                    card.classList.remove('active');
                });
                element.classList.add('active');
            } else {
                throw new Error(data.message || 'Réponse inattendue');
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            detailsContainer.innerHTML = `
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900">Erreur</h3>
                    <p class="text-gray-500 mt-1">${error.message}</p>
                </div>
            `;
        });
}

    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du clic sur les cartes
        document.querySelectorAll('.job-card').forEach(card => {
            card.addEventListener('click', function(e) {
                const jobId = this.getAttribute('data-job-id');
                loadOfferDetails(jobId, this);
            });
        });

        // Gestion du clic initial si une offre est sélectionnée
        const initialJobId = new URLSearchParams(window.location.search).get('job_id');
        if (initialJobId) {
            const card = document.querySelector(`.job-card[data-job-id="${initialJobId}"]`);
            if (card) {
                card.classList.add('active');
                loadOfferDetails(initialJobId, card);
            }
        }
    });
</script>
@endsection
"
voici le fichier views/candidat/profilcandidat.blade.php : 
"@extends('layouts.candidat')

@section('title', 'Profil Candidat')

@section('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 2rem 1rem;
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .profile-avatar {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background-color: #4f46e5;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        font-weight: bold;
        margin-right: 1.5rem;
    }
    
    .profile-info h1 {
        font-size: 2.25rem;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    
    .profile-contact {
        margin-top: 1.5rem;
    }
    
    .profile-contact-item {
        display: flex;
        align-items: center;
        margin-bottom: 0.75rem;
        color: #4b5563;
    }
    
    .profile-contact-item i {
        width: 1.5rem;
        color: #6b7280;
        margin-right: 0.75rem;
    }
    
    .section-title {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .cv-file {
        display: flex;
        align-items: center;
        padding: 1rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
        background-color: white;
    }
    
    .cv-file-icon {
        background-color: #eff6ff;
        color: #3b82f6;
        width: 40px;
        height: 40px;
        border-radius: 0.25rem;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
    }
    
    .cv-file-info {
        flex: 1;
    }
    
    .cv-file-name {
        font-weight: 500;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }
    
    .cv-file-date {
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .cv-file-actions {
        position: relative;
    }
    
    .cv-file-menu-btn {
        background: none;
        border: none;
        color: #6b7280;
        cursor: pointer;
        padding: 0.5rem;
        border-radius: 0.25rem;
        transition: background-color 0.2s;
    }
    
    .cv-file-menu-btn:hover {
        background-color: #f3f4f6;
    }
    
    .cv-file-menu {
        position: absolute;
        right: 0;
        top: 100%;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        width: 200px;
        z-index: 10;
        display: none;
    }
    
    .cv-file-menu.active {
        display: block;
    }
    
    .cv-file-menu-item {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        color: #1f2937;
        transition: background-color 0.2s;
        cursor: pointer;
        text-decoration: none;
    }
    
    .cv-file-menu-item:hover {
        background-color: #f9fafb;
    }
    
    .cv-file-menu-item i {
        margin-right: 0.75rem;
        width: 16px;
    }
    
    .cv-file-menu-item.text-danger {
        color: #ef4444;
    }
    
    .cv-file-menu-item.text-danger:hover {
        background-color: #fef2f2;
    }
    
    .cv-actions {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    .file-input {
        display: none;
    }

    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.625rem 1.25rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #2557a7;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        text-decoration: none;
        border: none;
    }

    .btn-primary:hover {
        background-color: #1e4b8f;
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <!-- Informations du profil -->
    <div class="profile-header">
        <div class="profile-avatar">
            {{ substr($user->name ?? 'User Name', 0, 1) }}{{ substr(explode(' ', $user->name ?? 'User Name')[1] ?? '', 0, 1) }}
        </div>
        <div class="profile-info">
            <h1>{{ $user->name ?? 'User Name' }}</h1>
            <div class="text-gray-500">{{ $user->email ?? 'useremail@gmail.com' }}</div>
            
            <div class="profile-contact">
                @if(isset($resume->phone))
                <div class="profile-contact-item">
                    <i class="fas fa-phone"></i>
                    <span>{{ $resume->phone }}</span>
                </div>
                @endif
                
                @if(isset($resume->pays) && isset($resume->ville))
                <div class="profile-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $resume->ville }}, {{ $resume->pays }}</span>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Section CV -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        
        @if(isset($cv))
        <div class="cv-file">
            <div class="cv-file-icon">
                <i class="fas fa-file-pdf"></i>
            </div>
            <div class="cv-file-info">
                <div class="cv-file-name">{{ $cv->filename }}</div>
                <div class="cv-file-date">Ajouté {{ $cv->created_at->diffForHumans() }}</div>
            </div>
            <div class="cv-file-actions">
                <button type="button" class="cv-file-menu-btn" onclick="toggleCvMenu()">
                    <i class="fas fa-ellipsis-h"></i>
                </button>
                <div class="cv-file-menu" id="cvMenu">
                    <a href="{{ route('cv.show', $cv->id) }}" class="cv-file-menu-item" target="_blank">
                        <i class="fas fa-eye"></i>
                        <span>Voir</span>
                    </a>
                    <label for="replace-cv" class="cv-file-menu-item">
                        <i class="fas fa-sync-alt"></i>
                        <span>Remplacer le fichier</span>
                    </label>
                    <form action="{{ route('cv.destroy', $cv->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="cv-file-menu-item text-danger">
                            <i class="fas fa-trash-alt"></i>
                            <span>Supprimer</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <form action="{{ route('cv.update', $cv->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="file" name="cv_file" id="replace-cv" class="file-input" accept=".pdf" onchange="this.form.submit()">
        </form>
        @else
        <div class="cv-actions">
            <form action="{{ route('cv.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="cv_file" id="cv-file" class="file-input" accept=".pdf" onchange="updateFileName(this)">
                <label for="cv-file" class="btn-primary flex items-center justify-center w-full">
                    <i class="fas fa-upload mr-2"></i>
                    <span id="upload-text">Importer un CV</span>
                </label>
                <button type="submit" id="submit-cv" class="btn-primary mt-3 w-full" style="display: none;">
                    <i class="fas fa-check mr-2"></i>
                    Confirmer
                </button>
            </form>
        </div>
        @endif
    </div>

    <!-- Section CV WorkBridge -->
    <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
        
        <div class="cv-actions">
            @if(isset($resume))
                <a href="{{ route('resume.view') }}" class="btn-primary flex items-center justify-center">
                    <i class="fas fa-eye mr-2"></i>
                    WorkBridge CV
                </a>
            @else
                <a href="{{ route('resume.create') }}" class="btn-primary flex items-center justify-center">
                    <i class="fas fa-plus mr-2"></i>
                    Créer WorkBridge CV
                </a>
            @endif
        </div>
    </div>

</div>
@endsection

@section('scripts')
<script>
    // Fonction pour afficher/masquer le menu du CV
    function toggleCvMenu() {
        const menu = document.getElementById('cvMenu');
        menu.classList.toggle('active');
        
        // Fermer le menu si on clique ailleurs
        document.addEventListener('click', function(event) {
            const isClickInside = event.target.closest('.cv-file-actions');
            if (!isClickInside && menu.classList.contains('active')) {
                menu.classList.remove('active');
            }
        }, { once: true });
    }
    
    // Fonction pour mettre à jour le nom du fichier sélectionné
    function updateFileName(input) {
        const fileName = input.files[0]?.name;
        const uploadText = document.getElementById('upload-text');
        const submitBtn = document.getElementById('submit-cv');
        
        if (fileName) {
            uploadText.textContent = fileName;
            submitBtn.style.display = 'flex';
        } else {
            uploadText.textContent = 'Importer un CV';
            submitBtn.style.display = 'none';
        }
    }
    
    // Fermer le menu du CV quand on clique en dehors
    document.addEventListener('click', function(event) {
        const menu = document.getElementById('cvMenu');
        const menuBtn = document.querySelector('.cv-file-menu-btn');
        
        if (menu && menu.classList.contains('active') && !menuBtn.contains(event.target) && !menu.contains(event.target)) {
            menu.classList.remove('active');
        }
    });
</script>
@endsection
"
voici le fichier views/candidat/resumecreate.blade.php : 
"@extends('layouts.candidat')

@section('title', 'Créer votre CV WorkBridge')

@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        border-color: #2557a7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 87, 167, 0.1);
    }
    
    .form-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #d1d5db;
        cursor: pointer;
    }
    
    .form-checkbox:checked {
        background-color: #2557a7;
        border-color: #2557a7;
    }
    
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #2557a7;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-save:hover {
        background-color: #1e4b8f;
    }
    
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 1rem;
    }
    
    .btn-cancel:hover {
        background-color: #e5e7eb;
    }
    
    .form-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        background-color: white;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .autocomplete-results {
        position: absolute;
        z-index: 10;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-top: 0.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: none;
    }
    
    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .autocomplete-item:hover {
        background-color: #f3f4f6;
    }
    
    .autocomplete-item.active {
        background-color: #e5e7eb;
    }
    
    .spinner {
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid #2557a7;
        width: 16px;
        height: 16px;
        animation: spin 1s linear infinite;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        display: none;
    }
    
    @keyframes spin {
        0% { transform: translateY(-50%) rotate(0deg); }
        100% { transform: translateY(-50%) rotate(360deg); }
    }
    
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon .spinner {
        right: 12px;
    }
    
    .input-with-icon .clear-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        cursor: pointer;
        display: none;
    }
    
    .input-with-icon input:focus + .clear-btn,
    .input-with-icon input:not(:placeholder-shown) + .clear-btn {
        display: block;
    }
    
    .input-with-icon input:focus + .clear-btn + .spinner,
    .input-with-icon input:not(:placeholder-shown) + .clear-btn + .spinner {
        right: 36px;
    }
</style>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer votre CV WorkBridge</h1>
        <p class="mt-2 text-gray-600">Complétez les informations ci-dessous pour créer votre CV professionnel.</p>
    </div>
    
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    
    <form action="{{ route('resume.store') }}" method="POST">
        @csrf
        
        <div class="form-section">
            <h2 class="form-section-title">Informations personnelles</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="birthDate" class="form-label">Date de naissance</label>
                    <input type="date" id="birthDate" name="birthDate" class="form-input" value="{{ old('birthDate') }}" required>
                    @error('birthDate')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Numéro de téléphone</label>
                    <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone') }}" required>
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="pays" class="form-label">Pays</label>
                    <div class="input-with-icon">
                        <input type="text" id="pays" name="pays" class="form-input" value="{{ old('pays') }}" required placeholder="Sélectionner un pays...">
                        <span class="clear-btn" id="clear-country">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="country-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="country-results"></div>
                    <input type="hidden" id="country-code" name="country_code" value="{{ old('country_code') }}">
                    @error('pays')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="ville" class="form-label">Ville</label>
                    <div class="input-with-icon">
                        <input type="text" id="ville" name="ville" class="form-input" value="{{ old('ville') }}" required placeholder="Sélectionner une ville..." {{ old('pays') ? '' : 'disabled' }}>
                        <span class="clear-btn" id="clear-city">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="city-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="city-results"></div>
                    <input type="hidden" id="city-id" name="city_id" value="{{ old('city_id') }}">
                    @error('ville')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="form-group mt-4">
                <div class="flex items-center">
                    <input type="checkbox" id="relocation_possible" name="relocation_possible" class="form-checkbox" value="1" {{ old('relocation_possible') ? 'checked' : '' }}>
                    <label for="relocation_possible" class="ml-2 text-gray-700">Je suis prêt(e) à déménager pour un emploi</label>
                </div>
                <p class="form-help-text">Cochez cette case si vous êtes ouvert(e) à des opportunités qui nécessitent un déménagement.</p>
            </div>
        </div>
        
        <div class="flex justify-end mt-8">
            <a href="{{ route('profil.candidat') }}" class="btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                Annuler
            </a>
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du formulaire
        const paysField = document.getElementById('pays');
        const countryCodeField = document.getElementById('country-code');
        const villeField = document.getElementById('ville');
        const cityIdField = document.getElementById('city-id');
        
        // Résultats d'autocomplétion
        const countryResults = document.getElementById('country-results');
        const cityResults = document.getElementById('city-results');
        
        // Spinners
        const countrySpinner = document.getElementById('country-spinner');
        const citySpinner = document.getElementById('city-spinner');
        
        // Boutons de suppression
        const clearCountryBtn = document.getElementById('clear-country');
        const clearCityBtn = document.getElementById('clear-city');
        
        // Liste des pays (exemple - à remplacer par votre propre source de données)
        const countries = [
            "Afghanistan", "Afrique du Sud", "Albanie", "Algérie", "Allemagne", "Andorre", "Angola", "Antigua-et-Barbuda", 
            "Arabie Saoudite", "Argentine", "Arménie", "Australie", "Autriche", "Azerbaïdjan", "Bahamas", "Bahreïn", 
            "Bangladesh", "Barbade", "Belgique", "Belize", "Bénin", "Bhoutan", "Biélorussie", "Birmanie", "Bolivie", 
            "Bosnie-Herzégovine", "Botswana", "Brésil", "Brunei", "Bulgarie", "Burkina Faso", "Burundi", "Cambodge", 
            "Cameroun", "Canada", "Cap-Vert", "Chili", "Chine", "Chypre", "Colombie", "Comores", "Congo", 
            "Corée du Nord", "Corée du Sud", "Costa Rica", "Côte d'Ivoire", "Croatie", "Cuba", "Danemark", "Djibouti", 
            "Dominique", "Égypte", "Émirats arabes unis", "Équateur", "Érythrée", "Espagne", "Estonie", "Eswatini", 
            "États-Unis", "Éthiopie", "Fidji", "Finlande", "France", "Gabon", "Gambie", "Géorgie", "Ghana", "Grèce", 
            "Grenade", "Guatemala", "Guinée", "Guinée équatoriale", "Guinée-Bissau", "Guyana", "Haïti", "Honduras", 
            "Hongrie", "Îles Marshall", "Îles Salomon", "Inde", "Indonésie", "Irak", "Iran", "Irlande", "Islande", 
            "Israël", "Italie", "Jamaïque", "Japon", "Jordanie", "Kazakhstan", "Kenya", "Kirghizistan", "Kiribati", 
            "Koweït", "Laos", "Lesotho", "Lettonie", "Liban", "Liberia", "Libye", "Liechtenstein", "Lituanie", 
            "Luxembourg", "Macédoine du Nord", "Madagascar", "Malaisie", "Malawi", "Maldives", "Mali", "Malte", 
            "Maroc", "Maurice", "Mauritanie", "Mexique", "Micronésie", "Moldavie", "Monaco", "Mongolie", "Monténégro", 
            "Mozambique", "Namibie", "Nauru", "Népal", "Nicaragua", "Niger", "Nigeria", "Niue", "Norvège", 
            "Nouvelle-Zélande", "Oman", "Ouganda", "Ouzbékistan", "Pakistan", "Palaos", "Palestine", "Panama", 
            "Papouasie-Nouvelle-Guinée", "Paraguay", "Pays-Bas", "Pérou", "Philippines", "Pologne", "Portugal", 
            "Qatar", "République centrafricaine", "République démocratique du Congo", "République dominicaine", 
            "République tchèque", "Roumanie", "Royaume-Uni", "Russie", "Rwanda", "Saint-Kitts-et-Nevis", "Saint-Marin", 
            "Saint-Vincent-et-les-Grenadines", "Sainte-Lucie", "Salvador", "Samoa", "São Tomé-et-Principe", "Sénégal", 
            "Serbie", "Seychelles", "Sierra Leone", "Singapour", "Slovaquie", "Slovénie", "Somalie", "Soudan", 
            "Soudan du Sud", "Sri Lanka", "Suède", "Suisse", "Suriname", "Syrie", "Tadjikistan", "Tanzanie", "Tchad", 
            "Thaïlande", "Timor oriental", "Togo", "Tonga", "Trinité-et-Tobago", "Tunisie", "Turkménistan", "Turquie", 
            "Tuvalu", "Ukraine", "Uruguay", "Vanuatu", "Vatican", "Venezuela", "Viêt Nam", "Yémen", "Zambie", "Zimbabwe"
        ];
        
        // Fonction pour afficher les résultats d'autocomplétion des pays
        function showCountryResults(query) {
            countryResults.innerHTML = '';
            countryResults.style.display = 'none';
            
            if (!query) return;
            
            const filteredCountries = countries.filter(country => 
                country.toLowerCase().includes(query.toLowerCase())
            );
            
            if (filteredCountries.length === 0) return;
            
            filteredCountries.forEach(country => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = country;
                item.addEventListener('click', () => {
                    paysField.value = country;
                    countryCodeField.value = country;
                    countryResults.style.display = 'none';
                    
                    // Activer le champ ville
                    villeField.disabled = false;
                    villeField.placeholder = "Sélectionner une ville...";
                    
                    // Simuler un événement input pour déclencher d'autres comportements
                    const event = new Event('input', { bubbles: true });
                    paysField.dispatchEvent(event);
                });
                countryResults.appendChild(item);
            });
            
            countryResults.style.display = 'block';
        }
        
        // Fonction pour simuler les résultats d'autocomplétion des villes
        function showCityResults(country, query) {
            cityResults.innerHTML = '';
            cityResults.style.display = 'none';
            
            if (!query || !country) return;
            
            // Simuler un délai de chargement
            citySpinner.style.display = 'block';
            
            // Exemple de villes pour quelques pays (à remplacer par votre propre source de données)
            const citiesByCountry = {
                "France": ["Paris", "Marseille", "Lyon", "Toulouse", "Nice", "Nantes", "Strasbourg", "Montpellier", "Bordeaux", "Lille"],
                "Maroc": ["Casablanca", "Rabat", "Marrakech", "Fès", "Tanger", "Agadir", "Meknès", "Oujda", "Tétouan", "Kénitra"],
                "Canada": ["Toronto", "Montréal", "Vancouver", "Calgary", "Edmonton", "Ottawa", "Québec", "Winnipeg", "Hamilton", "Halifax"],
                "États-Unis": ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphie", "San Antonio", "San Diego", "Dallas", "San José"],
                "Royaume-Uni": ["Londres", "Birmingham", "Manchester", "Glasgow", "Liverpool", "Bristol", "Édimbourg", "Leeds", "Sheffield", "Leicester"]
            };
            
            // Simuler un délai de chargement
            setTimeout(() => {
                citySpinner.style.display = 'none';
                
                // Si le pays est dans notre liste, afficher ses villes
                if (citiesByCountry[country]) {
                    const filteredCities = citiesByCountry[country].filter(city => 
                        city.toLowerCase().includes(query.toLowerCase())
                    );
                    
                    if (filteredCities.length === 0) return;
                    
                    filteredCities.forEach(city => {
                        const item = document.createElement('div');
                        item.className = 'autocomplete-item';
                        item.textContent = city;
                        item.addEventListener('click', () => {
                            villeField.value = city;
                            cityIdField.value = city;
                            cityResults.style.display = 'none';
                        });
                        cityResults.appendChild(item);
                    });
                    
                    cityResults.style.display = 'block';
                } else {
                    // Si le pays n'est pas dans notre liste, permettre la saisie libre
                    cityIdField.value = villeField.value;
                }
            }, 500);
        }
        
        // Événements pour le champ pays
        paysField.addEventListener('input', function() {
            const query = this.value.trim();
            showCountryResults(query);
            
            if (query) {
                countryCodeField.value = query;
                villeField.disabled = false;
                villeField.placeholder = "Sélectionner une ville...";
            } else {
                countryCodeField.value = "";
                villeField.disabled = true;
                villeField.value = "";
                cityIdField.value = "";
                villeField.placeholder = "Sélectionner d'abord un pays...";
            }
        });
        
        paysField.addEventListener('focus', function() {
            if (this.value.trim()) {
                showCountryResults(this.value.trim());
            }
        });
        
        // Événements pour le champ ville
        villeField.addEventListener('input', function() {
            const query = this.value.trim();
            const country = paysField.value.trim();
            showCityResults(country, query);
            
            if (query) {
                cityIdField.value = query;
            } else {
                cityIdField.value = "";
            }
        });
        
        villeField.addEventListener('focus', function() {
            if (this.value.trim() && paysField.value.trim()) {
                showCityResults(paysField.value.trim(), this.value.trim());
            }
        });
        
        // Événements pour les boutons de suppression
        clearCountryBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            paysField.value = '';
            countryCodeField.value = '';
            countryResults.style.display = 'none';
            
            // Désactiver et réinitialiser le champ ville
            villeField.disabled = true;
            villeField.value = '';
            cityIdField.value = '';
            villeField.placeholder = "Sélectionner d'abord un pays...";
        });
        
        clearCityBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            villeField.value = '';
            cityIdField.value = '';
            cityResults.style.display = 'none';
        });
        
        // Fermer les résultats d'autocomplétion quand on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!paysField.contains(e.target) && !countryResults.contains(e.target)) {
                countryResults.style.display = 'none';
            }
            
            if (!villeField.contains(e.target) && !cityResults.contains(e.target)) {
                cityResults.style.display = 'none';
            }
        });
    });
</script>
@endsection

"
voici le fichier views/candidat/resumeedit.blade.php : 
"@extends('layouts.candidat')

@section('title', 'Modifier votre CV WorkBridge')

@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        border-color: #2557a7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 87, 167, 0.1);
    }
    
    .form-checkbox {
        width: 1.25rem;
        height: 1.25rem;
        margin-right: 0.5rem;
        border-radius: 0.25rem;
        border: 1px solid #d1d5db;
        cursor: pointer;
    }
    
    .form-checkbox:checked {
        background-color: #2557a7;
        border-color: #2557a7;
    }
    
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #2557a7;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-save:hover {
        background-color: #1e4b8f;
    }
    
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 1rem;
    }
    
    .btn-cancel:hover {
        background-color: #e5e7eb;
    }
    
    .form-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        background-color: white;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .autocomplete-results {
        position: absolute;
        z-index: 10;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-top: 0.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: none;
    }
    
    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .autocomplete-item:hover {
        background-color: #f3f4f6;
    }
    
    .autocomplete-item.active {
        background-color: #e5e7eb;
    }
    
    .spinner {
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid #2557a7;
        width: 16px;
        height: 16px;
        animation: spin 1s linear infinite;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        display: none;
    }
    
    @keyframes spin {
        0% { transform: translateY(-50%) rotate(0deg); }
        100% { transform: translateY(-50%) rotate(360deg); }
    }
    
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon .spinner {
        right: 12px;
    }
    
    .input-with-icon .clear-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        cursor: pointer;
        display: none;
    }
    
    .input-with-icon input:focus + .clear-btn,
    .input-with-icon input:not(:placeholder-shown) + .clear-btn {
        display: block;
    }
    
    .input-with-icon input:focus + .clear-btn + .spinner,
    .input-with-icon input:not(:placeholder-shown) + .clear-btn + .spinner {
        right: 36px;
    }
</style>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Modifier votre CV WorkBridge</h1>
        <p class="mt-2 text-gray-600">Mettez à jour les informations de votre CV professionnel.</p>
    </div>
    
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    
    <form action="{{ route('resume.update', $resume->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="form-section">
            <h2 class="form-section-title">Informations personnelles</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="birthDate" class="form-label">Date de naissance</label>
                    <input type="date" id="birthDate" name="birthDate" class="form-input" value="{{ old('birthDate', $resume->birthDate ?? $resume->birth_date) }}" required>
                    @error('birthDate')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Numéro de téléphone</label>
                    <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone', $resume->phone) }}" required>
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="pays" class="form-label">Pays</label>
                    <div class="input-with-icon">
                        <input type="text" id="pays" name="pays" class="form-input" value="{{ old('pays', $resume->pays ?? $resume->country) }}" required placeholder="Sélectionner un pays...">
                        <span class="clear-btn" id="clear-country">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="country-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="country-results"></div>
                    <input type="hidden" id="country-code" name="country_code" value="{{ old('country_code', $resume->country_code) }}">
                    @error('pays')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="ville" class="form-label">Ville</label>
                    <div class="input-with-icon">
                        <input type="text" id="ville" name="ville" class="form-input" value="{{ old('ville', $resume->ville ?? $resume->city) }}" required placeholder="Sélectionner une ville..." {{ old('pays', $resume->pays ?? $resume->country) ? '' : 'disabled' }}>
                        <span class="clear-btn" id="clear-city">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="city-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="city-results"></div>
                    <input type="hidden" id="city-id" name="city_id" value="{{ old('city_id', $resume->city_id) }}">
                    @error('ville')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="form-group mt-4">
                <div class="flex items-center">
                    <input type="checkbox" id="relocation_possible" name="relocation_possible" class="form-checkbox" value="1" {{ old('relocation_possible', $resume->relocation_possible) ? 'checked' : '' }}>
                    <label for="relocation_possible" class="ml-2 text-gray-700">Je suis prêt(e) à déménager pour un emploi</label>
                </div>
                <p class="form-help-text">Cochez cette case si vous êtes ouvert(e) à des opportunités qui nécessitent un déménagement.</p>
            </div>
        </div>
        
        <div class="flex justify-end mt-8">
            <a href="{{ route('profil.candidat') }}" class="btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                Annuler
            </a>
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du formulaire
        const paysField = document.getElementById('pays');
        const countryCodeField = document.getElementById('country-code');
        const villeField = document.getElementById('ville');
        const cityIdField = document.getElementById('city-id');
        
        // Résultats d'autocomplétion
        const countryResults = document.getElementById('country-results');
        const cityResults = document.getElementById('city-results');
        
        // Spinners
        const countrySpinner = document.getElementById('country-spinner');
        const citySpinner = document.getElementById('city-spinner');
        
        // Boutons de suppression
        const clearCountryBtn = document.getElementById('clear-country');
        const clearCityBtn = document.getElementById('clear-city');
        
        // Liste des pays (exemple - à remplacer par votre propre source de données)
        const countries = [
            "Afghanistan", "Afrique du Sud", "Albanie", "Algérie", "Allemagne", "Andorre", "Angola", "Antigua-et-Barbuda", 
            "Arabie Saoudite", "Argentine", "Arménie", "Australie", "Autriche", "Azerbaïdjan", "Bahamas", "Bahreïn", 
            "Bangladesh", "Barbade", "Belgique", "Belize", "Bénin", "Bhoutan", "Biélorussie", "Birmanie", "Bolivie", 
            "Bosnie-Herzégovine", "Botswana", "Brésil", "Brunei", "Bulgarie", "Burkina Faso", "Burundi", "Cambodge", 
            "Cameroun", "Canada", "Cap-Vert", "Chili", "Chine", "Chypre", "Colombie", "Comores", "Congo", 
            "Corée du Nord", "Corée du Sud", "Costa Rica", "Côte d'Ivoire", "Croatie", "Cuba", "Danemark", "Djibouti", 
            "Dominique", "Égypte", "Émirats arabes unis", "Équateur", "Érythrée", "Espagne", "Estonie", "Eswatini", 
            "États-Unis", "Éthiopie", "Fidji", "Finlande", "France", "Gabon", "Gambie", "Géorgie", "Ghana", "Grèce", 
            "Grenade", "Guatemala", "Guinée", "Guinée équatoriale", "Guinée-Bissau", "Guyana", "Haïti", "Honduras", 
            "Hongrie", "Îles Marshall", "Îles Salomon", "Inde", "Indonésie", "Irak", "Iran", "Irlande", "Islande", 
            "Israël", "Italie", "Jamaïque", "Japon", "Jordanie", "Kazakhstan", "Kenya", "Kirghizistan", "Kiribati", 
            "Koweït", "Laos", "Lesotho", "Lettonie", "Liban", "Liberia", "Libye", "Liechtenstein", "Lituanie", 
            "Luxembourg", "Macédoine du Nord", "Madagascar", "Malaisie", "Malawi", "Maldives", "Mali", "Malte", 
            "Maroc", "Maurice", "Mauritanie", "Mexique", "Micronésie", "Moldavie", "Monaco", "Mongolie", "Monténégro", 
            "Mozambique", "Namibie", "Nauru", "Népal", "Nicaragua", "Niger", "Nigeria", "Niue", "Norvège", 
            "Nouvelle-Zélande", "Oman", "Ouganda", "Ouzbékistan", "Pakistan", "Palaos", "Palestine", "Panama", 
            "Papouasie-Nouvelle-Guinée", "Paraguay", "Pays-Bas", "Pérou", "Philippines", "Pologne", "Portugal", 
            "Qatar", "République centrafricaine", "République démocratique du Congo", "République dominicaine", 
            "République tchèque", "Roumanie", "Royaume-Uni", "Russie", "Rwanda", "Saint-Kitts-et-Nevis", "Saint-Marin", 
            "Saint-Vincent-et-les-Grenadines", "Sainte-Lucie", "Salvador", "Samoa", "São Tomé-et-Principe", "Sénégal", 
            "Serbie", "Seychelles", "Sierra Leone", "Singapour", "Slovaquie", "Slovénie", "Somalie", "Soudan", 
            "Soudan du Sud", "Sri Lanka", "Suède", "Suisse", "Suriname", "Syrie", "Tadjikistan", "Tanzanie", "Tchad", 
            "Thaïlande", "Timor oriental", "Togo", "Tonga", "Trinité-et-Tobago", "Tunisie", "Turkménistan", "Turquie", 
            "Tuvalu", "Ukraine", "Uruguay", "Vanuatu", "Vatican", "Venezuela", "Viêt Nam", "Yémen", "Zambie", "Zimbabwe"
        ];
        
        // Fonction pour afficher les résultats d'autocomplétion des pays
        function showCountryResults(query) {
            countryResults.innerHTML = '';
            countryResults.style.display = 'none';
            
            if (!query) return;
            
            const filteredCountries = countries.filter(country => 
                country.toLowerCase().includes(query.toLowerCase())
            );
            
            if (filteredCountries.length === 0) return;
            
            filteredCountries.forEach(country => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = country;
                item.addEventListener('click', () => {
                    paysField.value = country;
                    countryCodeField.value = country;
                    countryResults.style.display = 'none';
                    
                    // Activer le champ ville
                    villeField.disabled = false;
                    villeField.placeholder = "Sélectionner une ville...";
                    
                    // Simuler un événement input pour déclencher d'autres comportements
                    const event = new Event('input', { bubbles: true });
                    paysField.dispatchEvent(event);
                });
                countryResults.appendChild(item);
            });
            
            countryResults.style.display = 'block';
        }
        
        // Fonction pour simuler les résultats d'autocomplétion des villes
        function showCityResults(country, query) {
            cityResults.innerHTML = '';
            cityResults.style.display = 'none';
            
            if (!query || !country) return;
            
            // Simuler un délai de chargement
            citySpinner.style.display = 'block';
            
            // Exemple de villes pour quelques pays (à remplacer par votre propre source de données)
            const citiesByCountry = {
                "France": ["Paris", "Marseille", "Lyon", "Toulouse", "Nice", "Nantes", "Strasbourg", "Montpellier", "Bordeaux", "Lille"],
                "Maroc": ["Casablanca", "Rabat", "Marrakech", "Fès", "Tanger", "Agadir", "Meknès", "Oujda", "Tétouan", "Kénitra"],
                "Canada": ["Toronto", "Montréal", "Vancouver", "Calgary", "Edmonton", "Ottawa", "Québec", "Winnipeg", "Hamilton", "Halifax"],
                "États-Unis": ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphie", "San Antonio", "San Diego", "Dallas", "San José"],
                "Royaume-Uni": ["Londres", "Birmingham", "Manchester", "Glasgow", "Liverpool", "Bristol", "Édimbourg", "Leeds", "Sheffield", "Leicester"]
            };
            
            // Simuler un délai de chargement
            setTimeout(() => {
                citySpinner.style.display = 'none';
                
                // Si le pays est dans notre liste, afficher ses villes
                if (citiesByCountry[country]) {
                    const filteredCities = citiesByCountry[country].filter(city => 
                        city.toLowerCase().includes(query.toLowerCase())
                    );
                    
                    if (filteredCities.length === 0) return;
                    
                    filteredCities.forEach(city => {
                        const item = document.createElement('div');
                        item.className = 'autocomplete-item';
                        item.textContent = city;
                        item.addEventListener('click', () => {
                            villeField.value = city;
                            cityIdField.value = city;
                            cityResults.style.display = 'none';
                        });
                        cityResults.appendChild(item);
                    });
                    
                    cityResults.style.display = 'block';
                } else {
                    // Si le pays n'est pas dans notre liste, permettre la saisie libre
                    cityIdField.value = villeField.value;
                }
            }, 500);
        }
        
        // Événements pour le champ pays
        paysField.addEventListener('input', function() {
            const query = this.value.trim();
            showCountryResults(query);
            
            if (query) {
                countryCodeField.value = query;
                villeField.disabled = false;
                villeField.placeholder = "Sélectionner une ville...";
            } else {
                countryCodeField.value = "";
                villeField.disabled = true;
                villeField.value = "";
                cityIdField.value = "";
                villeField.placeholder = "Sélectionner d'abord un pays...";
            }
        });
        
        paysField.addEventListener('focus', function() {
            if (this.value.trim()) {
                showCountryResults(this.value.trim());
            }
        });
        
        // Événements pour le champ ville
        villeField.addEventListener('input', function() {
            const query = this.value.trim();
            const country = paysField.value.trim();
            showCityResults(country, query);
            
            if (query) {
                cityIdField.value = query;
            } else {
                cityIdField.value = "";
            }
        });
        
        villeField.addEventListener('focus', function() {
            if (this.value.trim() && paysField.value.trim()) {
                showCityResults(paysField.value.trim(), this.value.trim());
            }
        });
        
        // Événements pour les boutons de suppression
        clearCountryBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            paysField.value = '';
            countryCodeField.value = '';
            countryResults.style.display = 'none';
            
            // Désactiver et réinitialiser le champ ville
            villeField.disabled = true;
            villeField.value = '';
            cityIdField.value = '';
            villeField.placeholder = "Sélectionner d'abord un pays...";
        });
        
        clearCityBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            villeField.value = '';
            cityIdField.value = '';
            cityResults.style.display = 'none';
        });
        
        // Fermer les résultats d'autocomplétion quand on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!paysField.contains(e.target) && !countryResults.contains(e.target)) {
                countryResults.style.display = 'none';
            }
            
            if (!villeField.contains(e.target) && !cityResults.contains(e.target)) {
                cityResults.style.display = 'none';
            }
        });
    });
</script>
@endsection
"
voici le fichier views/candidat/skillcreat.blade.php : 
"@extends('layouts.candidat')

@section('title', 'Sélectionner des compétences')
@section('styles')
<style>
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        font-weight: 500;
        margin-bottom: 0.5rem;
        color: #374151;
    }
    
    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        border-color: #2557a7;
        outline: none;
        box-shadow: 0 0 0 3px rgba(37, 87, 167, 0.1);
    }
    
    .btn-save {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #2557a7;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-save:hover {
        background-color: #1e4b8f;
    }
    
    .btn-cancel {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 1rem;
    }
    
    .btn-cancel:hover {
        background-color: #e5e7eb;
    }
    
    .form-section {
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        padding: 1.5rem;
        background-color: white;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        margin-bottom: 2rem;
    }
    
    .form-section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .search-container {
        position: relative;
        margin-bottom: 1.5rem;
    }
    
    .search-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    
    .search-input {
        padding-left: 2.5rem;
    }
    
    .skills-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 0.75rem;
        margin-top: 1.5rem;
    }
    
    .skill-item {
        position: relative;
        padding: 0.75rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.375rem;
        background-color: #f9fafb;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .skill-item:hover {
        background-color: #f3f4f6;
        border-color: #d1d5db;
    }
    
    .skill-item.selected {
        background-color: #dbeafe;
        border-color: #93c5fd;
    }
    
    .skill-checkbox {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .skill-name {
        display: flex;
        align-items: center;
    }
    
    .skill-name::before {
        content: '';
        display: inline-block;
        width: 1rem;
        height: 1rem;
        margin-right: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        background-color: #fff;
    }
    
    .skill-item.selected .skill-name::before {
        background-color: #2557a7;
        border-color: #2557a7;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 20 20' fill='white'%3e%3cpath fill-rule='evenodd' d='M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z' clip-rule='evenodd'/%3e%3c/svg%3e");
    }
    
    .selected-skills {
        margin-top: 1.5rem;
        padding: 1rem;
        background-color: #f3f4f6;
        border-radius: 0.375rem;
    }
    
    .selected-skills-title {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.75rem;
    }
    
    .selected-skill-tag {
        display: inline-flex;
        align-items: center;
        background-color: #dbeafe;
        border: 1px solid #93c5fd;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        margin-right: 0.5rem;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        color: #1e40af;
    }
    
    .remove-skill {
        margin-left: 0.5rem;
        cursor: pointer;
        color: #1e40af;
    }
    
    .no-results {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
        font-style: italic;
    }
    
    .loading {
        text-align: center;
        padding: 1rem;
        color: #6b7280;
    }
    
    .spinner {
        display: inline-block;
        width: 1.5rem;
        height: 1.5rem;
        border: 2px solid #e5e7eb;
        border-radius: 50%;
        border-top-color: #2557a7;
        animation: spin 1s linear infinite;
        margin-right: 0.5rem;
    }
    
    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }
</style>
@endsection

@section('content')
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Sélectionner des compétences</h1>
        <p class="mt-2 text-gray-600">Choisissez les compétences que vous souhaitez ajouter à votre CV.</p>
    </div>
    
    @if ($errors->any())
    <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
    
    <form action="{{ route('resumes.skills.store', $resume->id) }}" method="POST" id="skills-form">
        @csrf
        
        <div class="form-section">
            <h2 class="form-section-title">Rechercher des compétences</h2>
            
            <div class="search-container">
                <div class="search-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input type="text" id="search-skills" class="form-input search-input" placeholder="Rechercher des compétences...">
            </div>
            
            <div id="skills-list" class="skills-container">
                @foreach($skills->take(5) as $skill)
                    <label class="skill-item {{ $selectedSkills->contains($skill->id) ? 'selected' : '' }}">                        
                        <input type="checkbox" name="skills[]" value="{{ $skill->id }}" 
                            {{ $selectedSkills->contains($skill->id) ? 'checked' : '' }} class="skill-checkbox">                        
                        <span class="skill-name">{{ $skill->name }}</span>
                    </label>
                @endforeach
            </div>
            
            <div id="loading" class="loading" style="display: none;">
                <div class="spinner"></div>
                <span>Chargement des compétences...</span>
            </div>
            
            <div id="no-results" class="no-results" style="display: none;">
                <p>Aucune compétence trouvée. Vous pouvez ajouter une nouvelle compétence ci-dessous.</p>
            </div>
            
            <!-- <div class="mt-6">
                <div class="form-group">
                    <label for="new-skill" class="form-label">Ajouter une nouvelle compétence</label>
                    <div class="flex">
                        <input type="text" id="new-skill" name="new_skill" class="form-input rounded-r-none" placeholder="Saisissez une nouvelle compétence">
                        <button type="button" id="add-skill-btn" class="btn-save rounded-l-none">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                    <p class="form-help-text">Si vous ne trouvez pas une compétence dans la liste, vous pouvez l'ajouter ici.</p>
                </div>
            </div> -->
            
            <div id="selected-skills-container" class="selected-skills" style="{{ count($selectedSkills) > 0 ? '' : 'display: none;' }}">
                <div class="selected-skills-title">Compétences sélectionnées</div>
                <div id="selected-skills-list" class="flex flex-wrap">
                    @foreach($selectedSkills as $skill)
                        <div class="selected-skill-tag" data-skill-id="{{ $skill->id }}">
                            {{ $skill->name }}
                            <span class="remove-skill" data-skill-id="{{ $skill->id }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        
        <div class="flex justify-end mt-8">
            <a href="{{ route('resume.view', $resume->id) }}" class="btn-cancel">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                </svg>
                Annuler
            </a>
            <button type="submit" class="btn-save">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Enregistrer
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-skills');
        const skillsList = document.getElementById('skills-list');
        const loadingElement = document.getElementById('loading');
        const noResultsElement = document.getElementById('no-results');
        const newSkillInput = document.getElementById('new-skill');
        const addSkillBtn = document.getElementById('add-skill-btn');
        const selectedSkillsContainer = document.getElementById('selected-skills-container');
        const selectedSkillsList = document.getElementById('selected-skills-list');
        const form = document.getElementById('skills-form');
        
        // Ensemble pour suivre les compétences sélectionnées
        const selectedSkills = new Set();
        
        // Initialiser les compétences déjà sélectionnées
        document.querySelectorAll('.skill-item.selected').forEach(item => {
            const checkbox = item.querySelector('.skill-checkbox');
            if (checkbox && checkbox.checked) {
                selectedSkills.add(checkbox.value);
            }
        });
        
        // Fonction pour mettre à jour l'affichage des compétences sélectionnées
        function updateSelectedSkillsDisplay() {
            if (selectedSkills.size > 0) {
                selectedSkillsContainer.style.display = '';
            } else {
                selectedSkillsContainer.style.display = 'none';
            }
        }
        
        // Fonction pour rechercher des compétences
        function searchSkills(query) {
            loadingElement.style.display = '';
            skillsList.style.display = 'none';
            noResultsElement.style.display = 'none';
            
            // Simuler un délai de chargement (à remplacer par un appel AJAX réel)
            setTimeout(() => {
                fetch(`/api/skills/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        loadingElement.style.display = 'none';
                        
                        if (data.skills.length === 0) {
                            noResultsElement.style.display = '';
                            skillsList.style.display = 'none';
                        } else {
                            noResultsElement.style.display = 'none';
                            skillsList.style.display = 'grid';
                            
                            // Effacer la liste actuelle
                            skillsList.innerHTML = '';
                            
                            // Ajouter les compétences trouvées
                            data.skills.forEach(skill => {
                                const isSelected = selectedSkills.has(skill.id.toString());
                                
                                const skillItem = document.createElement('label');
                                skillItem.className = `skill-item ${isSelected ? 'selected' : ''}`;
                                
                                const checkbox = document.createElement('input');
                                checkbox.type = 'checkbox';
                                checkbox.name = 'skills[]';
                                checkbox.value = skill.id;
                                checkbox.className = 'skill-checkbox';
                                checkbox.checked = isSelected;
                                
                                const skillName = document.createElement('span');
                                skillName.className = 'skill-name';
                                skillName.textContent = skill.name;
                                
                                skillItem.appendChild(checkbox);
                                skillItem.appendChild(skillName);
                                skillsList.appendChild(skillItem);
                                
                                // Ajouter l'événement de changement
                                checkbox.addEventListener('change', handleSkillSelection);
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Erreur lors de la recherche de compétences:', error);
                        loadingElement.style.display = 'none';
                        noResultsElement.style.display = '';
                        skillsList.style.display = 'none';
                    });
            }, 500);
        }
        
        // Fonction pour gérer la sélection d'une compétence
        function handleSkillSelection(event) {
            const checkbox = event.target;
            const skillItem = checkbox.closest('.skill-item');
            const skillId = checkbox.value;
            const skillName = skillItem.querySelector('.skill-name').textContent;
            
            if (checkbox.checked) {
                // Ajouter la compétence à la liste des sélectionnées
                selectedSkills.add(skillId);
                skillItem.classList.add('selected');
                
                // Ajouter le tag de compétence sélectionnée
                const skillTag = document.createElement('div');
                skillTag.className = 'selected-skill-tag';
                skillTag.dataset.skillId = skillId;
                skillTag.innerHTML = `
                    ${skillName}
                    <span class="remove-skill" data-skill-id="${skillId}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                        </svg>
                    </span>
                `;
                selectedSkillsList.appendChild(skillTag);
                
                // Ajouter l'événement de suppression
                skillTag.querySelector('.remove-skill').addEventListener('click', handleRemoveSkill);
            } else {
                // Supprimer la compétence de la liste des sélectionnées
                selectedSkills.delete(skillId);
                skillItem.classList.remove('selected');
                
                // Supprimer le tag de compétence
                const skillTag = selectedSkillsList.querySelector(`.selected-skill-tag[data-skill-id="${skillId}"]`);
                if (skillTag) {
                    skillTag.remove();
                }
            }
            
            updateSelectedSkillsDisplay();
        }
        
        // Fonction pour gérer la suppression d'une compétence
        function handleRemoveSkill(event) {
            const skillId = event.currentTarget.dataset.skillId;
            
            // Supprimer la compétence de la liste des sélectionnées
            selectedSkills.delete(skillId);
            
            // Décocher la case à cocher correspondante
            const checkbox = document.querySelector(`.skill-checkbox[value="${skillId}"]`);
            if (checkbox) {
                checkbox.checked = false;
                checkbox.closest('.skill-item').classList.remove('selected');
            }
            
            // Supprimer le tag de compétence
            const skillTag = event.currentTarget.closest('.selected-skill-tag');
            if (skillTag) {
                skillTag.remove();
            }
            
            updateSelectedSkillsDisplay();
        }
        
        // Fonction pour ajouter une nouvelle compétence
        function addNewSkill() {
            const skillName = newSkillInput.value.trim();
            
            if (!skillName) {
                return;
            }
            
            // Simuler l'ajout d'une nouvelle compétence (à remplacer par un appel AJAX réel)
            fetch('/api/skills', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({ name: skillName })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const skill = data.skill;
                    
                    // Ajouter la compétence à la liste
                    const skillItem = document.createElement('label');
                    skillItem.className = 'skill-item selected';
                    
                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'skills[]';
                    checkbox.value = skill.id;
                    checkbox.className = 'skill-checkbox';
                    checkbox.checked = true;
                    
                    const skillNameElement = document.createElement('span');
                    skillNameElement.className = 'skill-name';
                    skillNameElement.textContent = skill.name;
                    
                    skillItem.appendChild(checkbox);
                    skillItem.appendChild(skillNameElement);
                    skillsList.appendChild(skillItem);
                    
                    // Ajouter l'événement de changement
                    checkbox.addEventListener('change', handleSkillSelection);
                    
                    // Ajouter la compétence à la liste des sélectionnées
                    selectedSkills.add(skill.id.toString());
                    
                    // Ajouter le tag de compétence sélectionnée
                    const skillTag = document.createElement('div');
                    skillTag.className = 'selected-skill-tag';
                    skillTag.dataset.skillId = skill.id;
                    skillTag.innerHTML = `
                        ${skill.name}
                        <span class="remove-skill" data-skill-id="${skill.id}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    `;
                    selectedSkillsList.appendChild(skillTag);
                    
                    // Ajouter l'événement de suppression
                    skillTag.querySelector('.remove-skill').addEventListener('click', handleRemoveSkill);
                    
                    // Mettre à jour l'affichage
                    updateSelectedSkillsDisplay();
                    
                    // Réinitialiser le champ de saisie
                    newSkillInput.value = '';
                    
                    // Afficher la liste des compétences si elle était cachée
                    noResultsElement.style.display = 'none';
                    skillsList.style.display = 'grid';
                }
            })
            .catch(error => {
                console.error('Erreur lors de l\'ajout d\'une compétence:', error);
            });
        }
        
        // Ajouter les écouteurs d'événements
        searchInput.addEventListener('input', function() {
            const query = this.value.trim();
            if (query.length >= 2) {
                searchSkills(query);
            } else if (query.length === 0) {
                // Réinitialiser la recherche
                loadingElement.style.display = 'none';
                noResultsElement.style.display = 'none';
                skillsList.style.display = 'grid';
            }
        });
        
        // Ajouter l'événement de sélection aux compétences initiales
        document.querySelectorAll('.skill-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', handleSkillSelection);
        });
        
        // Ajouter l'événement de suppression aux compétences sélectionnées initiales
        document.querySelectorAll('.remove-skill').forEach(button => {
            button.addEventListener('click', handleRemoveSkill);
        });
        
        // Ajouter l'événement pour ajouter une nouvelle compétence
        addSkillBtn.addEventListener('click', addNewSkill);
        
        // Ajouter l'événement pour ajouter une nouvelle compétence en appuyant sur Entrée
        newSkillInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
                addNewSkill();
            }
        });
        
        // Mettre à jour l'affichage initial
        updateSelectedSkillsDisplay();
    });
</script>
@endsection

"

voici le fichier views/layouts/admin.blade.php : 
"<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WorkBridge') - Administration</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        
        .btn-primary {
            background-color: #4f46e5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
        }
        
        .nav-link {
            color: #374151;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
            transition: background-color 0.2s, color 0.2s;
        }
        
        .nav-link:hover {
            background-color: #f3f4f6;
        }
        
        .nav-link.active {
            background-color: #4f46e5;
            color: white;
            font-weight: 500;
        }
        
        .nav-icon {
            margin-right: 0.75rem;
            width: 1.25rem;
            text-align: center;
        }
        
        .badge {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            background-color: #ef4444;
            color: white;
            font-size: 0.75rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            background-color: white;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 12rem;
            z-index: 50;
            overflow: hidden;
        }
        
        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            color: #374151;
            transition: background-color 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: #f3f4f6;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="p-4 flex items-center">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-2 text-white font-bold text-xl">
                    WB
                </div>
                <span class="text-xl font-bold text-gray-900">WorkBridge</span>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-gray-200 my-2"></div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 px-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line nav-icon"></i>
                    <span>Statistiques</span>
                </a>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fas fa-users nav-icon"></i>
                    <span>Gestion des utilisateurs</span>
                </a>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.offers*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase nav-icon"></i>
                    <span>Gestion des offres</span>
                </a>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.companies*') ? 'active' : '' }}">
                    <i class="fas fa-building nav-icon"></i>
                    <span>Entreprises</span>
                </a>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.skills*') ? 'active' : '' }}">
                    <i class="fas fa-tags nav-icon"></i>
                    <span>Compétences</span>
                </a>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.languages*') ? 'active' : '' }}">
                    <i class="fas fa-language nav-icon"></i>
                    <span>Langues</span>
                </a>
            </nav>
            
            <!-- Bottom Links -->
            <div class="px-2 mb-6">
                <div class="border-t border-gray-200 my-2"></div>
                
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog nav-icon"></i>
                    <span>Paramètres</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 py-4 px-6 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-800">@yield('header-title', 'Tableau de bord')</h1>
                
                <div class="flex items-center space-x-6">
                    <!-- Notifications -->
                    <div class="relative">
                        <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:text-gray-900 relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="badge">3</span>
                        </a>
                    </div>
                    
                    <!-- Logout Button -->
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="flex items-center text-gray-700 hover:text-gray-900">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            <span>Déconnexion</span>
                        </button>
                    </form>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} WorkBridge, Inc. Tous droits réservés.
            </footer>
        </div>
    </div>

    <!-- Alpine.js for dropdown functionality -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @yield('scripts')
</body>
</html>

"
voici le fichier views/layouts/auth.blade.php : 
"<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WorkBridge') - Connect with Top Talent</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .auth-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .form-input {
            @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500;
        }
        .btn-primary {
            @apply bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
        }
        .btn-secondary {
            @apply bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
        }
        .btn-outline {
            @apply border border-indigo-500 text-indigo-600 hover:bg-indigo-50 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="/" class="flex-shrink-0 flex items-center">
                        <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-2">
                            <span class="text-xl font-bold text-white">WB</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900">WorkBridge</span>
                    </a>
                </div>
                <div class="flex items-center">
                    @if(Route::has('login') && Route::has('register'))
                        @auth
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Déconnexion</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium">Log in</a>
                            <a href="{{ route('register') }}" class="ml-4 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">Register</a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-6 px-4 overflow-hidden sm:px-6 lg:px-8">
            <p class="text-center text-base text-gray-400">
                &copy; 2023 WorkBridge, Inc. All rights reserved.
            </p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
"
voici le fichier views/layouts/candidat.blade.php : 
"<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'WorkBridge') - Connect with Top Talent</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        .auth-card {
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        .form-input {
            @apply mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500;
        }
        .btn-primary {
            @apply bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
        }
        .btn-secondary {
            @apply bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
        }
        .btn-outline {
            @apply border border-indigo-500 text-indigo-600 hover:bg-indigo-50 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
        }
        .nav-link {
            @apply text-gray-700 hover:text-indigo-600 px-3 py-2 text-sm font-medium;
        }
        .nav-link.active {
            @apply text-indigo-600 border-b-2 border-indigo-600;
        }
        .nav-icon {
            @apply text-gray-700 hover:text-indigo-600 p-2 rounded-full hover:bg-gray-100;
        }
    </style>
    @yield('styles')
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">
    <!-- Header -->
    <header class="bg-white shadow-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a href="{{ route('home') }}" class="flex-shrink-0 flex items-center">
                        <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-2">
                            <span class="text-xl font-bold text-white">WB</span>
                        </div>
                        <span class="text-xl font-bold text-gray-900">WorkBridge</span>
                    </a>
                    
                    <!-- Navigation Links -->
                    <div class="hidden md:flex space-x-6">
                        <a href="{{ route('candidat.offres.index') }}" class="nav-link {{ request()->routeIs('candidat.offres.index') ? 'active' : '' }}">
                            Page d'accueil
                        </a>
                        
                        <!-- <a href="{{ route('saved.jobs') }}" class="nav-link {{ request()->routeIs('saved.jobs') ? 'active' : '' }}">
                            Postes enregistrés
                        </a> -->
                    </div>
                </div>
                
                <!-- Right Side Icons -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('messages') }}" class="nav-icon" title="Messages">
                        <i class="fas fa-comment-alt"></i>
                    </a>
                    <a href="{{ route('notifications') }}" class="nav-icon" title="Notifications">
                        <i class="fas fa-bell"></i>
                    </a>
                    <div class="relative">
                        <a href="{{ route('profile') }}" class="nav-icon" title="Profil">
                            <i class="fas fa-user-circle text-xl"></i>
                        </a>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="ml-2">
                        @csrf
                        <button type="submit" class="nav-link">Déconnexion</button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white">
        <div class="max-w-7xl mx-auto py-6 px-4 overflow-hidden sm:px-6 lg:px-8">
            <p class="text-center text-base text-gray-400">
                &copy; 2023 WorkBridge, Inc. All rights reserved.
            </p>
        </div>
    </footer>

    @yield('scripts')
</body>
</html>
"
voici le fichier views/layouts/recruteur.blade.php : 
"<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'WorkBridge') - Espace Employeur</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f9fafb;
        }
        
        .btn-primary {
            background-color: #4f46e5;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #4338ca;
        }
        
        .nav-link {
            color: #374151;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            border-radius: 0.375rem;
            margin-bottom: 0.25rem;
            transition: background-color 0.2s;
        }
        
        .nav-link:hover {
            background-color: #f3f4f6;
        }
        
        .nav-link.active {
            background-color: #f3f4f6;
            color: #4f46e5;
            font-weight: 500;
        }
        
        .nav-icon {
            margin-right: 0.75rem;
            width: 1.25rem;
            text-align: center;
        }
        
        .badge {
            position: absolute;
            top: -0.25rem;
            right: -0.25rem;
            background-color: #ef4444;
            color: white;
            font-size: 0.75rem;
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 0.5rem;
            background-color: white;
            border-radius: 0.375rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            width: 12rem;
            z-index: 50;
            overflow: hidden;
        }
        
        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            color: #374151;
            transition: background-color 0.2s;
        }
        
        .dropdown-item:hover {
            background-color: #f3f4f6;
        }
    </style>
    @yield('styles')
</head>
<body>
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="p-4 flex items-center">
                <div class="w-10 h-10 bg-indigo-600 rounded-lg flex items-center justify-center mr-2 text-white font-bold text-xl">
                    WB
                </div>
                <span class="text-xl font-bold text-gray-900">WorkBridge</span>
            </div>
            
            <!-- Divider -->
            <div class="border-t border-gray-200 my-2"></div>
            
            <!-- Create Button -->
            <div class="px-4 mb-4">
                <a href="{{ route('offers.create') }}" class="flex items-center justify-between w-full bg-indigo-600 hover:bg-indigo-700 text-white py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    <span>Créer</span>
                    <i class="fas fa-plus"></i>
                </a>
            </div>
            
            <!-- Navigation Links -->
            <nav class="flex-1 px-2">
                <a href="{{ route('offers.index') }}" class="nav-link {{ request()->routeIs('offre') && !request()->routeIs('offre.create') ? 'active' : '' }}">
                    <i class="fas fa-briefcase nav-icon"></i>
                    <span>Emplois</span>
                </a>
                
                <a href="{{ route('offers.index') }}" class="nav-link {{ request()->routeIs('candidature*') ? 'active' : '' }}">
                    <i class="fas fa-user-tie nav-icon"></i>
                    <span>Candidatures</span>
                </a>
                
                <a href="{{ route('offers.index') }}" class="nav-link {{ request()->routeIs('entretien*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check nav-icon"></i>
                    <span>Entretiens</span>
                </a>
                
                <a href="{{ route('offers.index') }}" class="nav-link {{ request()->routeIs('analyse*') ? 'active' : '' }}">
                    <i class="fas fa-chart-bar nav-icon"></i>
                    <span>Analyses</span>
                </a>
            </nav>
            
            <!-- Bottom Links -->
            <div class="px-2 mb-6">
                <div class="border-t border-gray-200 my-2"></div>
                
                <a href="{{ route('recruiter.profile') }}" class="nav-link {{ request()->routeIs('recruiter.profile*') ? 'active' : '' }}">
                    <i class="fas fa-building nav-icon"></i>
                    <span>Profil Entreprise</span>
                </a>
                
                <a href="{{ route('recruiter.profile') }}" class="nav-link {{ request()->routeIs('employer.settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog nav-icon"></i>
                    <span>Paramètres</span>
                </a>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col">
            <!-- Header -->
            <header class="bg-white border-b border-gray-200 py-4 px-6 flex items-center justify-between">
                <h1 class="text-xl font-semibold text-gray-800">@yield('header-title', 'Tableau de bord')</h1>
                
                <div class="flex items-center space-x-6">
                    <!-- Messages -->
                    <div class="relative">
                        <a href="{{ route('messages') }}" class="text-gray-600 hover:text-gray-900 relative">
                            <i class="fas fa-comment-alt text-xl"></i>
                            <span class="badge">2</span>
                        </a>
                    </div>
                    
                    <!-- Notifications -->
                    <div class="relative">
                        <a href="{{ route('notifications') }}" class="text-gray-600 hover:text-gray-900 relative">
                            <i class="fas fa-bell text-xl"></i>
                            <span class="badge">3</span>
                        </a>
                    </div>
                    
                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 hover:text-gray-900">
                            <img src="https://ui-avatars.com/api/?name=T&background=4f46e5&color=fff" alt="Profile" class="h-8 w-8 rounded-full">
                            <span class="font-medium">testo</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" class="dropdown-menu">
                            <a href="{{ route('recruiter.profile') }}" class="dropdown-item">
                                <i class="fas fa-user-circle mr-2"></i> Profil
                            </a>
                            <div class="border-t border-gray-200"></div>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item w-full text-left">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Déconnexion
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="flex-1 p-6 bg-gray-50 overflow-y-auto">
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                @yield('content')
            </main>
            
            <!-- Footer -->
            <footer class="bg-white border-t border-gray-200 py-4 px-6 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} WorkBridge, Inc. Tous droits réservés.
            </footer>
        </div>
    </div>

    <!-- Alpine.js for dropdown functionality -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    @yield('scripts')
</body>
</html>
"

voici le fichier views/recruter/companiecreat.blade.php : 
"@extends('layouts.auth')

@section('title', 'Informations Recruteur')

@section('styles')
<style>
    body {
        font-family: 'Inter', sans-serif;
        background-color: #f3f4f6;
    }
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    .input-field {
        transition: all 0.3s ease;
    }
    .input-field:focus {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    .btn-primary {
        background-color: #4f46e5;
        color: white;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background-color: #4338ca;
    }
    .autocomplete-results {
        position: absolute;
        z-index: 10;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-top: 0.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: none;
    }
    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    .autocomplete-item:hover {
        background-color: #f3f4f6;
    }
    .autocomplete-item.active {
        background-color: #e5e7eb;
    }
    .spinner {
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid #4f46e5;
        width: 16px;
        height: 16px;
        animation: spin 1s linear infinite;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        display: none;
    }
    @keyframes spin {
        0% { transform: translateY(-50%) rotate(0deg); }
        100% { transform: translateY(-50%) rotate(360deg); }
    }
    .input-with-icon {
        position: relative;
    }
    .input-with-icon .spinner {
        right: 12px;
    }
    .input-with-icon .clear-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        cursor: pointer;
        display: none;
    }
    .input-with-icon input:focus + .clear-btn,
    .input-with-icon input:not(:placeholder-shown) + .clear-btn {
        display: block;
    }
    .input-with-icon input:focus + .clear-btn + .spinner,
    .input-with-icon input:not(:placeholder-shown) + .clear-btn + .spinner {
        right: 36px;
    }
</style>
@endsection

@section('content')
<div class="w-full max-w-3xl">
    <div class="bg-white py-8 px-6 shadow-xl rounded-xl">
        <div class="text-center mb-8">
            <h2 class="text-3xl font-extrabold text-gray-900">Ajouter les informations de base</h2>
            <p class="mt-2 text-sm text-gray-600">
                Ces informations nous aideront à mieux comprendre votre entreprise
            </p>
        </div>

        @if ($errors->any())
            <div class="mb-4 bg-red-50 border border-red-200 text-sm text-red-600 rounded-md p-4">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('company.store') }}" id="recruiter-form" class="space-y-6">
            @csrf

            <!-- Nom de l'entreprise -->
            <div class="form-group">
                <label for="name" class="form-label">Nom de l'entreprise</label>
                <input id="name" name="name" type="text" required value="{{ old('name') }}"
                    class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pays et Ville (sur la même ligne) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="country" class="form-label">Pays</label>
                    <div class="input-with-icon">
                        <input id="country" name="pays" type="text" required value="{{ old('pays') }}"
                            class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('pays') border-red-500 @enderror"
                            placeholder="Sélectionner un pays...">
                        <span class="clear-btn" id="clear-country">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="country-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="country-results"></div>
                    <input type="hidden" id="country-code" name="country_code" value="{{ old('country_code') }}">
                    @error('pays')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="city" class="form-label">Ville</label>
                    <div class="input-with-icon">
                        <input id="city" name="ville" type="text" required value="{{ old('ville') }}"
                            class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('ville') border-red-500 @enderror"
                            placeholder="Sélectionner une ville..." {{ old('pays') ? '' : 'disabled' }}>
                        <span class="clear-btn" id="clear-city">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="city-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="city-results"></div>
                    <input type="hidden" id="city-id" name="city_id" value="{{ old('city_id') }}">
                    @error('ville')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Secteur et Taille (sur la même ligne) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="sector" class="form-label">Secteur d'activité</label>
                    <div class="input-with-icon">
                        <input id="sector" name="sector" type="text" required value="{{ old('sector') }}"
                            class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('sector') border-red-500 @enderror"
                            placeholder="Sélectionner un secteur...">
                        <span class="clear-btn" id="clear-sector">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="sector-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="sector-results"></div>
                    <input type="hidden" id="sector-code" name="sector_code" value="{{ old('sector_code') }}">
                    @error('sector')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="size" class="form-label">Taille de l'entreprise</label>
                    <select id="size" name="size" required
                        class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('size') border-red-500 @enderror">
                        <option value="">Sélectionnez une taille</option>
                        <option value="1-10" {{ old('size') == '1-10' ? 'selected' : '' }}>1-10 employés</option>
                        <option value="11-50" {{ old('size') == '11-50' ? 'selected' : '' }}>11-50 employés</option>
                        <option value="51-200" {{ old('size') == '51-200' ? 'selected' : '' }}>51-200 employés</option>
                        <option value="201-500" {{ old('size') == '201-500' ? 'selected' : '' }}>201-500 employés</option>
                        <option value="501-1000" {{ old('size') == '501-1000' ? 'selected' : '' }}>501-1000 employés</option>
                        <option value="1001+" {{ old('size') == '1001+' ? 'selected' : '' }}>Plus de 1000 employés</option>
                    </select>
                    @error('size')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Site web -->
            <div class="form-group">
                <label for="website" class="form-label">Site web</label>
                <div class="flex rounded-lg shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        https://
                    </span>
                    <input id="website" name="website_domain" type="text" value="{{ old('website_domain') }}"
                        class="input-field flex-1 block w-full rounded-none rounded-r-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('website') border-red-500 @enderror"
                        placeholder="www.votreentreprise.com">
                    <input type="hidden" id="website-full" name="website" value="{{ old('website') }}">
                </div>
                @error('website')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">Description de l'entreprise</label>
                <textarea id="description" name="description" rows="4" 
                    class="input-field block w-full rounded-lg border-gray-300 shadow-sm py-3 px-4 border focus:outline-none @error('description') border-red-500 @enderror"
                    placeholder="Décrivez brièvement votre entreprise, ses activités et sa culture...">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 mt-1">Maximum 500 caractères</p>
                <p class="text-sm text-gray-500 mt-1" id="char-count">{{ old('description') ? strlen(old('description')) : '0' }}/500 caractères</p>
            </div>

            <div class="mt-8">
                <button type="submit" class="btn-primary w-full flex justify-center items-center">
                    Continuer
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du formulaire
        const form = document.getElementById('recruiter-form');
        const nameField = document.getElementById('name');
        const countryField = document.getElementById('country');
        const countryCodeField = document.getElementById('country-code');
        const cityField = document.getElementById('city');
        const cityIdField = document.getElementById('city-id');
        const sectorField = document.getElementById('sector');
        const sectorCodeField = document.getElementById('sector-code');
        const sizeField = document.getElementById('size');
        const websiteField = document.getElementById('website');
        const descriptionField = document.getElementById('description');
        
        // Résultats d'autocomplétion
        const countryResults = document.getElementById('country-results');
        const cityResults = document.getElementById('city-results');
        const sectorResults = document.getElementById('sector-results');
        
        // Spinners
        const countrySpinner = document.getElementById('country-spinner');
        const citySpinner = document.getElementById('city-spinner');
        const sectorSpinner = document.getElementById('sector-spinner');
        
        // Boutons de suppression
        const clearCountryBtn = document.getElementById('clear-country');
        const clearCityBtn = document.getElementById('clear-city');
        const clearSectorBtn = document.getElementById('clear-sector');
        
        // Compteur de caractères
        const charCount = document.getElementById('char-count');
        const maxLength = 500;
        
        // Mise à jour du compteur de caractères
        descriptionField.addEventListener('input', function() {
            const currentLength = this.value.length;
            charCount.textContent = `${currentLength}/${maxLength} caractères`;
            
            if (currentLength > maxLength) {
                this.value = this.value.substring(0, maxLength);
                charCount.textContent = `${maxLength}/${maxLength} caractères`;
                charCount.classList.add('text-red-500');
            } else {
                charCount.classList.remove('text-red-500');
            }
        });
        
        // Activer le champ ville dès que le pays est rempli
        countryField.addEventListener('input', function() {
            if (this.value.trim()) {
                cityField.disabled = false;
                cityField.placeholder = "Sélectionner une ville...";
                
                // Remplir le champ caché avec la même valeur
                countryCodeField.value = this.value.trim();
            } else {
                cityField.disabled = true;
                cityField.placeholder = "Sélectionner d'abord un pays...";
                countryCodeField.value = "";
            }
        });
        
        // Remplir les champs cachés avec les valeurs des champs visibles
        cityField.addEventListener('input', function() {
            cityIdField.value = this.value.trim();
        });
        
        sectorField.addEventListener('input', function() {
            sectorCodeField.value = this.value.trim();
        });
        
        // Événements pour les boutons de suppression
        clearCountryBtn.addEventListener('click', function() {
            countryField.value = '';
            countryCodeField.value = '';
            
            // Désactiver et réinitialiser le champ ville
            cityField.disabled = true;
            cityField.value = '';
            cityIdField.value = '';
            cityField.placeholder = 'Sélectionner d\'abord un pays...';
        });
        
        clearCityBtn.addEventListener('click', function() {
            cityField.value = '';
            cityIdField.value = '';
        });
        
        clearSectorBtn.addEventListener('click', function() {
            sectorField.value = '';
            sectorCodeField.value = '';
        });
        
        // Validation du formulaire avant soumission
        form.addEventListener('submit', function(event) {
            // Empêcher la soumission par défaut pour vérifier les champs
            event.preventDefault();
            
            let isValid = true;
            
            // Vérifier que le pays est sélectionné
            if (!countryField.value.trim()) {
                isValid = false;
                countryField.classList.add('border-red-500');
            }
            
            // Vérifier que la ville est sélectionnée
            if (!cityField.value.trim()) {
                isValid = false;
                cityField.classList.add('border-red-500');
            }
            
            // Vérifier que le secteur est sélectionné
            if (!sectorField.value.trim()) {
                isValid = false;
                sectorField.classList.add('border-red-500');
            }
            
            // Vérifier que la taille est sélectionnée
            if (!sizeField.value) {
                isValid = false;
                sizeField.classList.add('border-red-500');
            }
            
            // Gérer l'URL du site web
            if (websiteField.value.trim()) {
                // Construire l'URL complète
                const websiteUrl = 'https://' + websiteField.value.trim();
                document.getElementById('website-full').value = websiteUrl;
            }
            
            // Si tous les champs sont valides, soumettre le formulaire
            if (isValid) {
                // Assurez-vous que les champs cachés sont remplis avec les valeurs correctes
                if (!countryCodeField.value && countryField.value) {
                    countryCodeField.value = "MANUAL"; // Valeur par défaut si le code n'est pas disponible
                }
                
                if (!cityIdField.value && cityField.value) {
                    cityIdField.value = "MANUAL"; // Valeur par défaut si l'ID n'est pas disponible
                }
                
                if (!sectorCodeField.value && sectorField.value) {
                    sectorCodeField.value = "MANUAL"; // Valeur par défaut si le code n'est pas disponible
                }
                
                // Soumettre le formulaire
                this.submit();
            }
        });
    });
</script>
@endsection

"
voici le fichier views/recruter/companieedit.blade.php : 
"@extends('layouts.recruteur')

@section('title', 'Modifier les informations de l\'entreprise')

@section('header-title', 'Modifier les informations de l\'entreprise')

@section('styles')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-section {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    
    .form-input {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .form-select {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    .form-select:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .form-textarea {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        resize: vertical;
    }
    
    .form-textarea:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #4f46e5;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-primary:hover {
        background-color: #4338ca;
    }
    
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 1rem;
    }
    
    .btn-secondary:hover {
        background-color: #e5e7eb;
    }
    
    .autocomplete-results {
        position: absolute;
        z-index: 10;
        width: 100%;
        max-height: 200px;
        overflow-y: auto;
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        margin-top: 0.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: none;
    }
    
    .autocomplete-item {
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .autocomplete-item:hover {
        background-color: #f3f4f6;
    }
    
    .autocomplete-item.active {
        background-color: #e5e7eb;
    }
    
    .spinner {
        border: 2px solid #f3f3f3;
        border-radius: 50%;
        border-top: 2px solid #4f46e5;
        width: 16px;
        height: 16px;
        animation: spin 1s linear infinite;
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        display: none;
    }
    
    @keyframes spin {
        0% { transform: translateY(-50%) rotate(0deg); }
        100% { transform: translateY(-50%) rotate(360deg); }
    }
    
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon .spinner {
        right: 12px;
    }
    
    .input-with-icon .clear-btn {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        cursor: pointer;
        display: none;
    }
    
    .input-with-icon input:focus + .clear-btn,
    .input-with-icon input:not(:placeholder-shown) + .clear-btn {
        display: block;
    }
    
    .input-with-icon input:focus + .clear-btn + .spinner,
    .input-with-icon input:not(:placeholder-shown) + .clear-btn + .spinner {
        right: 36px;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
</style>
@endsection

@section('content')
<div class="form-container">
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('company.update', $company->id) }}" id="company-form">
        @csrf
        @method('PUT')
        
        <div class="form-section">
            <h2 class="section-title">Informations générales</h2>
            
            <!-- Nom de l'entreprise -->
            <div class="form-group">
                <label for="name" class="form-label">Nom de l'entreprise</label>
                <input id="name" name="name" type="text" required value="{{ old('name', $company->name) }}"
                    class="form-input @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pays et Ville (sur la même ligne) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="country" class="form-label">Pays</label>
                    <div class="input-with-icon">
                        <input id="country" name="pays" type="text" required value="{{ old('pays', $company->pays) }}"
                            class="form-input @error('pays') border-red-500 @enderror"
                            placeholder="Sélectionner un pays...">
                        <span class="clear-btn" id="clear-country">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="country-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="country-results"></div>
                    <input type="hidden" id="country-code" name="country_code" value="{{ old('country_code') }}">
                    @error('pays')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="city" class="form-label">Ville</label>
                    <div class="input-with-icon">
                        <input id="city" name="ville" type="text" required value="{{ old('ville', $company->ville) }}"
                            class="form-input @error('ville') border-red-500 @enderror"
                            placeholder="Sélectionner une ville...">
                        <span class="clear-btn" id="clear-city">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="city-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="city-results"></div>
                    <input type="hidden" id="city-id" name="city_id" value="{{ old('city_id') }}">
                    @error('ville')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h2 class="section-title">Détails de l'entreprise</h2>
            
            <!-- Secteur et Taille (sur la même ligne) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="sector" class="form-label">Secteur d'activité</label>
                    <div class="input-with-icon">
                        <input id="sector" name="sector" type="text" required value="{{ old('sector', $company->sector) }}"
                            class="form-input @error('sector') border-red-500 @enderror"
                            placeholder="Sélectionner un secteur...">
                        <span class="clear-btn" id="clear-sector">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="sector-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="sector-results"></div>
                    <input type="hidden" id="sector-code" name="sector_code" value="{{ old('sector_code') }}">
                    @error('sector')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="size" class="form-label">Taille de l'entreprise</label>
                    <select id="size" name="size" required class="form-select @error('size') border-red-500 @enderror">
                        <option value="">Sélectionnez une taille</option>
                        <option value="1-10" {{ old('size', $company->size) == '1-10' ? 'selected' : '' }}>1-10 employés</option>
                        <option value="11-50" {{ old('size', $company->size) == '11-50' ? 'selected' : '' }}>11-50 employés</option>
                        <option value="51-200" {{ old('size', $company->size) == '51-200' ? 'selected' : '' }}>51-200 employés</option>
                        <option value="201-500" {{ old('size', $company->size) == '201-500' ? 'selected' : '' }}>201-500 employés</option>
                        <option value="501-1000" {{ old('size', $company->size) == '501-1000' ? 'selected' : '' }}>501-1000 employés</option>
                        <option value="1001+" {{ old('size', $company->size) == '1001+' ? 'selected' : '' }}>Plus de 1000 employés</option>
                    </select>
                    @error('size')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Site web -->
            <div class="form-group">
                <label for="website" class="form-label">Site web</label>
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        https://
                    </span>
                    <input id="website" name="website_domain" type="text" 
                        value="{{ old('website_domain', str_replace('https://', '', $company->website ?? '')) }}"
                        class="form-input flex-1 rounded-none rounded-r-md @error('website') border-red-500 @enderror"
                        placeholder="www.votreentreprise.com">
                    <input type="hidden" id="website-full" name="website" 
                        value="{{ old('website', $company->website) }}">
                </div>
                @error('website')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">Description de l'entreprise</label>
                <textarea id="description" name="description" rows="4" 
                    class="form-textarea @error('description') border-red-500 @enderror"
                    placeholder="Décrivez brièvement votre entreprise, ses activités et sa culture...">{{ old('description', $company->description) }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-help-text">Maximum 500 caractères</p>
                <p class="form-help-text" id="char-count">{{ old('description', $company->description) ? strlen(old('description', $company->description)) : '0' }}/500 caractères</p>
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 mb-6">
            <a href="{{ route('recruiter.profile') }}" class="btn-secondary">
                Annuler
            </a>
            <button type="submit" class="btn-primary">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du formulaire
        const form = document.getElementById('company-form');
        const nameField = document.getElementById('name');
        const countryField = document.getElementById('country');
        const countryCodeField = document.getElementById('country-code');
        const cityField = document.getElementById('city');
        const cityIdField = document.getElementById('city-id');
        const sectorField = document.getElementById('sector');
        const sectorCodeField = document.getElementById('sector-code');
        const sizeField = document.getElementById('size');
        const websiteField = document.getElementById('website');
        const websiteFullField = document.getElementById('website-full');
        const descriptionField = document.getElementById('description');
        
        // Résultats d'autocomplétion
        const countryResults = document.getElementById('country-results');
        const cityResults = document.getElementById('city-results');
        const sectorResults = document.getElementById('sector-results');
        
        // Spinners
        const countrySpinner = document.getElementById('country-spinner');
        const citySpinner = document.getElementById('city-spinner');
        const sectorSpinner = document.getElementById('sector-spinner');
        
        // Boutons de suppression
        const clearCountryBtn = document.getElementById('clear-country');
        const clearCityBtn = document.getElementById('clear-city');
        const clearSectorBtn = document.getElementById('clear-sector');
        
        // Compteur de caractères
        const charCount = document.getElementById('char-count');
        const maxLength = 500;
        
        // Mise à jour du compteur de caractères
        descriptionField.addEventListener('input', function() {
            const currentLength = this.value.length;
            charCount.textContent = `${currentLength}/${maxLength} caractères`;
            
            if (currentLength > maxLength) {
                this.value = this.value.substring(0, maxLength);
                charCount.textContent = `${maxLength}/${maxLength} caractères`;
                charCount.classList.add('text-red-500');
            } else {
                charCount.classList.remove('text-red-500');
            }
        });
        
        // Liste des pays (exemple - à remplacer par votre propre source de données)
        const countries = [
            "Afghanistan", "Afrique du Sud", "Albanie", "Algérie", "Allemagne", "Andorre", "Angola", "Antigua-et-Barbuda", 
            "Arabie Saoudite", "Argentine", "Arménie", "Australie", "Autriche", "Azerbaïdjan", "Bahamas", "Bahreïn", 
            "Bangladesh", "Barbade", "Belgique", "Belize", "Bénin", "Bhoutan", "Biélorussie", "Birmanie", "Bolivie", 
            "Bosnie-Herzégovine", "Botswana", "Brésil", "Brunei", "Bulgarie", "Burkina Faso", "Burundi", "Cambodge", 
            "Cameroun", "Canada", "Cap-Vert", "Chili", "Chine", "Chypre", "Colombie", "Comores", "Congo", 
            "Corée du Nord", "Corée du Sud", "Costa Rica", "Côte d'Ivoire", "Croatie", "Cuba", "Danemark", "Djibouti", 
            "Dominique", "Égypte", "Émirats arabes unis", "Équateur", "Érythrée", "Espagne", "Estonie", "Eswatini", 
            "États-Unis", "Éthiopie", "Fidji", "Finlande", "France", "Gabon", "Gambie", "Géorgie", "Ghana", "Grèce", 
            "Grenade", "Guatemala", "Guinée", "Guinée équatoriale", "Guinée-Bissau", "Guyana", "Haïti", "Honduras", 
            "Hongrie", "Îles Marshall", "Îles Salomon", "Inde", "Indonésie", "Irak", "Iran", "Irlande", "Islande", 
            "Israël", "Italie", "Jamaïque", "Japon", "Jordanie", "Kazakhstan", "Kenya", "Kirghizistan", "Kiribati", 
            "Koweït", "Laos", "Lesotho", "Lettonie", "Liban", "Liberia", "Libye", "Liechtenstein", "Lituanie", 
            "Luxembourg", "Macédoine du Nord", "Madagascar", "Malaisie", "Malawi", "Maldives", "Mali", "Malte", 
            "Maroc", "Maurice", "Mauritanie", "Mexique", "Micronésie", "Moldavie", "Monaco", "Mongolie", "Monténégro", 
            "Mozambique", "Namibie", "Nauru", "Népal", "Nicaragua", "Niger", "Nigeria", "Niue", "Norvège", 
            "Nouvelle-Zélande", "Oman", "Ouganda", "Ouzbékistan", "Pakistan", "Palaos", "Palestine", "Panama", 
            "Papouasie-Nouvelle-Guinée", "Paraguay", "Pays-Bas", "Pérou", "Philippines", "Pologne", "Portugal", 
            "Qatar", "République centrafricaine", "République démocratique du Congo", "République dominicaine", 
            "République tchèque", "Roumanie", "Royaume-Uni", "Russie", "Rwanda", "Saint-Kitts-et-Nevis", "Saint-Marin", 
            "Saint-Vincent-et-les-Grenadines", "Sainte-Lucie", "Salvador", "Samoa", "São Tomé-et-Principe", "Sénégal", 
            "Serbie", "Seychelles", "Sierra Leone", "Singapour", "Slovaquie", "Slovénie", "Somalie", "Soudan", 
            "Soudan du Sud", "Sri Lanka", "Suède", "Suisse", "Suriname", "Syrie", "Tadjikistan", "Tanzanie", "Tchad", 
            "Thaïlande", "Timor oriental", "Togo", "Tonga", "Trinité-et-Tobago", "Tunisie", "Turkménistan", "Turquie", 
            "Tuvalu", "Ukraine", "Uruguay", "Vanuatu", "Vatican", "Venezuela", "Viêt Nam", "Yémen", "Zambie", "Zimbabwe"
        ];
        
        // Liste des secteurs d'activité (exemple)
        const sectors = [
            "Agriculture et agroalimentaire", "Banque et finance", "Commerce de détail", "Communication et médias",
            "Construction et immobilier", "Éducation et formation", "Énergie et environnement", "Hôtellerie et restauration",
            "Industrie manufacturière", "Informatique et technologie", "Santé et services sociaux", "Services aux entreprises",
            "Télécommunications", "Transport et logistique", "Tourisme et loisirs"
        ];
        
        // Fonction pour afficher les résultats d'autocomplétion des pays
        function showCountryResults(query) {
            countryResults.innerHTML = '';
            countryResults.style.display = 'none';
            
            if (!query) return;
            
            const filteredCountries = countries.filter(country => 
                country.toLowerCase().includes(query.toLowerCase())
            );
            
            if (filteredCountries.length === 0) return;
            
            filteredCountries.forEach(country => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = country;
                item.addEventListener('click', () => {
                    countryField.value = country;
                    countryCodeField.value = country;
                    countryResults.style.display = 'none';
                });
                countryResults.appendChild(item);
            });
            
            countryResults.style.display = 'block';
        }
        
        // Fonction pour afficher les résultats d'autocomplétion des secteurs
        function showSectorResults(query) {
            sectorResults.innerHTML = '';
            sectorResults.style.display = 'none';
            
            if (!query) return;
            
            const filteredSectors = sectors.filter(sector => 
                sector.toLowerCase().includes(query.toLowerCase())
            );
            
            if (filteredSectors.length === 0) return;
            
            filteredSectors.forEach(sector => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = sector;
                item.addEventListener('click', () => {
                    sectorField.value = sector;
                    sectorCodeField.value = sector;
                    sectorResults.style.display = 'none';
                });
                sectorResults.appendChild(item);
            });
            
            sectorResults.style.display = 'block';
        }
        
        // Fonction pour simuler les résultats d'autocomplétion des villes
        function showCityResults(country, query) {
            cityResults.innerHTML = '';
            cityResults.style.display = 'none';
            
            if (!query || !country) return;
            
            // Simuler un délai de chargement
            citySpinner.style.display = 'block';
            
            // Exemple de villes pour quelques pays (à remplacer par votre propre source de données)
            const citiesByCountry = {
                "France": ["Paris", "Marseille", "Lyon", "Toulouse", "Nice", "Nantes", "Strasbourg", "Montpellier", "Bordeaux", "Lille"],
                "Maroc": ["Casablanca", "Rabat", "Marrakech", "Fès", "Tanger", "Agadir", "Meknès", "Oujda", "Tétouan", "Kénitra"],
                "Canada": ["Toronto", "Montréal", "Vancouver", "Calgary", "Edmonton", "Ottawa", "Québec", "Winnipeg", "Hamilton", "Halifax"],
                "États-Unis": ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphie", "San Antonio", "San Diego", "Dallas", "San José"],
                "Royaume-Uni": ["Londres", "Birmingham", "Manchester", "Glasgow", "Liverpool", "Bristol", "Édimbourg", "Leeds", "Sheffield", "Leicester"]
            };
            
            // Simuler un délai de chargement
            setTimeout(() => {
                citySpinner.style.display = 'none';
                
                // Si le pays est dans notre liste, afficher ses villes
                if (citiesByCountry[country]) {
                    const filteredCities = citiesByCountry[country].filter(city => 
                        city.toLowerCase().includes(query.toLowerCase())
                    );
                    
                    if (filteredCities.length === 0) return;
                    
                    filteredCities.forEach(city => {
                        const item = document.createElement('div');
                        item.className = 'autocomplete-item';
                        item.textContent = city;
                        item.addEventListener('click', () => {
                            cityField.value = city;
                            cityIdField.value = city;
                            cityResults.style.display = 'none';
                        });
                        cityResults.appendChild(item);
                    });
                    
                    cityResults.style.display = 'block';
                }
            }, 300);
        }
        
        // Événements pour le champ pays
        countryField.addEventListener('input', function() {
            const query = this.value.trim();
            showCountryResults(query);
            
            if (query) {
                countryCodeField.value = query;
            } else {
                countryCodeField.value = "";
            }
        });
        
        countryField.addEventListener('focus', function() {
            if (this.value.trim()) {
                showCountryResults(this.value.trim());
            }
        });
        
        // Événements  {
                showCountryResults(this.value.trim());
            }
        );
        
        // Événements pour le champ ville
        cityField.addEventListener('input', function() {
            const query = this.value.trim();
            const country = countryField.value.trim();
            showCityResults(country, query);
            
            if (query) {
                cityIdField.value = query;
            } else {
                cityIdField.value = "";
            }
        });
        
        cityField.addEventListener('focus', function() {
            if (this.value.trim() && countryField.value.trim()) {
                showCityResults(countryField.value.trim(), this.value.trim());
            }
        });
        
        // Événements pour le champ secteur
        sectorField.addEventListener('input', function() {
            const query = this.value.trim();
            showSectorResults(query);
            
            if (query) {
                sectorCodeField.value = query;
            } else {
                sectorCodeField.value = "";
            }
        });
        
        sectorField.addEventListener('focus', function() {
            if (this.value.trim()) {
                showSectorResults(this.value.trim());
            }
        });
        
        // Événements pour les boutons de suppression
        clearCountryBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            countryField.value = '';
            countryCodeField.value = '';
            countryResults.style.display = 'none';
        });
        
        clearCityBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            cityField.value = '';
            cityIdField.value = '';
            cityResults.style.display = 'none';
        });
        
        clearSectorBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            sectorField.value = '';
            sectorCodeField.value = '';
            sectorResults.style.display = 'none';
        });
        
        // Fermer les résultats d'autocomplétion quand on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!countryField.contains(e.target) && !countryResults.contains(e.target)) {
                countryResults.style.display = 'none';
            }
            
            if (!cityField.contains(e.target) && !cityResults.contains(e.target)) {
                cityResults.style.display = 'none';
            }
            
            if (!sectorField.contains(e.target) && !sectorResults.contains(e.target)) {
                sectorResults.style.display = 'none';
            }
        });
        
        // Gérer l'URL du site web
        websiteField.addEventListener('input', function() {
            if (this.value.trim()) {
                // Construire l'URL complète
                const websiteUrl = 'https://' + this.value.trim();
                websiteFullField.value = websiteUrl;
            } else {
                websiteFullField.value = '';
            }
        });
        
        // Validation du formulaire avant soumission
        form.addEventListener('submit', function(event) {
            // Empêcher la soumission par défaut pour vérifier les champs
            event.preventDefault();
            
            let isValid = true;
            
            // Vérifier que le pays est sélectionné
            if (!countryField.value.trim()) {
                isValid = false;
                countryField.classList.add('border-red-500');
            }
            
            // Vérifier que la ville est sélectionnée
            if (!cityField.value.trim()) {
                isValid = false;
                cityField.classList.add('border-red-500');
            }
            
            // Vérifier que le secteur est sélectionné
            if (!sectorField.value.trim()) {
                isValid = false;
                sectorField.classList.add('border-red-500');
            }
            
            // Vérifier que la taille est sélectionnée
            if (!sizeField.value) {
                isValid = false;
                sizeField.classList.add('border-red-500');
            }
            
            // Gérer l'URL du site web
            if (websiteField.value.trim()) {
                // Construire l'URL complète
                const websiteUrl = 'https://' + websiteField.value.trim();
                websiteFullField.value = websiteUrl;
            }
            
            // Si tous les champs sont valides, soumettre le formulaire
            if (isValid) {
                // Assurez-vous que les champs cachés sont remplis avec les valeurs correctes
                if (!countryCodeField.value && countryField.value) {
                    countryCodeField.value = "MANUAL"; // Valeur par défaut si le code n'est pas disponible
                }
                
                if (!cityIdField.value && cityField.value) {
                    cityIdField.value = "MANUAL"; // Valeur par défaut si l'ID n'est pas disponible
                }
                
                if (!sectorCodeField.value && sectorField.value) {
                    sectorCodeField.value = "MANUAL"; // Valeur par défaut si le code n'est pas disponible
                }
                
                // Soumettre le formulaire
                this.submit();
            }
        });
</script>
@endsection

"
voici le fichier views/recruter/offrecreat.blade.php : 
"@extends('layouts.recruteur')

@section('title', 'Créer une offre d\'emploi')

@section('header-title', 'Créer une offre d\'emploi')

@section('styles')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-section {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    
    .form-input {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .form-select {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    .form-select:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .form-textarea {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        resize: vertical;
    }
    
    .form-textarea:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #4f46e5;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-primary:hover {
        background-color: #4338ca;
    }
    
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 1rem;
    }
    
    .btn-secondary:hover {
        background-color: #e5e7eb;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon .icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    
    .input-with-icon input {
        padding-left: 2.5rem;
    }
    
    .required-star {
        color: #ef4444;
        margin-left: 0.25rem;
    }
    
    /* Styles pour les sélections multiples */
    .multiselect-container {
        position: relative;
        width: 100%;
    }
    
    .multiselect-input {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        width: 100%;
        min-height: 42px;
        padding: 0.375rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        cursor: pointer;
    }
    
    .multiselect-input:focus-within {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .multiselect-tag {
        display: inline-flex;
        align-items: center;
        background-color: #dbeafe;
        border: 1px solid #93c5fd;
        border-radius: 9999px;
        padding: 0.25rem 0.5rem;
        margin: 0.25rem;
        font-size: 0.875rem;
        color: #1e40af;
    }
    
    .multiselect-tag-remove {
        margin-left: 0.25rem;
        cursor: pointer;
        color: #1e40af;
    }
    
    .multiselect-placeholder {
        color: #9ca3af;
        margin: 0.25rem;
    }
    
    .multiselect-search {
        flex: 1;
        border: none;
        outline: none;
        padding: 0.25rem;
        min-width: 50px;
        background: transparent;
    }
    
    .multiselect-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 10;
        max-height: 200px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        margin-top: 0.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: none;
    }
    
    .multiselect-dropdown.show {
        display: block;
    }
    
    .multiselect-option {
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .multiselect-option:hover {
        background-color: #f3f4f6;
    }
    
    .multiselect-option.selected {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .multiselect-option.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .multiselect-no-results {
        padding: 0.5rem 0.75rem;
        color: #9ca3af;
        font-style: italic;
    }
    
    /* Styles pour les niveaux de langue */
    .language-level {
        display: flex;
        align-items: center;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background-color: #f9fafb;
        border-radius: 0.375rem;
    }
    
    .language-level-label {
        flex: 1;
        font-weight: 500;
    }
    
    .language-level-select {
        width: 150px;
    }
</style>
@endsection

@section('content')
<div class="form-container">
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('offers.store') }}" id="offre-form">
        @csrf
        
        <div class="form-section">
            <h2 class="section-title">Informations générales</h2>
            
            <!-- Titre de l'offre -->
            <div class="form-group">
                <label for="title" class="form-label">
                    Titre de l'offre
                    <span class="required-star">*</span>
                </label>
                <input id="title" name="title" type="text" required value="{{ old('title') }}"
                    class="form-input @error('title') border-red-500 @enderror"
                    placeholder="Ex: Développeur Web Full Stack">
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre de postes -->
                <div class="form-group">
                    <label for="nombre_poste" class="form-label">
                        Nombre de postes à pourvoir
                        <span class="required-star">*</span>
                    </label>
                    <input id="nombre_poste" name="nombre_poste" type="number" min="1" required value="{{ old('nombre_poste', 1) }}"
                        class="form-input @error('nombre_poste') border-red-500 @enderror">
                    @error('nombre_poste')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Lieu -->
                <div class="form-group">
                    <label for="location" class="form-label">
                        Lieu
                        <span class="required-star">*</span>
                    </label>
                    <input id="location" name="location" type="text" required value="{{ old('location') }}"
                        class="form-input @error('location') border-red-500 @enderror"
                        placeholder="Ex: Paris, France">
                    @error('location')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Type de contrat -->
                <div class="form-group">
                    <label for="type_contrat" class="form-label">
                        Type de contrat
                        <span class="required-star">*</span>
                    </label>
                    <select id="type_contrat" name="type_contrat" required 
                        class="form-select @error('type_contrat') border-red-500 @enderror">
                        <option value="">Sélectionnez un type de contrat</option>
                        <option value="CDI" {{ old('type_contrat') == 'CDI' ? 'selected' : '' }}>CDI</option>
                        <option value="CDD" {{ old('type_contrat') == 'CDD' ? 'selected' : '' }}>CDD</option>
                        <option value="Intérim" {{ old('type_contrat') == 'Intérim' ? 'selected' : '' }}>Intérim</option>
                        <option value="Stage" {{ old('type_contrat') == 'Stage' ? 'selected' : '' }}>Stage</option>
                        <option value="Alternance" {{ old('type_contrat') == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                        <option value="Freelance" {{ old('type_contrat') == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                    @error('type_contrat')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Mode de travail -->
                <div class="form-group">
                    <label for="mode_travail" class="form-label">
                        Mode de travail
                        <span class="required-star">*</span>
                    </label>
                    <select id="mode_travail" name="mode_travail" required 
                        class="form-select @error('mode_travail') border-red-500 @enderror">
                        <option value="">Sélectionnez un mode de travail</option>
                        <option value="Sur site" {{ old('mode_travail') == 'Sur site' ? 'selected' : '' }}>Sur site</option>
                        <option value="Hybride" {{ old('mode_travail') == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                        <option value="Télétravail" {{ old('mode_travail') == 'Télétravail' ? 'selected' : '' }}>Télétravail complet</option>
                    </select>
                    @error('mode_travail')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Salaire -->
                <div class="form-group">
                    <label for="salaire" class="form-label">
                        Salaire annuel (€)
                        <span class="required-star">*</span>
                    </label>
                    <div class="input-with-icon">
                        <div class="icon">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                        <input id="salaire" name="salaire" type="number" min="0" required value="{{ old('salaire') }}"
                            class="form-input @error('salaire') border-red-500 @enderror"
                            placeholder="Ex: 45000">
                    </div>
                    @error('salaire')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Expérience requise -->
                <div class="form-group">
                    <label for="experience" class="form-label">
                        Expérience requise (années)
                        <span class="required-star">*</span>
                    </label>
                    <select id="experience" name="experience" required 
                        class="form-select @error('experience') border-red-500 @enderror">
                        <option value="">Sélectionnez l'expérience requise</option>
                        <option value="0" {{ old('experience') == '0' ? 'selected' : '' }}>Débutant accepté</option>
                        <option value="1" {{ old('experience') == '1' ? 'selected' : '' }}>1 an</option>
                        <option value="2" {{ old('experience') == '2' ? 'selected' : '' }}>2 ans</option>
                        <option value="3" {{ old('experience') == '3' ? 'selected' : '' }}>3 ans</option>
                        <option value="5" {{ old('experience') == '5' ? 'selected' : '' }}>5 ans</option>
                        <option value="7" {{ old('experience') == '7' ? 'selected' : '' }}>7 ans</option>
                        <option value="10" {{ old('experience') == '10' ? 'selected' : '' }}>10 ans et plus</option>
                    </select>
                    @error('experience')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Date d'expiration -->
            <div class="form-group">
                <label for="date_expiration" class="form-label">
                    Date d'expiration de l'offre
                </label>
                <input id="date_expiration" name="date_expiration" type="date" value="{{ old('date_expiration') }}"
                    class="form-input @error('date_expiration') border-red-500 @enderror"
                    min="{{ date('Y-m-d') }}">
                <p class="form-help-text">Laissez vide si l'offre n'a pas de date d'expiration.</p>
                @error('date_expiration')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="form-section">
            <h2 class="section-title">Description du poste</h2>
            
            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">
                    Description détaillée
                    <span class="required-star">*</span>
                </label>
                <textarea id="description" name="description" rows="10" required 
                    class="form-textarea @error('description') border-red-500 @enderror"
                    placeholder="Décrivez le poste, les responsabilités, les compétences requises, les avantages, etc.">{{ old('description') }}</textarea>
                <p class="form-help-text">Soyez précis et détaillé pour attirer les meilleurs candidats.</p>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Compétences requises -->
        <div class="form-section">
            <h2 class="section-title">Compétences requises</h2>
            
            <div class="form-group">
                <label for="skills" class="form-label">
                    Compétences
                    <span class="required-star">*</span>
                </label>
                
                <div class="multiselect-container" id="skills-container">
                    <div class="multiselect-input" id="skills-input">
                        <div class="multiselect-placeholder" id="skills-placeholder">Sélectionnez des compétences...</div>
                        <input type="text" class="multiselect-search" id="skills-search" placeholder="">
                    </div>
                    
                    <div class="multiselect-dropdown" id="skills-dropdown">
                        <!-- Les options seront ajoutées dynamiquement -->
                        <div class="multiselect-no-results" id="skills-no-results" style="display: none;">Aucun résultat trouvé</div>
                    </div>
                    
                    <!-- Champs cachés pour stocker les IDs des compétences sélectionnées -->
                    <div id="skill-ids-container"></div>
                </div>
                
                @error('skill_ids')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                
                <p class="form-help-text">Sélectionnez les compétences requises pour ce poste pour améliorer le matching avec les candidats.</p>
            </div>
        </div>
        
        <!-- Langues requises -->
        <div class="form-section">
            <h2 class="section-title">Langues requises</h2>
            
            <div class="form-group">
                <label for="languages" class="form-label">
                    Langues
                </label>
                
                <div class="multiselect-container" id="languages-container">
                    <div class="multiselect-input" id="languages-input">
                        <div class="multiselect-placeholder" id="languages-placeholder">Sélectionnez des langues...</div>
                        <input type="text" class="multiselect-search" id="languages-search" placeholder="">
                    </div>
                    
                    <div class="multiselect-dropdown" id="languages-dropdown">
                        <!-- Les options seront ajoutées dynamiquement -->
                        <div class="multiselect-no-results" id="languages-no-results" style="display: none;">Aucun résultat trouvé</div>
                    </div>
                </div>
                
                <!-- Conteneur pour les niveaux de langue -->
                <div id="language-levels-container" class="mt-4">
                    <!-- Les niveaux de langue seront ajoutés dynamiquement -->
                </div>
                
                <!-- Champs cachés pour stocker les IDs des langues sélectionnées -->
                <div id="language-ids-container"></div>
                
                @error('language_ids')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                
                <p class="form-help-text">Sélectionnez les langues requises pour ce poste pour améliorer le matching avec les candidats.</p>
            </div>
        </div>
        
        <!-- Champ caché pour le statut -->
        <input type="hidden" name="statut" id="statut-field" value="brouillon">
        
        <div class="flex justify-end space-x-4 mb-6">
            <a href="{{ route('offers.index') }}" class="btn-secondary">
                Annuler
            </a>
            <button type="submit" name="save_draft" value="1" class="btn-secondary">
                Enregistrer comme brouillon
            </button>
            <button type="submit" name="publish" value="1" class="btn-primary">
                Publier l'offre
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('offre-form');
        const publishButton = document.querySelector('button[name="publish"]');
        const draftButton = document.querySelector('button[name="save_draft"]');
        const statutField = document.getElementById('statut-field');
        
        // Mettre à jour le statut en fonction du bouton cliqué
        publishButton.addEventListener('click', function() {
            statutField.value = 'en attente';
        });
        
        draftButton.addEventListener('click', function() {
            statutField.value = 'brouillon';
        });
        
        // Formater la date d'expiration minimale
        const dateExpirationField = document.getElementById('date_expiration');
        const today = new Date();
        const minDate = new Date(today);
        minDate.setDate(today.getDate() + 1); // Au moins un jour dans le futur
        
        const formatDate = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };
        
        dateExpirationField.min = formatDate(minDate);
        
        // Si aucune date n'est définie, suggérer une date d'expiration par défaut (30 jours)
        if (!dateExpirationField.value) {
            const defaultExpiration = new Date(today);
            defaultExpiration.setDate(today.getDate() + 30);
            dateExpirationField.value = formatDate(defaultExpiration);
        }
        
        // ===== GESTION DES COMPÉTENCES =====
        
        // Données des compétences
        const skills = @json($skills);
        
        // Éléments DOM pour les compétences
        const skillsContainer = document.getElementById('skills-container');
        const skillsInput = document.getElementById('skills-input');
        const skillsPlaceholder = document.getElementById('skills-placeholder');
        const skillsSearch = document.getElementById('skills-search');
        const skillsDropdown = document.getElementById('skills-dropdown');
        const skillsNoResults = document.getElementById('skills-no-results');
        const skillIdsContainer = document.getElementById('skill-ids-container');
        
        // Ensemble pour suivre les compétences sélectionnées
        const selectedSkills = new Set();
        
        // Initialiser les compétences sélectionnées depuis old()
        @if(old('skill_ids'))
            @foreach(old('skill_ids') as $skillId)
                selectedSkills.add({{ $skillId }});
                const skill = skills.find(s => s.id === {{ $skillId }});
                if (skill) {
                    addSkillTag(skill.id, skill.name);
                    addSkillIdInput(skill.id);
                }
            @endforeach
            updateSkillsPlaceholder();
        @endif
        
        // Fonction pour ajouter un tag de compétence
        function addSkillTag(id, name) {
            const tag = document.createElement('div');
            tag.className = 'multiselect-tag';
            tag.dataset.id = id;
            tag.innerHTML = `
                ${name}
                <span class="multiselect-tag-remove" data-id="${id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </span>
            `;
            
            // Ajouter le tag avant le champ de recherche
            skillsInput.insertBefore(tag, skillsSearch);
            
            // Ajouter l'événement de suppression
            tag.querySelector('.multiselect-tag-remove').addEventListener('click', function() {
                const skillId = this.dataset.id;
                removeSkill(skillId);
            });
        }
        
        // Fonction pour ajouter un input caché pour l'ID de compétence
        function addSkillIdInput(id) {
            // Vérifier si l'input existe déjà
            if (!document.querySelector(`input[name="skill_ids[]"][value="${id}"]`)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'skill_ids[]';
                input.value = id;
                skillIdsContainer.appendChild(input);
            }
        }
        
        // Fonction pour supprimer une compétence
        function removeSkill(id) {
            selectedSkills.delete(parseInt(id));
            
            // Supprimer le tag
            const tag = skillsInput.querySelector(`.multiselect-tag[data-id="${id}"]`);
            if (tag) {
                tag.remove();
            }
            
            // Supprimer l'input caché
            const input = skillIdsContainer.querySelector(`input[name="skill_ids[]"][value="${id}"]`);
            if (input) {
                input.remove();
            }
            
            // Mettre à jour l'option dans le dropdown
            const option = skillsDropdown.querySelector(`.multiselect-option[data-id="${id}"]`);
            if (option) {
                option.classList.remove('selected');
            }
            
            updateSkillsPlaceholder();
        }
        
        // Fonction pour mettre à jour le placeholder
        function updateSkillsPlaceholder() {
            if (selectedSkills.size > 0) {
                skillsPlaceholder.style.display = 'none';
            } else {
                skillsPlaceholder.style.display = 'block';
            }
        }
        
        // Fonction pour filtrer les compétences
        function filterSkills(query) {
            const filteredSkills = skills.filter(skill => 
                skill.name.toLowerCase().includes(query.toLowerCase())
            );
            
            // Vider le dropdown
            while (skillsDropdown.firstChild) {
                if (skillsDropdown.firstChild === skillsNoResults) {
                    break;
                }
                skillsDropdown.removeChild(skillsDropdown.firstChild);
            }
            
            if (filteredSkills.length === 0) {
                skillsNoResults.style.display = 'block';
            } else {
                skillsNoResults.style.display = 'none';
                
                // Ajouter les options filtrées
                filteredSkills.forEach(skill => {
                    const option = document.createElement('div');
                    option.className = `multiselect-option ${selectedSkills.has(skill.id) ? 'selected' : ''}`;
                    option.dataset.id = skill.id;
                    option.textContent = skill.name;
                    
                    option.addEventListener('click', function() {
                        const skillId = parseInt(this.dataset.id);
                        
                        if (selectedSkills.has(skillId)) {
                            removeSkill(skillId);
                        } else {
                            selectedSkills.add(skillId);
                            addSkillTag(skillId, skill.name);
                            addSkillIdInput(skillId);
                            this.classList.add('selected');
                            updateSkillsPlaceholder();
                        }
                        
                        // Vider le champ de recherche et se concentrer dessus
                        skillsSearch.value = '';
                        skillsSearch.focus();
                    });
                    
                    skillsDropdown.insertBefore(option, skillsNoResults);
                });
            }
        }
        
        // Événements pour les compétences
        skillsInput.addEventListener('click', function() {
            skillsSearch.focus();
        });
        
        skillsSearch.addEventListener('focus', function() {
            filterSkills('');
            skillsDropdown.classList.add('show');
        });
        
        skillsSearch.addEventListener('input', function() {
            filterSkills(this.value);
        });
        
        document.addEventListener('click', function(e) {
            if (!skillsContainer.contains(e.target)) {
                skillsDropdown.classList.remove('show');
            }
        });
        
        // ===== GESTION DES LANGUES =====
        
        // Données des langues
        const languages = @json($languages);
        
        // Niveaux de langue disponibles
        const languageLevels = [
            { value: 'débutant', label: 'Débutant' },
            { value: 'intermédiaire', label: 'Intermédiaire' },
            { value: 'avancé', label: 'Avancé' },
            { value: 'courant', label: 'Courant' },
            { value: 'natif', label: 'Langue maternelle' }
        ];
        
        // Éléments DOM pour les langues
        const languagesContainer = document.getElementById('languages-container');
        const languagesInput = document.getElementById('languages-input');
        const languagesPlaceholder = document.getElementById('languages-placeholder');
        const languagesSearch = document.getElementById('languages-search');
        const languagesDropdown = document.getElementById('languages-dropdown');
        const languagesNoResults = document.getElementById('languages-no-results');
        const languageLevelsContainer = document.getElementById('language-levels-container');
        const languageIdsContainer = document.getElementById('language-ids-container');
        
        // Map pour suivre les langues sélectionnées avec leurs niveaux
        const selectedLanguages = new Map();
        
        // Initialiser les langues sélectionnées depuis old()
        @if(old('language_ids'))
            @foreach(old('language_ids') as $index => $languageId)
                @php
                    $level = old('language_levels')[$index] ?? 'courant';
                @endphp
                const language = languages.find(l => l.id === {{ $languageId }});
                if (language) {
                    selectedLanguages.set({{ $languageId }}, { name: language.name, level: '{{ $level }}' });
                    addLanguageTag({{ $languageId }}, language.name);
                    addLanguageLevel({{ $languageId }}, language.name, '{{ $level }}');
                    addLanguageIdInput({{ $languageId }}, '{{ $level }}');
                }
            @endforeach
            updateLanguagesPlaceholder();
        @endif
        
        // Fonction pour ajouter un tag de langue
        function addLanguageTag(id, name) {
            const tag = document.createElement('div');
            tag.className = 'multiselect-tag';
            tag.dataset.id = id;
            tag.innerHTML = `
                ${name}
                <span class="multiselect-tag-remove" data-id="${id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </span>
            `;
            
            // Ajouter le tag avant le champ de recherche
            languagesInput.insertBefore(tag, languagesSearch);
            
            // Ajouter l'événement de suppression
            tag.querySelector('.multiselect-tag-remove').addEventListener('click', function() {
                const langId = this.dataset.id;
                removeLanguage(langId);
            });
        }
        
        // Fonction pour ajouter un input caché pour l'ID de langue et son niveau
        function addLanguageIdInput(id, level) {
            // Vérifier si l'input existe déjà
            if (!document.querySelector(`input[name="language_ids[]"][value="${id}"]`)) {
                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'language_ids[]';
                inputId.value = id;
                
                const inputLevel = document.createElement('input');
                inputLevel.type = 'hidden';
                inputLevel.name = 'language_levels[]';
                inputLevel.value = level;
                inputLevel.dataset.id = id;
                
                languageIdsContainer.appendChild(inputId);
                languageIdsContainer.appendChild(inputLevel);
            }
        }
        
        // Fonction pour ajouter un sélecteur de niveau de langue
        function addLanguageLevel(id, name, level = 'courant') {
            // Vérifier si le niveau existe déjà
            const existingLevel = languageLevelsContainer.querySelector(`#language-level-${id}`);
            if (existingLevel) {
                // Mettre à jour le niveau existant
                existingLevel.querySelector('select').value = level;
                return;
            }
            
            // Créer un nouvel élément de niveau
            const levelElement = document.createElement('div');
            levelElement.className = 'language-level';
            levelElement.id = `language-level-${id}`;
            
            // Créer le label
            const labelElement = document.createElement('div');
            labelElement.className = 'language-level-label';
            labelElement.textContent = name;
            
            // Créer le select
            const selectElement = document.createElement('select');
            selectElement.className = 'form-select language-level-select';
            selectElement.dataset.id = id;
            
            // Ajouter les options
            languageLevels.forEach(levelOption => {
                const option = document.createElement('option');
                option.value = levelOption.value;
                option.textContent = levelOption.label;
                option.selected = levelOption.value === level;
                selectElement.appendChild(option);
            });
            
            // Ajouter l'événement de changement
            selectElement.addEventListener('change', function() {
                const langId = parseInt(this.dataset.id);
                const langData = selectedLanguages.get(langId);
                if (langData) {
                    langData.level = this.value;
                    selectedLanguages.set(langId, langData);
                    
                    // Mettre à jour l'input caché du niveau
                    const levelInput = languageIdsContainer.querySelector(`input[name="language_levels[]"][data-id="${langId}"]`);
                    if (levelInput) {
                        levelInput.value = this.value;
                    }
                }
            });
            
            // Assembler l'élément
            levelElement.appendChild(labelElement);
            levelElement.appendChild(selectElement);
            
            // Ajouter au conteneur
            languageLevelsContainer.appendChild(levelElement);
        }
        
        // Fonction pour supprimer une langue
        function removeLanguage(id) {
            selectedLanguages.delete(parseInt(id));
            
            // Supprimer le tag
            const tag = languagesInput.querySelector(`.multiselect-tag[data-id="${id}"]`);
            if (tag) {
                tag.remove();
            }
            
            // Supprimer le niveau
            const level = languageLevelsContainer.querySelector(`#language-level-${id}`);
            if (level) {
                level.remove();
            }
            
            // Supprimer les inputs cachés
            const inputId = languageIdsContainer.querySelector(`input[name="language_ids[]"][value="${id}"]`);
            const inputLevel = languageIdsContainer.querySelector(`input[name="language_levels[]"][data-id="${id}"]`);
            if (inputId) inputId.remove();
            if (inputLevel) inputLevel.remove();
            
            // Mettre à jour l'option dans le dropdown
            const option = languagesDropdown.querySelector(`.multiselect-option[data-id="${id}"]`);
            if (option) {
                option.classList.remove('selected');
            }
            
            updateLanguagesPlaceholder();
        }
        
        // Fonction pour mettre à jour le placeholder
        function updateLanguagesPlaceholder() {
            if (selectedLanguages.size > 0) {
                languagesPlaceholder.style.display = 'none';
            } else {
                languagesPlaceholder.style.display = 'block';
            }
        }
        
        // Fonction pour filtrer les langues
        function filterLanguages(query) {
            const filteredLanguages = languages.filter(language => 
                language.name.toLowerCase().includes(query.toLowerCase())
            );
            
            // Vider le dropdown
            while (languagesDropdown.firstChild) {
                if (languagesDropdown.firstChild === languagesNoResults) {
                    break;
                }
                languagesDropdown.removeChild(languagesDropdown.firstChild);
            }
            
            if (filteredLanguages.length === 0) {
                languagesNoResults.style.display = 'block';
            } else {
                languagesNoResults.style.display = 'none';
                
                // Ajouter les options filtrées
                filteredLanguages.forEach(language => {
                    const option = document.createElement('div');
                    option.className = `multiselect-option ${selectedLanguages.has(language.id) ? 'selected' : ''}`;
                    option.dataset.id = language.id;
                    option.textContent = language.name;
                    
                    option.addEventListener('click', function() {
                        const langId = parseInt(this.dataset.id);
                        
                        if (selectedLanguages.has(langId)) {
                            removeLanguage(langId);
                        } else {
                            selectedLanguages.set(langId, { name: language.name, level: 'courant' });
                            addLanguageTag(langId, language.name);
                            addLanguageLevel(langId, language.name);
                            addLanguageIdInput(langId, 'courant');
                            this.classList.add('selected');
                            updateLanguagesPlaceholder();
                        }
                        
                        // Vider le champ de recherche et se concentrer dessus
                        languagesSearch.value = '';
                        languagesSearch.focus();
                    });
                    
                    languagesDropdown.insertBefore(option, languagesNoResults);
                });
            }
        }
        
        // Événements pour les langues
        languagesInput.addEventListener('click', function() {
            languagesSearch.focus();
        });
        
        languagesSearch.addEventListener('focus', function() {
            filterLanguages('');
            languagesDropdown.classList.add('show');
        });
        
        languagesSearch.addEventListener('input', function() {
            filterLanguages(this.value);
        });
        
        document.addEventListener('click', function(e) {
            if (!languagesContainer.contains(e.target)) {
                languagesDropdown.classList.remove('show');
            }
        });
        
        // Validation du formulaire
        form.addEventListener('submit', function(event) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            // Vérifier que des compétences sont sélectionnées
            if (selectedSkills.size === 0) {
                isValid = false;
                skillsInput.classList.add('border-red-500');
                
                // Ajouter un message d'erreur
                if (!document.querySelector('#skills-error')) {
                    const errorMessage = document.createElement('p');
                    errorMessage.id = 'skills-error';
                    errorMessage.className = 'form-error';
                    errorMessage.textContent = 'Veuillez sélectionner au moins une compétence.';
                    skillsContainer.parentNode.appendChild(errorMessage);
                }
            } else {
                skillsInput.classList.remove('border-red-500');
                const errorMessage = document.querySelector('#skills-error');
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
            
            if (!isValid) {
                event.preventDefault();
                window.scrollTo(0, 0);
                
                // Afficher un message d'erreur général
                if (!document.querySelector('.error-message')) {
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'bg-red-50 border-l-4 border-red-500 p-4 mb-6 error-message';
                    errorMessage.innerHTML = `
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Veuillez remplir tous les champs obligatoires.</h3>
                            </div>
                        </div>
                    `;
                    form.prepend(errorMessage);
                }
            }
        });
    });
</script>
@endsection

"
voici le fichier views/recruter/offreedit.blade.php : 
"@extends('layouts.recruteur')

@section('title', 'Modifier une offre d\'emploi')

@section('header-title', 'Modifier une offre d\'emploi')

@section('styles')
<style>
    .form-container {
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-section {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
        position: relative;
    }
    
    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
    }
    
    .form-input {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }
    
    .form-input:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .form-select {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        appearance: none;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
        background-position: right 0.5rem center;
        background-repeat: no-repeat;
        background-size: 1.5em 1.5em;
        padding-right: 2.5rem;
    }
    
    .form-select:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .form-textarea {
        display: block;
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        color: #1f2937;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        resize: vertical;
    }
    
    .form-textarea:focus {
        border-color: #4f46e5;
        outline: none;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #4f46e5;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-primary:hover {
        background-color: #4338ca;
    }
    
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        margin-right: 1rem;
    }
    
    .btn-secondary:hover {
        background-color: #e5e7eb;
    }
    
    .form-help-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .form-error {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.5rem;
    }
    
    .input-with-icon {
        position: relative;
    }
    
    .input-with-icon .icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
    }
    
    .input-with-icon input {
        padding-left: 2.5rem;
    }
    
    .required-star {
        color: #ef4444;
        margin-left: 0.25rem;
    }
    
    /* Styles pour les sélections multiples */
    .multiselect-container {
        position: relative;
        width: 100%;
    }
    
    .multiselect-input {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        width: 100%;
        min-height: 42px;
        padding: 0.375rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: #fff;
        cursor: pointer;
    }
    
    .multiselect-input:focus-within {
        border-color: #4f46e5;
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
    }
    
    .multiselect-tag {
        display: inline-flex;
        align-items: center;
        background-color: #dbeafe;
        border: 1px solid #93c5fd;
        border-radius: 9999px;
        padding: 0.25rem 0.5rem;
        margin: 0.25rem;
        font-size: 0.875rem;
        color: #1e40af;
    }
    
    .multiselect-tag-remove {
        margin-left: 0.25rem;
        cursor: pointer;
        color: #1e40af;
    }
    
    .multiselect-placeholder {
        color: #9ca3af;
        margin: 0.25rem;
    }
    
    .multiselect-search {
        flex: 1;
        border: none;
        outline: none;
        padding: 0.25rem;
        min-width: 50px;
        background: transparent;
    }
    
    .multiselect-dropdown {
        position: absolute;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 10;
        max-height: 200px;
        overflow-y: auto;
        background-color: #fff;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        margin-top: 0.25rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        display: none;
    }
    
    .multiselect-dropdown.show {
        display: block;
    }
    
    .multiselect-option {
        padding: 0.5rem 0.75rem;
        cursor: pointer;
        transition: background-color 0.2s;
    }
    
    .multiselect-option:hover {
        background-color: #f3f4f6;
    }
    
    .multiselect-option.selected {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .multiselect-option.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }
    
    .multiselect-no-results {
        padding: 0.5rem 0.75rem;
        color: #9ca3af;
        font-style: italic;
    }
    
    /* Styles pour les niveaux de langue */
    .language-level {
        display: flex;
        align-items: center;
        margin-top: 0.5rem;
        padding: 0.5rem;
        background-color: #f9fafb;
        border-radius: 0.375rem;
    }
    
    .language-level-label {
        flex: 1;
        font-weight: 500;
    }
    
    .language-level-select {
        width: 150px;
    }
</style>
@endsection

@section('content')
<div class="form-container">
    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 p-4 mb-6">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">Veuillez corriger les erreurs suivantes :</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('offers.update', $offre->id) }}" id="offre-form">
        @csrf
        @method('PUT')
        
        <div class="form-section">
            <h2 class="section-title">Informations générales</h2>
            
            <!-- Titre de l'offre -->
            <div class="form-group">
                <label for="title" class="form-label">
                    Titre de l'offre
                    <span class="required-star">*</span>
                </label>
                <input id="title" name="title" type="text" required value="{{ old('title', $offre->title) }}"
                    class="form-input @error('title') border-red-500 @enderror"
                    placeholder="Ex: Développeur Web Full Stack">
                @error('title')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Nombre de postes -->
                <div class="form-group">
                    <label for="nombre_poste" class="form-label">
                        Nombre de postes à pourvoir
                        <span class="required-star">*</span>
                    </label>
                    <input id="nombre_poste" name="nombre_poste" type="number" min="1" required value="{{ old('nombre_poste', $offre->nombre_poste) }}"
                        class="form-input @error('nombre_poste') border-red-500 @enderror">
                    @error('nombre_poste')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Lieu -->
                <div class="form-group">
                    <label for="location" class="form-label">
                        Lieu
                        <span class="required-star">*</span>
                    </label>
                    <input id="location" name="location" type="text" required value="{{ old('location', $offre->location) }}"
                        class="form-input @error('location') border-red-500 @enderror"
                        placeholder="Ex: Paris, France">
                    @error('location')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Type de contrat -->
                <div class="form-group">
                    <label for="type_contrat" class="form-label">
                        Type de contrat
                        <span class="required-star">*</span>
                    </label>
                    <select id="type_contrat" name="type_contrat" required 
                        class="form-select @error('type_contrat') border-red-500 @enderror">
                        <option value="">Sélectionnez un type de contrat</option>
                        <option value="CDI" {{ old('type_contrat', $offre->type_contrat) == 'CDI' ? 'selected' : '' }}>CDI</option>
                        <option value="CDD" {{ old('type_contrat', $offre->type_contrat) == 'CDD' ? 'selected' : '' }}>CDD</option>
                        <option value="Intérim" {{ old('type_contrat', $offre->type_contrat) == 'Intérim' ? 'selected' : '' }}>Intérim</option>
                        <option value="Stage" {{ old('type_contrat', $offre->type_contrat) == 'Stage' ? 'selected' : '' }}>Stage</option>
                        <option value="Alternance" {{ old('type_contrat', $offre->type_contrat) == 'Alternance' ? 'selected' : '' }}>Alternance</option>
                        <option value="Freelance" {{ old('type_contrat', $offre->type_contrat) == 'Freelance' ? 'selected' : '' }}>Freelance</option>
                    </select>
                    @error('type_contrat')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Mode de travail -->
                <div class="form-group">
                    <label for="mode_travail" class="form-label">
                        Mode de travail
                        <span class="required-star">*</span>
                    </label>
                    <select id="mode_travail" name="mode_travail" required 
                        class="form-select @error('mode_travail') border-red-500 @enderror">
                        <option value="">Sélectionnez un mode de travail</option>
                        <option value="Sur site" {{ old('mode_travail', $offre->mode_travail) == 'Sur site' ? 'selected' : '' }}>Sur site</option>
                        <option value="Hybride" {{ old('mode_travail', $offre->mode_travail) == 'Hybride' ? 'selected' : '' }}>Hybride</option>
                        <option value="Télétravail" {{ old('mode_travail', $offre->mode_travail) == 'Télétravail' ? 'selected' : '' }}>Télétravail complet</option>
                    </select>
                    @error('mode_travail')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Salaire -->
                <div class="form-group">
                    <label for="salaire" class="form-label">
                        Salaire annuel (€)
                        <span class="required-star">*</span>
                    </label>
                    <div class="input-with-icon">
                        <div class="icon">
                            <i class="fas fa-euro-sign"></i>
                        </div>
                        <input id="salaire" name="salaire" type="number" min="0" required value="{{ old('salaire', $offre->salaire) }}"
                            class="form-input @error('salaire') border-red-500 @enderror"
                            placeholder="Ex: 45000">
                    </div>
                    @error('salaire')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Expérience requise -->
                <div class="form-group">
                    <label for="experience" class="form-label">
                        Expérience requise (années)
                        <span class="required-star">*</span>
                    </label>
                    <select id="experience" name="experience" required 
                        class="form-select @error('experience') border-red-500 @enderror">
                        <option value="">Sélectionnez l'expérience requise</option>
                        <option value="0" {{ old('experience', $offre->experience) == '0' ? 'selected' : '' }}>Débutant accepté</option>
                        <option value="1" {{ old('experience', $offre->experience) == '1' ? 'selected' : '' }}>1 an</option>
                        <option value="2" {{ old('experience', $offre->experience) == '2' ? 'selected' : '' }}>2 ans</option>
                        <option value="3" {{ old('experience', $offre->experience) == '3' ? 'selected' : '' }}>3 ans</option>
                        <option value="5" {{ old('experience', $offre->experience) == '5' ? 'selected' : '' }}>5 ans</option>
                        <option value="7" {{ old('experience', $offre->experience) == '7' ? 'selected' : '' }}>7 ans</option>
                        <option value="10" {{ old('experience', $offre->experience) == '10' ? 'selected' : '' }}>10 ans et plus</option>
                    </select>
                    @error('experience')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            
            <!-- Date d'expiration -->
            <div class="form-group">
                <label for="date_expiration" class="form-label">
                    Date d'expiration de l'offre
                </label>
                <input id="date_expiration" name="date_expiration" type="date" value="{{ old('date_expiration', $offre->date_expiration ? date('Y-m-d', strtotime($offre->date_expiration)) : '') }}"
                    class="form-input @error('date_expiration') border-red-500 @enderror"
                    min="{{ date('Y-m-d') }}">
                <p class="form-help-text">Laissez vide si l'offre n'a pas de date d'expiration.</p>
                @error('date_expiration')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="form-section">
            <h2 class="section-title">Description du poste</h2>
            
            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">
                    Description détaillée
                    <span class="required-star">*</span>
                </label>
                <textarea id="description" name="description" rows="10" required 
                    class="form-textarea @error('description') border-red-500 @enderror"
                    placeholder="Décrivez le poste, les responsabilités, les compétences requises, les avantages, etc.">{{ old('description', $offre->description) }}</textarea>
                <p class="form-help-text">Soyez précis et détaillé pour attirer les meilleurs candidats.</p>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <!-- Compétences requises -->
        <div class="form-section">
            <h2 class="section-title">Compétences requises</h2>
            
            <div class="form-group">
                <label for="skills" class="form-label">
                    Compétences
                    <span class="required-star">*</span>
                </label>
                
                <div class="multiselect-container" id="skills-container">
                    <div class="multiselect-input" id="skills-input">
                        <div class="multiselect-placeholder" id="skills-placeholder">Sélectionnez des compétences...</div>
                        <input type="text" class="multiselect-search" id="skills-search" placeholder="">
                    </div>
                    
                    <div class="multiselect-dropdown" id="skills-dropdown">
                        <!-- Les options seront ajoutées dynamiquement -->
                        <div class="multiselect-no-results" id="skills-no-results" style="display: none;">Aucun résultat trouvé</div>
                    </div>
                    
                    <!-- Champs cachés pour stocker les IDs des compétences sélectionnées -->
                    <div id="skill-ids-container"></div>
                </div>
                
                @error('skill_ids')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                
                <p class="form-help-text">Sélectionnez les compétences requises pour ce poste pour améliorer le matching avec les candidats.</p>
            </div>
        </div>
        
        <!-- Langues requises -->
        <div class="form-section">
            <h2 class="section-title">Langues requises</h2>
            
            <div class="form-group">
                <label for="languages" class="form-label">
                    Langues
                </label>
                
                <div class="multiselect-container" id="languages-container">
                    <div class="multiselect-input" id="languages-input">
                        <div class="multiselect-placeholder" id="languages-placeholder">Sélectionnez des langues...</div>
                        <input type="text" class="multiselect-search" id="languages-search" placeholder="">
                    </div>
                    
                    <div class="multiselect-dropdown" id="languages-dropdown">
                        <!-- Les options seront ajoutées dynamiquement -->
                        <div class="multiselect-no-results" id="languages-no-results" style="display: none;">Aucun résultat trouvé</div>
                    </div>
                </div>
                
                <!-- Conteneur pour les niveaux de langue -->
                <div id="language-levels-container" class="mt-4">
                    <!-- Les niveaux de langue seront ajoutés dynamiquement -->
                </div>
                
                <!-- Champs cachés pour stocker les IDs des langues sélectionnées -->
                <div id="language-ids-container"></div>
                
                @error('language_ids')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                
                <p class="form-help-text">Sélectionnez les langues requises pour ce poste pour améliorer le matching avec les candidats.</p>
            </div>
        </div>
        
        <div class="form-section">
            <h2 class="section-title">Statut de publication</h2>
            
            <!-- Statut -->
            <div class="form-group">
                <label for="statut" class="form-label">
                    Statut de l'offre
                    <span class="required-star">*</span>
                </label>
                <select id="statut" name="statut" required 
                    class="form-select @error('statut') border-red-500 @enderror">
                    <option value="brouillon" {{ old('statut', $offre->statut) == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="publiée" {{ old('statut', $offre->statut) == 'publiée' ? 'selected' : '' }}>Publiée</option>
                </select>
                <p class="form-help-text">Les offres en brouillon ne sont pas visibles par les candidats.</p>
                @error('statut')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 mb-6">
            <a href="{{ route('offers.index') }}" class="btn-secondary">
                Annuler
            </a>
            <button type="submit" name="save_draft" value="1" class="btn-secondary">
                Enregistrer comme brouillon
            </button>
            <button type="submit" name="publish" value="1" class="btn-primary">
                Mettre à jour l'offre
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('offre-form');
        const publishButton = document.querySelector('button[name="publish"]');
        const draftButton = document.querySelector('button[name="save_draft"]');
        const statutSelect = document.getElementById('statut');
        
        // Mettre à jour le statut en fonction du bouton cliqué
        publishButton.addEventListener('click', function() {
            statutSelect.value = 'publiée';
        });
        
        draftButton.addEventListener('click', function() {
            statutSelect.value = 'brouillon';
        });
        
        // Formater la date d'expiration minimale
        const dateExpirationField = document.getElementById('date_expiration');
        const today = new Date();
        const minDate = new Date(today);
        minDate.setDate(today.getDate() + 1); // Au moins un jour dans le futur
        
        const formatDate = (date) => {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };
        
        dateExpirationField.min = formatDate(minDate);
        
        // ===== GESTION DES COMPÉTENCES =====
        
        // Données des compétences
        const skills = @json($skills);
        
        // Éléments DOM pour les compétences
        const skillsContainer = document.getElementById('skills-container');
        const skillsInput = document.getElementById('skills-input');
        const skillsPlaceholder = document.getElementById('skills-placeholder');
        const skillsSearch = document.getElementById('skills-search');
        const skillsDropdown = document.getElementById('skills-dropdown');
        const skillsNoResults = document.getElementById('skills-no-results');
        const skillIdsContainer = document.getElementById('skill-ids-container');
        
        // Ensemble pour suivre les compétences sélectionnées
        const selectedSkills = new Set();
        
        // Initialiser les compétences sélectionnées depuis l'offre existante
        @foreach($offre->skills as $skill)
            selectedSkills.add({{ $skill->id }});
            addSkillTag({{ $skill->id }}, "{{ $skill->name }}");
            addSkillIdInput({{ $skill->id }});
        @endforeach
        updateSkillsPlaceholder();
        
        // Fonction pour ajouter un tag de compétence
        function addSkillTag(id, name) {
            const tag = document.createElement('div');
            tag.className = 'multiselect-tag';
            tag.dataset.id = id;
            tag.innerHTML = `
                ${name}
                <span class="multiselect-tag-remove" data-id="${id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </span>
            `;
            
            // Ajouter le tag avant le champ de recherche
            skillsInput.insertBefore(tag, skillsSearch);
            
            // Ajouter l'événement de suppression
            tag.querySelector('.multiselect-tag-remove').addEventListener('click', function() {
                const skillId = this.dataset.id;
                removeSkill(skillId);
            });
        }
        
        // Fonction pour ajouter un input caché pour l'ID de compétence
        function addSkillIdInput(id) {
            // Vérifier si l'input existe déjà
            if (!document.querySelector(`input[name="skill_ids[]"][value="${id}"]`)) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'skill_ids[]';
                input.value = id;
                skillIdsContainer.appendChild(input);
            }
        }
        
        // Fonction pour supprimer une compétence
        function removeSkill(id) {
            selectedSkills.delete(parseInt(id));
            
            // Supprimer le tag
            const tag = skillsInput.querySelector(`.multiselect-tag[data-id="${id}"]`);
            if (tag) {
                tag.remove();
            }
            
            // Supprimer l'input caché
            const input = skillIdsContainer.querySelector(`input[name="skill_ids[]"][value="${id}"]`);
            if (input) {
                input.remove();
            }
            
            // Mettre à jour l'option dans le dropdown
            const option = skillsDropdown.querySelector(`.multiselect-option[data-id="${id}"]`);
            if (option) {
                option.classList.remove('selected');
            }
            
            updateSkillsPlaceholder();
        }
        
        // Fonction pour mettre à jour le placeholder
        function updateSkillsPlaceholder() {
            if (selectedSkills.size > 0) {
                skillsPlaceholder.style.display = 'none';
            } else {
                skillsPlaceholder.style.display = 'block';
            }
        }
        
        // Fonction pour filtrer les compétences
        function filterSkills(query) {
            const filteredSkills = skills.filter(skill => 
                skill.name.toLowerCase().includes(query.toLowerCase())
            );
            
            // Vider le dropdown
            while (skillsDropdown.firstChild) {
                if (skillsDropdown.firstChild === skillsNoResults) {
                    break;
                }
                skillsDropdown.removeChild(skillsDropdown.firstChild);
            }
            
            if (filteredSkills.length === 0) {
                skillsNoResults.style.display = 'block';
            } else {
                skillsNoResults.style.display = 'none';
                
                // Ajouter les options filtrées
                filteredSkills.forEach(skill => {
                    const option = document.createElement('div');
                    option.className = `multiselect-option ${selectedSkills.has(skill.id) ? 'selected' : ''}`;
                    option.dataset.id = skill.id;
                    option.textContent = skill.name;
                    
                    option.addEventListener('click', function() {
                        const skillId = parseInt(this.dataset.id);
                        
                        if (selectedSkills.has(skillId)) {
                            removeSkill(skillId);
                        } else {
                            selectedSkills.add(skillId);
                            addSkillTag(skillId, skill.name);
                            addSkillIdInput(skillId);
                            this.classList.add('selected');
                            updateSkillsPlaceholder();
                        }
                        
                        // Vider le champ de recherche et se concentrer dessus
                        skillsSearch.value = '';
                        skillsSearch.focus();
                    });
                    
                    skillsDropdown.insertBefore(option, skillsNoResults);
                });
            }
        }
        
        // Événements pour les compétences
        skillsInput.addEventListener('click', function() {
            skillsSearch.focus();
        });
        
        skillsSearch.addEventListener('focus', function() {
            filterSkills('');
            skillsDropdown.classList.add('show');
        });
        
        skillsSearch.addEventListener('input', function() {
            filterSkills(this.value);
        });
        
        document.addEventListener('click', function(e) {
            if (!skillsContainer.contains(e.target)) {
                skillsDropdown.classList.remove('show');
            }
        });
        
        // ===== GESTION DES LANGUES =====
        
        // Données des langues
        const languages = @json($languages);
        
        // Niveaux de langue disponibles
        const languageLevels = [
            { value: 'débutant', label: 'Débutant' },
            { value: 'intermédiaire', label: 'Intermédiaire' },
            { value: 'avancé', label: 'Avancé' },
            { value: 'courant', label: 'Courant' },
            { value: 'natif', label: 'Langue maternelle' }
        ];
        
        // Éléments DOM pour les langues
        const languagesContainer = document.getElementById('languages-container');
        const languagesInput = document.getElementById('languages-input');
        const languagesPlaceholder = document.getElementById('languages-placeholder');
        const languagesSearch = document.getElementById('languages-search');
        const languagesDropdown = document.getElementById('languages-dropdown');
        const languagesNoResults = document.getElementById('languages-no-results');
        const languageLevelsContainer = document.getElementById('language-levels-container');
        const languageIdsContainer = document.getElementById('language-ids-container');
        
        // Map pour suivre les langues sélectionnées avec leurs niveaux
        const selectedLanguages = new Map();
        
        // Initialiser les langues sélectionnées depuis l'offre existante
        @foreach($offre->languages as $language)
            selectedLanguages.set({{ $language->id }}, { 
                name: "{{ $language->name }}", 
                level: "{{ $language->pivot->level ?? 'courant' }}" 
            });
            addLanguageTag({{ $language->id }}, "{{ $language->name }}");
            addLanguageLevel({{ $language->id }}, "{{ $language->name }}", "{{ $language->pivot->level ?? 'courant' }}");
            addLanguageIdInput({{ $language->id }}, "{{ $language->pivot->level ?? 'courant' }}");
        @endforeach
        updateLanguagesPlaceholder();
        
        // Fonction pour ajouter un tag de langue
        function addLanguageTag(id, name) {
            const tag = document.createElement('div');
            tag.className = 'multiselect-tag';
            tag.dataset.id = id;
            tag.innerHTML = `
                ${name}
                <span class="multiselect-tag-remove" data-id="${id}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </span>
            `;
            
            // Ajouter le tag avant le champ de recherche
            languagesInput.insertBefore(tag, languagesSearch);
            
            // Ajouter l'événement de suppression
            tag.querySelector('.multiselect-tag-remove').addEventListener('click', function() {
                const langId = this.dataset.id;
                removeLanguage(langId);
            });
        }
        
        // Fonction pour ajouter un input caché pour l'ID de langue et son niveau
        function addLanguageIdInput(id, level) {
            // Vérifier si l'input existe déjà
            if (!document.querySelector(`input[name="language_ids[]"][value="${id}"]`)) {
                const inputId = document.createElement('input');
                inputId.type = 'hidden';
                inputId.name = 'language_ids[]';
                inputId.value = id;
                
                const inputLevel = document.createElement('input');
                inputLevel.type = 'hidden';
                inputLevel.name = 'language_levels[]';
                inputLevel.value = level;
                inputLevel.dataset.id = id;
                
                languageIdsContainer.appendChild(inputId);
                languageIdsContainer.appendChild(inputLevel);
            }
        }
        
        // Fonction pour ajouter un sélecteur de niveau de langue
        function addLanguageLevel(id, name, level = 'courant') {
            // Vérifier si le niveau existe déjà
            const existingLevel = languageLevelsContainer.querySelector(`#language-level-${id}`);
            if (existingLevel) {
                // Mettre à jour le niveau existant
                existingLevel.querySelector('select').value = level;
                return;
            }
            
            // Créer un nouvel élément de niveau
            const levelElement = document.createElement('div');
            levelElement.className = 'language-level';
            levelElement.id = `language-level-${id}`;
            
            // Créer le label
            const labelElement = document.createElement('div');
            labelElement.className = 'language-level-label';
            labelElement.textContent = name;
            
            // Créer le select
            const selectElement = document.createElement('select');
            selectElement.className = 'form-select language-level-select';
            selectElement.dataset.id = id;
            
            // Ajouter les options
            languageLevels.forEach(levelOption => {
                const option = document.createElement('option');
                option.value = levelOption.value;
                option.textContent = levelOption.label;
                option.selected = levelOption.value === level;
                selectElement.appendChild(option);
            });
            
            // Ajouter l'événement de changement
            selectElement.addEventListener('change', function() {
                const langId = parseInt(this.dataset.id);
                const langData = selectedLanguages.get(langId);
                if (langData) {
                    langData.level = this.value;
                    selectedLanguages.set(langId, langData);
                    
                    // Mettre à jour l'input caché du niveau
                    const levelInput = languageIdsContainer.querySelector(`input[name="language_levels[]"][data-id="${langId}"]`);
                    if (levelInput) {
                        levelInput.value = this.value;
                    }
                }
            });
            
            // Assembler l'élément
            levelElement.appendChild(labelElement);
            levelElement.appendChild(selectElement);
            
            // Ajouter au conteneur
            languageLevelsContainer.appendChild(levelElement);
        }
        
        // Fonction pour supprimer une langue
        function removeLanguage(id) {
            selectedLanguages.delete(parseInt(id));
            
            // Supprimer le tag
            const tag = languagesInput.querySelector(`.multiselect-tag[data-id="${id}"]`);
            if (tag) {
                tag.remove();
            }
            
            // Supprimer le niveau
            const level = languageLevelsContainer.querySelector(`#language-level-${id}`);
            if (level) {
                level.remove();
            }
            
            // Supprimer les inputs cachés
            const inputId = languageIdsContainer.querySelector(`input[name="language_ids[]"][value="${id}"]`);
            const inputLevel = languageIdsContainer.querySelector(`input[name="language_levels[]"][data-id="${id}"]`);
            if (inputId) inputId.remove();
            if (inputLevel) inputLevel.remove();
            
            // Mettre à jour l'option dans le dropdown
            const option = languagesDropdown.querySelector(`.multiselect-option[data-id="${id}"]`);
            if (option) {
                option.classList.remove('selected');
            }
            
            updateLanguagesPlaceholder();
        }
        
        // Fonction pour mettre à jour le placeholder
        function updateLanguagesPlaceholder() {
            if (selectedLanguages.size > 0) {
                languagesPlaceholder.style.display = 'none';
            } else {
                languagesPlaceholder.style.display = 'block';
            }
        }
        
        // Fonction pour filtrer les langues
        function filterLanguages(query) {
            const filteredLanguages = languages.filter(language => 
                language.name.toLowerCase().includes(query.toLowerCase())
            );
            
            // Vider le dropdown
            while (languagesDropdown.firstChild) {
                if (languagesDropdown.firstChild === languagesNoResults) {
                    break;
                }
                languagesDropdown.removeChild(languagesDropdown.firstChild);
            }
            
            if (filteredLanguages.length === 0) {
                languagesNoResults.style.display = 'block';
            } else {
                languagesNoResults.style.display = 'none';
                
                // Ajouter les options filtrées
                filteredLanguages.forEach(language => {
                    const option = document.createElement('div');
                    option.className = `multiselect-option ${selectedLanguages.has(language.id) ? 'selected' : ''}`;
                    option.dataset.id = language.id;
                    option.textContent = language.name;
                    
                    option.addEventListener('click', function() {
                        const langId = parseInt(this.dataset.id);
                        
                        if (selectedLanguages.has(langId)) {
                            removeLanguage(langId);
                        } else {
                            selectedLanguages.set(langId, { name: language.name, level: 'courant' });
                            addLanguageTag(langId, language.name);
                            addLanguageLevel(langId, language.name);
                            addLanguageIdInput(langId, 'courant');
                            this.classList.add('selected');
                            updateLanguagesPlaceholder();
                        }
                        
                        // Vider le champ de recherche et se concentrer dessus
                        languagesSearch.value = '';
                        languagesSearch.focus();
                    });
                    
                    languagesDropdown.insertBefore(option, languagesNoResults);
                });
            }
        }
        
        // Événements pour les langues
        languagesInput.addEventListener('click', function() {
            languagesSearch.focus();
        });
        
        languagesSearch.addEventListener('focus', function() {
            filterLanguages('');
            languagesDropdown.classList.add('show');
        });
        
        languagesSearch.addEventListener('input', function() {
            filterLanguages(this.value);
        });
        
        document.addEventListener('click', function(e) {
            if (!languagesContainer.contains(e.target)) {
                languagesDropdown.classList.remove('show');
            }
        });
        
        // Validation du formulaire
        form.addEventListener('submit', function(event) {
            let isValid = true;
            const requiredFields = form.querySelectorAll('[required]');
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('border-red-500');
                } else {
                    field.classList.remove('border-red-500');
                }
            });
            
            // Vérifier que des compétences sont sélectionnées
            if (selectedSkills.size === 0) {
                isValid = false;
                skillsInput.classList.add('border-red-500');
                
                // Ajouter un message d'erreur
                if (!document.querySelector('#skills-error')) {
                    const errorMessage = document.createElement('p');
                    errorMessage.id = 'skills-error';
                    errorMessage.className = 'form-error';
                    errorMessage.textContent = 'Veuillez sélectionner au moins une compétence.';
                    skillsContainer.parentNode.appendChild(errorMessage);
                }
            } else {
                skillsInput.classList.remove('border-red-500');
                const errorMessage = document.querySelector('#skills-error');
                if (errorMessage) {
                    errorMessage.remove();
                }
            }
            
            if (!isValid) {
                event.preventDefault();
                window.scrollTo(0, 0);
                
                // Afficher un message d'erreur général
                if (!document.querySelector('.error-message')) {
                    const errorMessage = document.createElement('div');
                    errorMessage.className = 'bg-red-50 border-l-4 border-red-500 p-4 mb-6 error-message';
                    errorMessage.innerHTML = `
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-red-800">Veuillez remplir tous les champs obligatoires.</h3>
                            </div>
                        </div>
                    `;
                    form.prepend(errorMessage);
                }
            }
        });
    });
</script>
@endsection

"
voici le fichier views/recruter/offres.blade.php : 
"@extends('layouts.recruteur')

@section('title', 'Gestion des offres d\'emploi')

@section('styles')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .filters-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        align-items: center;
    }
    
    .filter-badge {
        display: inline-flex;
        align-items: center;
        background-color: #2557a7;
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-weight: 500;
    }
    
    .filter-select {
        min-width: 180px;
        padding: 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        background-color: white;
    }
    
    .search-container {
        display: flex;
        margin-left: auto;
    }
    
    .search-input {
        padding: 0.5rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem 0 0 0.375rem;
        min-width: 250px;
    }
    
    .search-button {
        display: flex;
        align-items: center;
        justify-content: center;
        background-color: #f3f4f6;
        border: 1px solid #d1d5db;
        border-left: none;
        border-radius: 0 0.375rem 0.375rem 0;
        padding: 0 0.75rem;
        cursor: pointer;
    }
    
    .search-button:hover {
        background-color: #e5e7eb;
    }
    
    .table-container {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        overflow: hidden;
    }
    
    .offers-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .offers-table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 500;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .offers-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    
    .offers-table tr:last-child td {
        border-bottom: none;
    }
    
    .offers-table tr:hover {
        background-color: #f9fafb;
    }
    
    .sortable {
        cursor: pointer;
        position: relative;
    }
    
    .sortable::after {
        content: '↕';
        position: absolute;
        right: 0.5rem;
        color: #9ca3af;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-published {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-draft {
        background-color: #e5e7eb;
        color: #4b5563;
    }
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-closed {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .status-suspended {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .action-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 0.25rem;
    }
    
    .action-button:hover {
        background-color: #f3f4f6;
    }
    
    .dropdown {
        position: relative;
        display: inline-block;
    }
    
    .dropdown-content {
        display: none;
        position: absolute;
        right: 0;
        bottom: auto;
        min-width: 200px;
        background-color: white;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        border-radius: 0.375rem;
        z-index: 10;
        /* Assurez-vous que le dropdown reste visible même en bas de la table */
        transform: translateY(0);
    }

    /* Pour les dernières lignes, afficher le dropdown vers le haut */
    tr:nth-last-child(-n+2) .dropdown-content {
        bottom: 100%;
        top: auto;
        margin-bottom: 5px;
    }
    
    .dropdown-content a {
        display: block;
        padding: 0.75rem 1rem;
        color: #374151;
        text-decoration: none;
        transition: background-color 0.2s;
    }
    
    .dropdown-content a:hover {
        background-color: #f3f4f6;
    }
    
    .show {
        display: block;
    }
    
    .empty-state {
        text-align: center;
        padding: 3rem 1rem;
        color: #6b7280;
    }
    
    .empty-state-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: #d1d5db;
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #4b5563;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        background-color: #374151;
    }
    
    .info-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #eff6ff;
        color: #1e40af;
        border-radius: 9999px;
        width: 1.5rem;
        height: 1.5rem;
        font-size: 0.75rem;
        margin-left: 0.5rem;
    }
    
    .application-count {
        font-weight: 500;
    }
    
    .application-message {
        color: #6b7280;
        font-size: 0.875rem;
        font-style: italic;
    }
    
    .action-buttons {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .settings-button {
        background: none;
        border: none;
        cursor: pointer;
        padding: 0.25rem;
        border-radius: 0.25rem;
        color: #4b5563;
    }
    
    .settings-button:hover {
        background-color: #f3f4f6;
        color: #2557a7;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto py-6 px-4">
    <!-- Header -->
    <div class="header-container">
        <h1 class="text-2xl font-bold text-gray-900">Emplois</h1>
        <a href="{{ route('offers.create') }}" class="btn-primary">
            <i class="fas fa-plus-circle mr-2"></i>
            Publier une offre d'emploi
        </a>
    </div>
    
    <!-- Filters -->
    <div class="filters-container">
        <div class="filter-badge">
            Nouveau
        </div>
        
        <select class="filter-select" id="status-filter">
            <option value="">Statut (Tous)</option>
            <option value="publiée" {{ request('status') == 'publiée' ? 'selected' : '' }}>Publiée</option>
            <option value="brouillon" {{ request('status') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
            <option value="en attente" {{ request('status') == 'en attente' ? 'selected' : '' }}>En attente</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            <option value="suspendu" {{ request('status') == 'suspendu' ? 'selected' : '' }}>Suspendu</option>
        </select>
        
        <div class="search-container">
            <input type="text" class="search-input" id="search-input" placeholder="Rechercher des offres..." value="{{ request('search') }}">
            <button class="search-button" id="search-button">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
    
    <!-- Table -->
    <div class="table-container">
        @if(count($offres) > 0)
            <table class="offers-table">
                <thead>
                    <tr>
                        <th class="sortable" data-sort="title">Intitulé du poste</th>
                        <th>Candidatures</th>
                        <th class="sortable" data-sort="created_at">Date de publication</th>
                        <th>Statut de l'emploi</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offres as $offre)
                        <tr>
                            <td>
                                <div class="font-medium">{{ $offre->title }}</div>
                                <div class="text-sm text-gray-500">{{ $offre->location }}</div>
                            </td>
                            <td>
                                @if($offre->applications_count > 0)
                                    <span class="application-count">{{ $offre->applications_count }}</span>
                                @else
                                    @if($offre->statut == 'publiée')
                                        <span class="application-message">Aucune candidature pour le moment</span>
                                    @elseif($offre->statut == 'brouillon')
                                        <span class="application-message">L'offre n'est pas encore publiée</span>
                                    @elseif($offre->statut == 'rejected')
                                        <span class="application-message">Votre Offre n'a pas accepter</span>
                                    @elseif($offre->statut == 'en attente')
                                        <span class="application-message">Votre offre d'emploi n'est pas encore publiée sur WorkBridge</span>
                                    @else
                                        <span class="application-message">Aucune candidature</span>
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if($offre->created_at)
                                    {{ $offre->created_at->format('d/m/Y') }}
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                @if($offre->statut == 'publiée')
                                    <span class="status-badge status-published">Publiée</span>
                                @elseif($offre->statut == 'brouillon')
                                    <span class="status-badge status-draft">Brouillon</span>
                                @elseif($offre->statut == 'en attente')
                                    <span class="status-badge status-pending">En attente</span>
                                @elseif($offre->statut == 'rejected')
                                    <span class="status-badge status-closed">Rejectede</span>
                                @elseif($offre->statut == 'suspendu')
                                    <span class="status-badge status-suspended">Suspendue</span>
                                @else
                                    <span class="status-badge">{{ $offre->statut }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('preference.index', $offre->id) }}" class="settings-button" title="Paramètres de matching">
                                        <i class="fas fa-cog"></i>
                                    </a>
                                    <div class="dropdown">
                                        <button class="action-button" onclick="toggleDropdown('dropdown-{{ $offre->id }}')">
                                            <i class="fas fa-ellipsis-v"></i>
                                        </button>
                                        <div id="dropdown-{{ $offre->id }}" class="dropdown-content">
                                            <a href="{{ route('offers.edit', $offre->id) }}">
                                                <i class="fas fa-edit mr-2"></i> Modifier l'emploi
                                            </a>
                                            <a href="{{ route('offers.show', $offre->id) }}">
                                                <i class="fas fa-eye mr-2"></i> Voir les détails
                                            </a>
                                            @if($offre->statut == 'brouillon')
                                                <a href="#">
                                                    <i class="fas fa-paper-plane mr-2"></i> Publier l'offre
                                                </a>
                                            @endif
                                            @if($offre->statut == 'publiée')
                                                <a href="#">
                                                    <i class="fas fa-times-circle mr-2"></i> Fermer l'offre
                                                </a>
                                            @endif
                                            <a href="#" onclick="confirmDelete('{{ $offre->id }}')">
                                                <i class="fas fa-trash-alt mr-2"></i> Supprimer
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3 class="text-lg font-medium mb-2">Aucune offre d'emploi</h3>
                <p class="mb-4">Vous n'avez pas encore créé d'offre d'emploi.</p>
                <a href="{{ route('offers.create') }}" class="btn-primary">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Créer une offre d'emploi
                </a>
            </div>
        @endif
    </div>
    
    <!-- Pagination -->
    @if(count($offres) > 0)
        <div class="mt-4">
            {{ $offres->links() }}
        </div>
    @endif
    
    <!-- Delete Confirmation Modal -->
    <div id="delete-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg p-6 max-w-md w-full">
            <h3 class="text-lg font-medium mb-4">Confirmer la suppression</h3>
            <p class="mb-6">Êtes-vous sûr de vouloir supprimer cette offre d'emploi ? Cette action est irréversible.</p>
            <div class="flex justify-end space-x-4">
                <button type="button" class="px-4 py-2 border border-gray-300 rounded-md text-gray-700" onclick="closeDeleteModal()">Annuler</button>
                <form id="delete-form" method="POST" action="">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md">Supprimer</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle dropdown menu
    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        dropdown.classList.toggle('show');
        
        // Assurez-vous que le dropdown est visible dans la fenêtre
        if (dropdown.classList.contains('show')) {
            const rect = dropdown.getBoundingClientRect();
            const viewHeight = Math.max(document.documentElement.clientHeight, window.innerHeight);
            
            // Si le dropdown dépasse le bas de l'écran, l'afficher vers le haut
            if (rect.bottom > viewHeight) {
                dropdown.style.bottom = '100%';
                dropdown.style.top = 'auto';
                dropdown.style.marginBottom = '5px';
            } else {
                dropdown.style.top = 'auto';
                dropdown.style.bottom = 'auto';
            }
        }
        
        // Close other dropdowns
        const dropdowns = document.getElementsByClassName('dropdown-content');
        for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.id !== id && openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
    
    // Close dropdowns when clicking outside
    window.onclick = function(event) {
        if (!event.target.matches('.action-button') && !event.target.matches('.fa-ellipsis-v')) {
            const dropdowns = document.getElementsByClassName('dropdown-content');
            for (let i = 0; i < dropdowns.length; i++) {
                const openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
    
    // Handle search
    document.getElementById('search-button').addEventListener('click', function() {
        const searchValue = document.getElementById('search-input').value;
        const statusValue = document.getElementById('status-filter').value;
        
        let url = '{{ route("offers.index") }}?';
        if (searchValue) {
            url += 'search=' + encodeURIComponent(searchValue);
        }
        
        if (statusValue) {
            url += (searchValue ? '&' : '') + 'status=' + encodeURIComponent(statusValue);
        }
        
        window.location.href = url;
    });
    
    // Handle status filter change
    document.getElementById('status-filter').addEventListener('change', function() {
        const searchValue = document.getElementById('search-input').value;
        const statusValue = this.value;
        
        let url = '{{ route("offers.index") }}?';
        if (statusValue) {
            url += 'status=' + encodeURIComponent(statusValue);
        }
        
        if (searchValue) {
            url += (statusValue ? '&' : '') + 'search=' + encodeURIComponent(searchValue);
        }
        
        window.location.href = url;
    });
    
    // Handle enter key in search input
    document.getElementById('search-input').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            document.getElementById('search-button').click();
        }
    });
    
    // Handle sorting
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function() {
            const sort = this.dataset.sort;
            const currentSort = new URLSearchParams(window.location.search).get('sort') || '';
            const currentDirection = new URLSearchParams(window.location.search).get('direction') || 'asc';
            
            let direction = 'asc';
            if (sort === currentSort && currentDirection === 'asc') {
                direction = 'desc';
            }
            
            const searchValue = document.getElementById('search-input').value;
            const statusValue = document.getElementById('status-filter').value;
            
            let url = '{{ route("offers.index") }}?sort=' + sort + '&direction=' + direction;
            
            if (searchValue) {
                url += '&search=' + encodeURIComponent(searchValue);
            }
            
            if (statusValue) {
                url += '&status=' + encodeURIComponent(statusValue);
            }
            
            window.location.href = url;
        });
    });
    
    // Delete confirmation
    function confirmDelete(id) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        
        form.action = '{{ route("offers.index") }}/' + id;
        modal.classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        const modal = document.getElementById('delete-modal');
        modal.classList.add('hidden');
    }
</script>
@endsection
"
voici le fichier views/recruter/offreshow.blade.php : 
"@extends('layouts.recruteur')

@section('title', 'Détails de l\'offre d\'emploi')

@section('styles')
<style>
    .container {
        max-width: 800px;
        margin: 0 auto;
        padding: 1.5rem;
    }
    
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .back-button {
        display: inline-flex;
        align-items: center;
        color: #4b5563;
        font-weight: 500;
        text-decoration: none;
    }
    
    .back-button:hover {
        color: #1f2937;
    }
    
    .back-button i {
        margin-right: 0.5rem;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.75rem;
    }
    
    .btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #4f46e5;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    
    .btn-primary:hover {
        background-color: #4338ca;
    }
    
    .btn-secondary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: background-color 0.2s;
        cursor: pointer;
        border: 1px solid #d1d5db;
        text-decoration: none;
    }
    
    .btn-secondary:hover {
        background-color: #e5e7eb;
    }
    
    .btn-danger {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        background-color: #ef4444;
        color: white;
        transition: background-color 0.2s;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    
    .btn-danger:hover {
        background-color: #dc2626;
    }
    
    .section {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .job-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.5rem;
    }
    
    .job-location {
        color: #4b5563;
        margin-bottom: 1rem;
    }
    
    .job-meta {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    
    .meta-item {
        display: flex;
        flex-direction: column;
    }
    
    .meta-label {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    
    .meta-value {
        font-weight: 500;
        color: #1f2937;
    }
    
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.75rem;
        font-weight: 500;
        margin-left: 0.5rem;
    }
    
    .status-published {
        background-color: #d1fae5;
        color: #065f46;
    }
    
    .status-draft {
        background-color: #e5e7eb;
        color: #4b5563;
    }
    
    .status-pending {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .status-closed {
        background-color: #fee2e2;
        color: #991b1b;
    }
    
    .status-suspended {
        background-color: #dbeafe;
        color: #1e40af;
    }
    
    .description {
        white-space: pre-line;
        line-height: 1.6;
        color: #4b5563;
    }
    
    .skills-container, .languages-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
        margin-top: 0.5rem;
    }
    
    .skill-tag {
        display: inline-flex;
        align-items: center;
        background-color: #dbeafe;
        border: 1px solid #93c5fd;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
        color: #1e40af;
    }
    
    .language-tag {
        display: inline-flex;
        align-items: center;
        background-color: #f3e8ff;
        border: 1px solid #d8b4fe;
        border-radius: 9999px;
        padding: 0.25rem 0.75rem;
        font-size: 0.875rem;
        color: #6d28d9;
    }
    
    .language-level {
        font-size: 0.75rem;
        margin-left: 0.25rem;
        opacity: 0.8;
    }
    
    .applications-section {
        margin-top: 2rem;
    }
    
    .applications-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    
    .applications-count {
        font-size: 1.125rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    .applications-table {
        width: 100%;
        border-collapse: collapse;
    }
    
    .applications-table th {
        background-color: #f9fafb;
        padding: 0.75rem 1rem;
        text-align: left;
        font-weight: 500;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .applications-table td {
        padding: 1rem;
        border-bottom: 1px solid #e5e7eb;
        color: #1f2937;
    }
    
    .applications-table tr:last-child td {
        border-bottom: none;
    }
    
    .applications-table tr:hover {
        background-color: #f9fafb;
    }
    
    .empty-applications {
        text-align: center;
        padding: 2rem;
        color: #6b7280;
    }
    
    .delete-modal {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 50;
    }
    
    .modal-content {
        background-color: white;
        border-radius: 0.5rem;
        padding: 1.5rem;
        max-width: 28rem;
        width: 100%;
    }
    
    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 1rem;
    }
    
    .modal-body {
        margin-bottom: 1.5rem;
        color: #4b5563;
    }
    
    .modal-footer {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
    }
    
    .hidden {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="header-container">
        <a href="{{ route('offers.index') }}" class="back-button">
            <i class="fas fa-arrow-left"></i> Retour aux offres
        </a>
        
        <div class="action-buttons">
            @if($offre->statut == 'brouillon')
                <a href="#" class="btn-primary" id="publish-button">
                    <i class="fas fa-paper-plane mr-2"></i> Publier l'offre
                </a>
            @endif
            
            @if($offre->statut == 'publiée')
                <a href="#" class="btn-secondary" id="close-button">
                    <i class="fas fa-times-circle mr-2"></i> Fermer l'offre
                </a>
            @endif
            
            <a href="{{ route('offers.edit', $offre->id) }}" class="btn-secondary">
                <i class="fas fa-edit mr-2"></i> Modifier
            </a>
            
            <button type="button" class="btn-danger" id="delete-button">
                <i class="fas fa-trash-alt mr-2"></i> Supprimer
            </button>
        </div>
    </div>
    
    <div class="section">
        <div class="job-title">{{ $offre->title }}</div>
        <div class="job-location">
            <i class="fas fa-map-marker-alt mr-1"></i> {{ $offre->location }}
            
            @if($offre->statut == 'publiée')
                <span class="status-badge status-published">Publiée</span>
            @elseif($offre->statut == 'brouillon')
                <span class="status-badge status-draft">Brouillon</span>
            @elseif($offre->statut == 'en attente')
                <span class="status-badge status-pending">En attente</span>
            @elseif($offre->statut == 'fermé')
                <span class="status-badge status-closed">Fermée</span>
            @elseif($offre->statut == 'suspendu')
                <span class="status-badge status-suspended">Suspendue</span>
            @endif
        </div>
        
        <div class="job-meta">
            <div class="meta-item">
                <div class="meta-label">Type de contrat</div>
                <div class="meta-value">{{ $offre->type_contrat }}</div>
            </div>
            
            <div class="meta-item">
                <div class="meta-label">Mode de travail</div>
                <div class="meta-value">{{ $offre->mode_travail }}</div>
            </div>
            
            <div class="meta-item">
                <div class="meta-label">Salaire annuel</div>
                <div class="meta-value">{{ number_format($offre->salaire, 0, ',', ' ') }} €</div>
            </div>
            
            <div class="meta-item">
                <div class="meta-label">Expérience requise</div>
                <div class="meta-value">
                    @if($offre->experience == 0)
                        Débutant accepté
                    @else
                        {{ $offre->experience }} an{{ $offre->experience > 1 ? 's' : '' }}
                    @endif
                </div>
            </div>
            
            <div class="meta-item">
                <div class="meta-label">Postes à pourvoir</div>
                <div class="meta-value">{{ $offre->nombre_poste }}</div>
            </div>
            
            <div class="meta-item">
                <div class="meta-label">Date de publication</div>
                <div class="meta-value">{{ $offre->created_at->format('d/m/Y') }}</div>
            </div>
            
            @if($offre->date_expiration)
                <div class="meta-item">
                    <div class="meta-label">Date d'expiration</div>
                    <div class="meta-value">{{ \Carbon\Carbon::parse($offre->date_expiration)->format('d/m/Y') }}</div>
                </div>
            @endif
        </div>
    </div>
    
    <div class="section">
        <h2 class="section-title">Description du poste</h2>
        <div class="description">{{ $offre->description }}</div>
    </div>
    
    <div class="section">
        <h2 class="section-title">Compétences requises</h2>
        <div class="skills-container">
            @foreach($offre->skills as $skill)
                <div class="skill-tag">{{ $skill->name }}</div>
            @endforeach
        </div>
    </div>
    
    @if(count($offre->languages) > 0)
        <div class="section">
            <h2 class="section-title">Langues requises</h2>
            <div class="languages-container">
                @foreach($offre->languages as $language)
                    <div class="language-tag">
                        {{ $language->name }}
                        <span class="language-level">({{ ucfirst($language->pivot->level) }})</span>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    
    <div class="section applications-section">
        <div class="applications-header">
            <h2 class="section-title">Candidatures</h2>
            <div class="applications-count">0 candidature(s)</div>
        </div>
        
        @if(count($offre->applications) > 0)
            <table class="applications-table">
                <thead>
                    <tr>
                        <th>Candidat</th>
                        <th>Date de candidature</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($offre->applications as $application)
                        <tr>
                            <td>
                                <div class="font-medium">{{ $application->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $application->user->email }}</div>
                            </td>
                            <td>{{ $application->created_at->format('d/m/Y') }}</td>
                            <td>
                                @if($application->status == 'pending')
                                    <span class="status-badge status-pending">En attente</span>
                                @elseif($application->status == 'reviewed')
                                    <span class="status-badge status-published">Examinée</span>
                                @elseif($application->status == 'rejected')
                                    <span class="status-badge status-closed">Rejetée</span>
                                @elseif($application->status == 'shortlisted')
                                    <span class="status-badge status-published">Présélectionnée</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('applications.show', $application->id) }}" class="btn-secondary">
                                    <i class="fas fa-eye mr-1"></i> Voir
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="empty-applications">
                <p>Aucune candidature pour cette offre pour le moment.</p>
                @if($offre->statut == 'brouillon')
                    <p>L'offre n'est pas encore publiée.</p>
                @endif
            </div>
        @endif
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div id="delete-modal" class="delete-modal hidden">
    <div class="modal-content">
        <h3 class="modal-title">Confirmer la suppression</h3>
        <div class="modal-body">
            <p>Êtes-vous sûr de vouloir supprimer cette offre d'emploi ? Cette action est irréversible.</p>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn-secondary" id="cancel-delete">Annuler</button>
            <form method="POST" action="{{ route('offers.destroy', $offre->id) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger">Supprimer</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Gestion du modal de suppression
        const deleteButton = document.getElementById('delete-button');
        const deleteModal = document.getElementById('delete-modal');
        const cancelDelete = document.getElementById('cancel-delete');
        
        deleteButton.addEventListener('click', function() {
            deleteModal.classList.remove('hidden');
        });
        
        cancelDelete.addEventListener('click', function() {
            deleteModal.classList.add('hidden');
        });
        
        // Fermer le modal en cliquant en dehors
        deleteModal.addEventListener('click', function(e) {
            if (e.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });
        
        // Gestion du bouton de publication
        const publishButton = document.getElementById('publish-button');
        if (publishButton) {
            publishButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (confirm('Êtes-vous sûr de vouloir publier cette offre ?')) {
                    window.location.href = '{{ route("offers.publish", $offre->id) }}';
                }
            });
        }
        
        // Gestion du bouton de fermeture
        const closeButton = document.getElementById('close-button');
        if (closeButton) {
            closeButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (confirm('Êtes-vous sûr de vouloir fermer cette offre ? Elle ne sera plus visible par les candidats.')) {
                    window.location.href = '{{ route("offers.close", $offre->id) }}';
                }
            });
        }
    });
</script>
@endsection

"
voici le fichier views/recruter/preference.blade.php : 
"@extends('layouts.recruteur')

@section('title', 'Préférences de matching')

@section('styles')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .back-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: all 0.2s;
    }
    
    .back-button:hover {
        background-color: #e5e7eb;
    }
    
    .card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .job-info {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .job-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 3rem;
        height: 3rem;
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        margin-right: 1rem;
        color: #4b5563;
    }
    
    .job-details h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.25rem;
    }
    
    .job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        color: #6b7280;
        font-size: 0.875rem;
    }
    
    .job-meta-item {
        display: flex;
        align-items: center;
    }
    
    .job-meta-item i {
        margin-right: 0.375rem;
    }
    
    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
    }
    
    .section-description {
        color: #6b7280;
        margin-bottom: 1.5rem;
    }
    
    .toggle-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background-color: #f9fafb;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
    
    .toggle-label {
        font-weight: 500;
        color: #374151;
    }
    
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 3.5rem;
        height: 2rem;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e5e7eb;
        transition: .4s;
        border-radius: 2rem;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 1.5rem;
        width: 1.5rem;
        left: 0.25rem;
        bottom: 0.25rem;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .toggle-slider {
        background-color: #2563eb;
    }
    
    input:checked + .toggle-slider:before {
        transform: translateX(1.5rem);
    }
    
    .weights-container {
        margin-bottom: 2rem;
    }
    
    .weight-item {
        margin-bottom: 1.5rem;
    }
    
    .weight-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .weight-label {
        font-weight: 500;
        color: #374151;
    }
    
    .weight-value {
        font-weight: 600;
        color: #2563eb;
    }
    
    .weight-slider {
        -webkit-appearance: none;
        width: 100%;
        height: 0.5rem;
        border-radius: 0.25rem;
        background: #e5e7eb;
        outline: none;
    }
    
    .weight-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        background: #2563eb;
        cursor: pointer;
    }
    
    .weight-slider::-moz-range-thumb {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        background: #2563eb;
        cursor: pointer;
    }
    
    .weight-description {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .total-weight {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background-color: #f9fafb;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
    
    .total-weight-label {
        font-weight: 500;
        color: #374151;
    }
    
    .total-weight-value {
        font-weight: 600;
        font-size: 1.125rem;
    }
    
    .total-weight-value.valid {
        color: #059669;
    }
    
    .total-weight-value.invalid {
        color: #dc2626;
    }
    
    .buttons-container {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-primary {
        background-color: #2563eb;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #1d4ed8;
    }
    
    .btn-secondary {
        background-color: #f3f4f6;
        color: #4b5563;
    }
    
    .btn-secondary:hover {
        background-color: #e5e7eb;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-warning {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .hidden {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto py-6 px-4">
    <!-- Header -->
    <div class="header-container">
        <h1 class="text-2xl font-bold text-gray-900">Préférences de matching</h1>
        <a href="{{ route('offers.index') }}" class="back-button">
            <i class="fas fa-times"></i>
        </a>
    </div>
    
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif
    
    <div class="card">
        <!-- Job Information -->
        <div class="job-info">
            <div class="job-icon">
                <i class="fas fa-briefcase fa-lg"></i>
            </div>
            <div class="job-details">
                <h3>{{ $offre->title }}</h3>
                <div class="job-meta">
                    <div class="job-meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $offre->location }}</span>
                    </div>
                    <div class="job-meta-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ $offre->type_contrat }}</span>
                    </div>
                    <div class="job-meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Publié le {{ $offre->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <h2 class="section-title">Paramètres de matching des candidats</h2>
        <p class="section-description">
            Personnalisez la façon dont nous trouvons les meilleurs candidats pour votre offre d'emploi.
            Vous pouvez utiliser notre IA pour un matching automatique ou définir vos propres critères de priorité.
        </p>
        
        <form action="{{ route('preference.store', $offre->id) }}" method="POST" id="preferences-form">
            @csrf
            
            <!-- AI Toggle -->
            <div class="toggle-container">
                <div class="toggle-label">Utiliser l'IA pour le matching des candidats</div>
                <label class="toggle-switch">
                    <input type="checkbox" name="use_ai" id="use-ai-toggle" {{ $preference && $preference->use_ai ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            
            <!-- Weights Section -->
            <div id="weights-section" class="{{ $preference && $preference->use_ai ? 'hidden' : '' }}">
                <h3 class="section-title">Personnaliser les poids de matching</h3>
                <p class="section-description">
                    Ajustez l'importance de chaque critère pour trouver les candidats qui correspondent le mieux à vos besoins.
                    La somme des pourcentages doit être égale à 100%.
                </p>
                
                <div class="weights-container">
                    <!-- Skills Weight -->
                    <div class="weight-item">
                        <div class="weight-header">
                            <div class="weight-label">Compétences</div>
                            <div class="weight-value" id="skills-value">{{ $preference ? ($preference->skills_weight * 100) : 40 }}%</div>
                        </div>
                        <input type="range" min="0" max="100" step="5" class="weight-slider" id="skills-slider" 
                               name="skills_weight" value="{{ $preference ? ($preference->skills_weight * 100) : 40 }}">
                        <div class="weight-description">
                            L'importance des compétences techniques et professionnelles du candidat.
                        </div>
                    </div>
                    
                    <!-- Languages Weight -->
                    <div class="weight-item">
                        <div class="weight-header">
                            <div class="weight-label">Langues</div>
                            <div class="weight-value" id="languages-value">{{ $preference ? ($preference->languages_weight * 100) : 20 }}%</div>
                        </div>
                        <input type="range" min="0" max="100" step="5" class="weight-slider" id="languages-slider" 
                               name="languages_weight" value="{{ $preference ? ($preference->languages_weight * 100) : 20 }}">
                        <div class="weight-description">
                            L'importance des compétences linguistiques du candidat.
                        </div>
                    </div>
                    
                    <!-- Experience Weight -->
                    <div class="weight-item">
                        <div class="weight-header">
                            <div class="weight-label">Expérience</div>
                            <div class="weight-value" id="experience-value">{{ $preference ? ($preference->experience_weight * 100) : 25 }}%</div>
                        </div>
                        <input type="range" min="0" max="100" step="5" class="weight-slider" id="experience-slider" 
                               name="experience_weight" value="{{ $preference ? ($preference->experience_weight * 100) : 25 }}">
                        <div class="weight-description">
                            L'importance de l'expérience professionnelle du candidat.
                        </div>
                    </div>
                    
                    <!-- Location Weight -->
                    <div class="weight-item">
                        <div class="weight-header">
                            <div class="weight-label">Localisation</div>
                            <div class="weight-value" id="location-value">{{ $preference ? ($preference->location_weight * 100) : 15 }}%</div>
                        </div>
                        <input type="range" min="0" max="100" step="5" class="weight-slider" id="location-slider" 
                               name="location_weight" value="{{ $preference ? ($preference->location_weight * 100) : 15 }}">
                        <div class="weight-description">
                            L'importance de la proximité géographique du candidat.
                        </div>
                    </div>
                </div>
                
                <!-- Total Weight -->
                <div class="total-weight">
                    <div class="total-weight-label">Total</div>
                    <div class="total-weight-value" id="total-weight-value">100%</div>
                </div>
                
                <div class="alert alert-warning hidden" id="total-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Le total des poids doit être égal à 100%.
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="buttons-container">
                <a href="{{ route('offers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary" id="save-button">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer les préférences
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments DOM
        const useAiToggle = document.getElementById('use-ai-toggle');
        const weightsSection = document.getElementById('weights-section');
        const sliders = document.querySelectorAll('.weight-slider');
        const totalWeightValue = document.getElementById('total-weight-value');
        const totalWarning = document.getElementById('total-warning');
        const saveButton = document.getElementById('save-button');
        const form = document.getElementById('preferences-form');
        
        // Afficher/masquer la section des poids selon l'état de l'IA
        useAiToggle.addEventListener('change', function() {
            weightsSection.classList.toggle('hidden', this.checked);
            
            // Si l'IA est activée, on peut toujours enregistrer
            if (this.checked) {
                saveButton.disabled = false;
                totalWarning.classList.add('hidden');
            } else {
                // Sinon, on vérifie si la somme est égale à 100%
                checkTotal();
            }
        });
        
        // Mettre à jour les valeurs affichées quand les sliders changent
        sliders.forEach(slider => {
            const valueDisplay = document.getElementById(slider.id.replace('-slider', '-value'));
            
            slider.addEventListener('input', function() {
                valueDisplay.textContent = this.value + '%';
                checkTotal();
            });
        });
        
        // Vérifier si la somme est égale à 100%
        function checkTotal() {
            let total = 0;
            sliders.forEach(slider => {
                total += parseInt(slider.value);
            });
            
            totalWeightValue.textContent = total + '%';
            
            // Vérifier si le total est égal à 100%
            const isValid = total === 100;
            
            // Mettre à jour les classes CSS
            totalWeightValue.classList.toggle('valid', isValid);
            totalWeightValue.classList.toggle('invalid', !isValid);
            totalWarning.classList.toggle('hidden', isValid);
            
            // Activer/désactiver le bouton d'enregistrement
            saveButton.disabled = !isValid && !useAiToggle.checked;
        }
        
        // Vérifier avant la soumission du formulaire
        form.addEventListener('submit', function(e) {
            if (!useAiToggle.checked) {
                let total = 0;
                sliders.forEach(slider => {
                    total += parseInt(slider.value);
                });
                
                if (total !== 100) {
                    e.preventDefault();
                    totalWarning.classList.remove('hidden');
                    totalWarning.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        // Vérification initiale
        checkTotal();
    });
</script>
@endsection
"
voici le fichier views/recruter/profilrecruteur.blade.php : 
"@extends('layouts.recruteur')

@section('title', 'Profil Recruteur')

@section('header-title')
<div class="flex items-center">
    <a href="#" class="mr-4 text-gray-600 hover:text-gray-900">
        <i class="fas fa-arrow-left"></i>
    </a>
    <span>Profil Recruteur</span>
</div>
@endsection

@section('styles')
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
        padding: 1rem 0;
    }
    
    .profile-section {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .section-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .section-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
    }
    
    .edit-button {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0.5rem;
        border-radius: 0.375rem;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: all 0.2s;
    }
    
    .edit-button:hover {
        background-color: #e5e7eb;
        color: #1f2937;
    }
    
    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .profile-avatar {
        width: 80px;
        height: 80px;
        border-radius: 0.5rem;
        background-color: #4f46e5;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        margin-right: 1.5rem;
    }
    
    .profile-info h2 {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.25rem;
    }
    
    .profile-info .email {
        color: #6b7280;
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1.5rem;
    }
    
    .info-item {
        margin-bottom: 1rem;
    }
    
    .info-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 0.25rem;
    }
    
    .info-value {
        color: #1f2937;
    }
    
    .company-description {
        margin-top: 1.5rem;
    }
    
    .description-label {
        font-size: 0.875rem;
        font-weight: 500;
        color: #6b7280;
        margin-bottom: 0.5rem;
    }
    
    .description-text {
        color: #1f2937;
        line-height: 1.5;
    }
</style>
@endsection

@section('content')
<div class="profile-container">
    <!-- Informations personnelles -->
    <div class="profile-section">
        <div class="section-header">
            <h2 class="section-title">Informations personnelles</h2>
        </div>
        
        <div class="profile-header">
            <div class="profile-avatar">
                {{ substr($user->name ?? 'R', 0, 1) }}
            </div>
            <div class="profile-info">
                <h2>{{ $user->name ?? 'Nom du recruteur' }}</h2>
                <div class="email">{{ $user->email ?? 'email@example.com' }}</div>
            </div>
        </div>
    </div>
    
    <!-- Informations de l'entreprise -->
    <div class="profile-section">
        <div class="section-header">
            <h2 class="section-title">Informations de l'entreprise</h2>
            <a href="{{ route('company.edit', $company->id) }}" class="edit-button">
                <i class="fas fa-pencil-alt"></i>
            </a>
        </div>
        
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">Nom de l'entreprise</div>
                <div class="info-value">{{ $company->name ?? 'Non spécifié' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Secteur d'activité</div>
                <div class="info-value">{{ $company->sector ?? 'Non spécifié' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Taille de l'entreprise</div>
                <div class="info-value">{{ $company->size ?? 'Non spécifié' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Site web</div>
                <div class="info-value">
                    @if(isset($company->website))
                        <a href="{{ $company->website }}" target="_blank" class="text-indigo-600 hover:text-indigo-800">
                            {{ $company->website }}
                        </a>
                    @else
                        Non spécifié
                    @endif
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Pays</div>
                <div class="info-value">{{ $company->pays ?? 'Non spécifié' }}</div>
            </div>
            
            <div class="info-item">
                <div class="info-label">Ville</div>
                <div class="info-value">{{ $company->ville ?? 'Non spécifié' }}</div>
            </div>
        </div>
        
        <div class="company-description">
            <div class="description-label">Description de l'entreprise</div>
            <div class="description-text">
                @if(isset($company->description) && !empty($company->description))
                    {{ $company->description }}
                @else
                    Aucune description disponible. Ajoutez une description pour présenter votre entreprise aux candidats.
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

"