@extends('layouts.candidat')

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
    
    .add-language-container {
        margin-top: 1.5rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
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
    
    <form action="{{ route('resumes.languages.store', $resume->id) }}" method="POST">
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
            
            @if(count($languages) > 0)
                <div id="languages-list">
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
            @else
                <div class="text-center py-6 text-gray-500 bg-white rounded-lg shadow-sm border border-gray-200">
                    <p>Aucune langue disponible. Vous pouvez en ajouter une nouvelle ci-dessous.</p>
                </div>
            @endif
            
            <div class="add-language-container">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Ajouter une nouvelle langue</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group">
                        <label for="new_language_name" class="form-label">Nom de la langue</label>
                        <input type="text" id="new_language_name" name="new_language_name" class="form-input" value="{{ old('new_language_name') }}" placeholder="Ex: Espagnol, Allemand, Arabe...">
                    </div>
                    
                    <div class="form-group">
                        <label for="new_language_level" class="form-label">Niveau</label>
                        <select id="new_language_level" name="new_language_level" class="form-select">
                            <option value="débutant" {{ old('new_language_level') == 'débutant' ? 'selected' : '' }}>Débutant</option>
                            <option value="intermédiaire" {{ old('new_language_level') == 'intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                            <option value="avancé" {{ old('new_language_level') == 'avancé' ? 'selected' : '' }}>Avancé</option>
                            <option value="courant" {{ old('new_language_level', 'courant') == 'courant' ? 'selected' : '' }}>Courant</option>
                            <option value="natif" {{ old('new_language_level') == 'natif' ? 'selected' : '' }}>Langue maternelle</option>
                        </select>
                    </div>
                </div>
                
                <p class="form-help-text">Si la langue que vous souhaitez ajouter n'est pas dans la liste, vous pouvez l'ajouter ici.</p>
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
        const selectedLanguagesContainer = document.getElementById('selected-languages-container');
        const selectedLanguagesList = document.getElementById('selected-languages-list');
        
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
            const items = languagesList.querySelectorAll('.language-item');
            
            items.forEach(item => {
                const languageName = item.querySelector('.language-name').textContent.toLowerCase();
                if (languageName.includes(query.toLowerCase())) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
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
            searchLanguages(this.value);
        });
        
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
