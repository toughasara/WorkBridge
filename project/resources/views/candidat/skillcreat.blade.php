@extends('layouts.candidat')

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
                @foreach($skills->take(6) as $skill)
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
                
        // Mettre à jour l'affichage initial
        updateSelectedSkillsDisplay();
    });
</script>
@endsection

