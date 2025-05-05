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
    
    <form action="{{ route('resumes.language.store', $resume->id) }}" method="POST" id="languages-form">
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
            
            <!-- Conteneur pour les langues -->
            <div id="languages-list" class="space-y-4">
                <!-- Les langues seront ajoutées ici par JavaScript -->
            </div>
            
            <!-- Conteneur pour les champs cachés des langues sélectionnées -->
            <div id="hidden-languages-fields">
                <!-- Les champs cachés seront ajoutés ici par JavaScript -->
            </div>
            
            <div id="no-results" class="no-results" style="display: none;">
                <p>Aucune langue trouvée correspondant à votre recherche.</p>
            </div>
            
            <div id="selected-languages-container" class="selected-languages" style="{{ count($selectedLanguages) > 0 ? '' : 'display: none;' }}">
                <div class="selected-languages-title">Langues sélectionnées</div>
                <div id="selected-languages-list" class="flex flex-wrap">
                    <!-- Les tags des langues sélectionnées seront ajoutés ici par JavaScript -->
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
        const hiddenLanguagesFields = document.getElementById('hidden-languages-fields');
        const form = document.getElementById('languages-form');
        
        // Toutes les langues disponibles
        const allLanguages = @json($languages);
        
        // Langues déjà sélectionnées avec leurs niveaux
        const selectedLanguagesData = @json($selectedLanguages);
        
        // Map pour stocker les langues sélectionnées et leurs niveaux
        const selectedLanguages = new Map();
        
        // Initialiser les langues déjà sélectionnées
        selectedLanguagesData.forEach(language => {
            selectedLanguages.set(language.id.toString(), {
                id: language.id.toString(),
                name: language.name,
                level: language.pivot.level
            });
        });
        
        // Fonction pour mettre à jour l'affichage des langues sélectionnées
        function updateSelectedLanguagesDisplay() {
            if (selectedLanguages.size > 0) {
                selectedLanguagesContainer.style.display = '';
            } else {
                selectedLanguagesContainer.style.display = 'none';
            }
        }
        
        // Fonction pour mettre à jour les champs cachés
        function updateHiddenFields() {
            hiddenLanguagesFields.innerHTML = '';
            
            selectedLanguages.forEach((language, id) => {
                const selectedField = document.createElement('input');
                selectedField.type = 'hidden';
                selectedField.name = `languages[${id}][selected]`;
                selectedField.value = '1';
                
                const levelField = document.createElement('input');
                levelField.type = 'hidden';
                levelField.name = `languages[${id}][level]`;
                levelField.value = language.level;
                
                hiddenLanguagesFields.appendChild(selectedField);
                hiddenLanguagesFields.appendChild(levelField);
            });
        }
        
        // Fonction pour rendre les langues initiales
        function renderInitialLanguages() {
            // Récupérer toutes les langues sélectionnées
            const selectedLanguagesArray = Array.from(selectedLanguages.values());
            
            // Si des langues sont sélectionnées
            if (selectedLanguagesArray.length > 0) {
                // Afficher toutes les langues sélectionnées
                const languagesToRender = [...selectedLanguagesArray];
                
                // Si moins de 5 langues sont sélectionnées, ajouter d'autres langues non sélectionnées
                if (selectedLanguagesArray.length < 5) {
                    const nonSelectedLanguages = allLanguages.filter(language => 
                        !selectedLanguages.has(language.id.toString())
                    );
                    
                    // Ajouter des langues non sélectionnées jusqu'à avoir 5 langues au total
                    const remainingCount = 5 - selectedLanguagesArray.length;
                    languagesToRender.push(...nonSelectedLanguages.slice(0, remainingCount));
                }
                
                renderLanguages(languagesToRender);
            } else {
                // Si aucune langue n'est sélectionnée, afficher les 5 premières langues
                renderLanguages(allLanguages.slice(0, 5));
            }
            
            // Mettre à jour les champs cachés
            updateHiddenFields();
            
            // Mettre à jour l'affichage des langues sélectionnées
            updateSelectedLanguagesDisplay();
            
            // Rendre les tags des langues sélectionnées
            renderSelectedLanguageTags();
        }
        
        // Fonction pour rechercher des langues
        function searchLanguages(query) {
            const searchTerm = query.toLowerCase().trim();
            
            noResultsElement.style.display = 'none';
            
            // Si la recherche est vide, afficher les langues initiales
            if (searchTerm === '') {
                renderInitialLanguages();
                return;
            }
            
            // Filtrer les langues
            const filteredLanguages = allLanguages.filter(language => 
                language.name.toLowerCase().includes(searchTerm)
            );
            
            // Afficher le résultat
            if (filteredLanguages.length === 0) {
                noResultsElement.style.display = 'block';
                languagesList.innerHTML = '';
            } else {
                // Trier les langues pour que les sélectionnées apparaissent en premier
                const sortedLanguages = [...filteredLanguages].sort((a, b) => {
                    const aSelected = selectedLanguages.has(a.id.toString());
                    const bSelected = selectedLanguages.has(b.id.toString());
                    
                    if (aSelected && !bSelected) return -1;
                    if (!aSelected && bSelected) return 1;
                    return 0;
                });
                
                renderLanguages(sortedLanguages);
            }
        }
        
        // Fonction pour rendre les langues
        function renderLanguages(languagesToRender) {
            languagesList.innerHTML = '';
            
            languagesToRender.forEach(language => {
                const languageId = language.id.toString();
                const isSelected = selectedLanguages.has(languageId);
                const languageData = isSelected ? selectedLanguages.get(languageId) : { level: 'débutant' };
                
                const languageItem = document.createElement('div');
                languageItem.className = `language-item ${isSelected ? 'selected' : ''}`;
                languageItem.id = `language-item-${languageId}`;
                
                languageItem.innerHTML = `
                    <input type="checkbox" id="language-${languageId}" 
                        name="languages[${languageId}][selected]" value="1" 
                        class="language-checkbox" ${isSelected ? 'checked' : ''}>
                    <div class="language-info">
                        <div class="language-name">${language.name}</div>
                    </div>
                    <div class="language-level-select">
                        <select name="languages[${languageId}][level]" class="form-select" 
                                ${isSelected ? '' : 'disabled'} data-language-id="${languageId}">
                            <option value="débutant" ${languageData.level === 'débutant' ? 'selected' : ''}>Débutant</option>
                            <option value="intermédiaire" ${languageData.level === 'intermédiaire' ? 'selected' : ''}>Intermédiaire</option>
                            <option value="avancé" ${languageData.level === 'avancé' ? 'selected' : ''}>Avancé</option>
                            <option value="courant" ${languageData.level === 'courant' ? 'selected' : ''}>Courant</option>
                            <option value="natif" ${languageData.level === 'natif' ? 'selected' : ''}>Langue maternelle</option>
                        </select>
                    </div>
                `;
                
                languagesList.appendChild(languageItem);
                
                // Gestion des événements
                const checkbox = languageItem.querySelector('.language-checkbox');
                const select = languageItem.querySelector('select');
                
                // Événement de changement de case à cocher
                checkbox.addEventListener('change', function() {
                    if (this.checked) {
                        // Ajouter la langue à la liste des sélectionnées
                        selectedLanguages.set(languageId, {
                            id: languageId,
                            name: language.name,
                            level: select.value
                        });
                        
                        // Activer le sélecteur de niveau
                        select.disabled = false;
                        
                        // Ajouter la classe selected
                        languageItem.classList.add('selected');
                        
                        // Ajouter le tag de langue sélectionnée
                        addLanguageTag(languageId, language.name, select.value);
                    } else {
                        // Supprimer la langue de la liste des sélectionnées
                        selectedLanguages.delete(languageId);
                        
                        // Désactiver le sélecteur de niveau
                        select.disabled = true;
                        
                        // Supprimer la classe selected
                        languageItem.classList.remove('selected');
                        
                        // Supprimer le tag de langue
                        removeLanguageTag(languageId);
                    }
                    
                    // Mettre à jour les champs cachés
                    updateHiddenFields();
                    
                    // Mettre à jour l'affichage des langues sélectionnées
                    updateSelectedLanguagesDisplay();
                });
                
                // Événement de changement de niveau
                select.addEventListener('change', function() {
                    if (selectedLanguages.has(languageId)) {
                        // Mettre à jour le niveau de la langue
                        const languageData = selectedLanguages.get(languageId);
                        languageData.level = this.value;
                        selectedLanguages.set(languageId, languageData);
                        
                        // Mettre à jour le badge de niveau dans le tag
                        const levelBadge = document.querySelector(`.selected-language-tag[data-language-id="${languageId}"] .language-level-badge`);
                        if (levelBadge) {
                            levelBadge.textContent = this.value;
                        }
                        
                        // Mettre à jour les champs cachés
                        updateHiddenFields();
                    }
                });
                
                // Événement de clic sur l'élément de langue
                languageItem.addEventListener('click', function(e) {
                    // Ne pas déclencher si on clique sur la case à cocher ou le sélecteur
                    if (!e.target.classList.contains('language-checkbox') && !e.target.classList.contains('form-select')) {
                        checkbox.checked = !checkbox.checked;
                        
                        // Déclencher l'événement change manuellement
                        const event = new Event('change');
                        checkbox.dispatchEvent(event);
                    }
                });
            });
        }
        
        // Fonction pour ajouter un tag de langue sélectionnée
        function addLanguageTag(languageId, languageName, level) {
            // Vérifier si le tag existe déjà
            const existingTag = document.querySelector(`.selected-language-tag[data-language-id="${languageId}"]`);
            if (existingTag) {
                return;
            }
            
            const languageTag = document.createElement('div');
            languageTag.className = 'selected-language-tag';
            languageTag.dataset.languageId = languageId;
            languageTag.innerHTML = `
                ${languageName}
                <span class="language-level-badge">${level}</span>
                <span class="remove-language" data-language-id="${languageId}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </span>
            `;
            
            selectedLanguagesList.appendChild(languageTag);
            
            // Ajouter l'événement de suppression
            languageTag.querySelector('.remove-language').addEventListener('click', function() {
                const languageId = this.dataset.languageId;
                
                // Supprimer la langue de la liste des sélectionnées
                selectedLanguages.delete(languageId);
                
                // Décocher la case à cocher correspondante
                const checkbox = document.getElementById(`language-${languageId}`);
                if (checkbox) {
                    checkbox.checked = false;
                    
                    // Désactiver le sélecteur de niveau
                    const select = checkbox.closest('.language-item').querySelector('select');
                    select.disabled = true;
                    
                    // Supprimer la classe selected
                    checkbox.closest('.language-item').classList.remove('selected');
                }
                
                // Supprimer le tag
                this.closest('.selected-language-tag').remove();
                
                // Mettre à jour les champs cachés
                updateHiddenFields();
                
                // Mettre à jour l'affichage des langues sélectionnées
                updateSelectedLanguagesDisplay();
                
                // Rafraîchir la liste des langues pour maintenir la règle des 5 langues
                if (searchInput.value.trim() === '') {
                    renderInitialLanguages();
                }
            });
        }
        
        // Fonction pour supprimer un tag de langue
        function removeLanguageTag(languageId) {
            const languageTag = document.querySelector(`.selected-language-tag[data-language-id="${languageId}"]`);
            if (languageTag) {
                languageTag.remove();
            }
        }
        
        // Fonction pour rendre les tags des langues sélectionnées
        function renderSelectedLanguageTags() {
            selectedLanguagesList.innerHTML = '';
            
            selectedLanguages.forEach((language, id) => {
                addLanguageTag(id, language.name, language.level);
            });
        }
        
        // Ajouter les écouteurs d'événements
        searchInput.addEventListener('input', function() {
            searchLanguages(this.value.trim());
        });
        
        // Ajouter l'écouteur d'événement pour la soumission du formulaire
        form.addEventListener('submit', function() {
            // Mettre à jour les champs cachés avant la soumission
            updateHiddenFields();
        });
        
        // Initialiser l'affichage
        renderInitialLanguages();
    });
</script>
@endsection
