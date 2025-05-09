@extends('layouts.recruteur')

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
</div>

@endsection