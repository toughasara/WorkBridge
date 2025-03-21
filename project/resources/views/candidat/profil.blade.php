@extends('layouts.candidat')

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
        <h2 class="section-title">CV</h2>
        
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
                    <label for="replace-cv" class="cv-file-menu-item">
                        <i class="fas fa-sync-alt"></i>
                        <span>Remplacer le fichier</span>
                    </label>
                    <a href="{{ route('candidate.cv.delete', $cv->id) }}" class="cv-file-menu-item text-danger">
                        <i class="fas fa-trash-alt"></i>
                        <span>Supprimer</span>
                    </a>
                </div>
            </div>
        </div>
        <form action="{{ route('candidate.cv.update', $cv->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input type="file" name="cv_file" id="replace-cv" class="file-input" accept=".pdf" onchange="this.form.submit()">
        </form>
        @else
        <div class="cv-actions">
            <form action="{{ route('candidate.cv.store') }}" method="POST" enctype="multipart/form-data">
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
        <h2 class="section-title">CV WorkBridge</h2>
        
        <div class="cv-actions">
            @if(isset($resume))
            <a href="{{ route('candidate.resume.view') }}" class="btn-primary flex items-center justify-center">
                <i class="fas fa-eye mr-2"></i>
                WorkBridge CV
            </a>
            @else
            <a href="{{ route('candidate.resume.create') }}" class="btn-primary flex items-center justify-center">
                <i class="fas fa-plus mr-2"></i>
                Créer WorkBridge CV
            </a>
            @endif
        </div>
    </div>

    <!-- Autres sections du profil -->
    <div class="bg-white rounded-lg shadow-sm p-6">
        <h2 class="section-title">Qualifications</h2>
        <p class="text-gray-500 mb-4">
            Mettez vos compétences et votre expérience en avant.
        </p>
        <a href="{{ route('candidate.qualifications') }}" class="btn-outline flex items-center justify-center w-full">
            <i class="fas fa-plus mr-2"></i>
            Ajouter des qualifications
        </a>
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