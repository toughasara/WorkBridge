@extends('layouts.recruteur')

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

