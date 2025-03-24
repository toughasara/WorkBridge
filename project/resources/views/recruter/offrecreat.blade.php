@extends('layouts.recruteur')

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
                    <option value="brouillon" {{ old('statut') == 'brouillon' ? 'selected' : '' }}>Brouillon</option>
                    <option value="publiée" {{ old('statut') == 'publiée' ? 'selected' : '' }}>Publiée</option>
                </select>
                <p class="form-help-text">Les offres en brouillon ne sont pas visibles par les candidats.</p>
                @error('statut')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 mb-6">
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
        const statutSelect = document.getElementById('statut');
        
        // Mettre à jour le statut en fonction du bouton cliqué
        publishButton.addEventListener('click', function() {
            statutSelect.value = 'publiée';
        });
        
        draftButton.addEventListener('click', function() {
            statutSelect.value = 'brouillon';
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
            
            if (!isValid) {
                event.preventDefault();
                window.scrollTo(0, 0);
                
                // Afficher un message d'erreur
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
    });
</script>
@endsection

