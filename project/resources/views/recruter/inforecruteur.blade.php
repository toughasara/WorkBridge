@extends('layouts.auth')

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

        <form method="POST" action="{{ route('recruiter.info.store') }}" id="recruiter-form" class="space-y-6">
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

