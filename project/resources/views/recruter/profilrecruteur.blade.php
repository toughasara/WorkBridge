@extends('layouts.recruteur')

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

