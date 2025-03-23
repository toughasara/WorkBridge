@extends('layouts.candidat')

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

