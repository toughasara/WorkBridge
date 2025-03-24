@extends('layouts.recruteur')

@section('title', 'Modifier les informations de l\'entreprise')

@section('header-title', 'Modifier les informations de l\'entreprise')

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

    <form method="POST" action="{{ route('company.update', $company->id) }}" id="company-form">
        @csrf
        @method('PUT')
        
        <div class="form-section">
            <h2 class="section-title">Informations générales</h2>
            
            <!-- Nom de l'entreprise -->
            <div class="form-group">
                <label for="name" class="form-label">Nom de l'entreprise</label>
                <input id="name" name="name" type="text" required value="{{ old('name', $company->name) }}"
                    class="form-input @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Pays et Ville (sur la même ligne) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="country" class="form-label">Pays</label>
                    <div class="input-with-icon">
                        <input id="country" name="pays" type="text" required value="{{ old('pays', $company->pays) }}"
                            class="form-input @error('pays') border-red-500 @enderror"
                            placeholder="Sélectionner un pays...">
                        <span class="clear-btn" id="clear-country">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="country-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="country-results"></div>
                    <input type="hidden" id="country-code" name="country_code" value="{{ old('country_code') }}">
                    @error('pays')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="city" class="form-label">Ville</label>
                    <div class="input-with-icon">
                        <input id="city" name="ville" type="text" required value="{{ old('ville', $company->ville) }}"
                            class="form-input @error('ville') border-red-500 @enderror"
                            placeholder="Sélectionner une ville...">
                        <span class="clear-btn" id="clear-city">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="city-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="city-results"></div>
                    <input type="hidden" id="city-id" name="city_id" value="{{ old('city_id') }}">
                    @error('ville')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        
        <div class="form-section">
            <h2 class="section-title">Détails de l'entreprise</h2>
            
            <!-- Secteur et Taille (sur la même ligne) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="form-group">
                    <label for="sector" class="form-label">Secteur d'activité</label>
                    <div class="input-with-icon">
                        <input id="sector" name="sector" type="text" required value="{{ old('sector', $company->sector) }}"
                            class="form-input @error('sector') border-red-500 @enderror"
                            placeholder="Sélectionner un secteur...">
                        <span class="clear-btn" id="clear-sector">
                            <i class="fas fa-times"></i>
                        </span>
                        <div class="spinner" id="sector-spinner"></div>
                    </div>
                    <div class="autocomplete-results" id="sector-results"></div>
                    <input type="hidden" id="sector-code" name="sector_code" value="{{ old('sector_code') }}">
                    @error('sector')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="size" class="form-label">Taille de l'entreprise</label>
                    <select id="size" name="size" required class="form-select @error('size') border-red-500 @enderror">
                        <option value="">Sélectionnez une taille</option>
                        <option value="1-10" {{ old('size', $company->size) == '1-10' ? 'selected' : '' }}>1-10 employés</option>
                        <option value="11-50" {{ old('size', $company->size) == '11-50' ? 'selected' : '' }}>11-50 employés</option>
                        <option value="51-200" {{ old('size', $company->size) == '51-200' ? 'selected' : '' }}>51-200 employés</option>
                        <option value="201-500" {{ old('size', $company->size) == '201-500' ? 'selected' : '' }}>201-500 employés</option>
                        <option value="501-1000" {{ old('size', $company->size) == '501-1000' ? 'selected' : '' }}>501-1000 employés</option>
                        <option value="1001+" {{ old('size', $company->size) == '1001+' ? 'selected' : '' }}>Plus de 1000 employés</option>
                    </select>
                    @error('size')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Site web -->
            <div class="form-group">
                <label for="website" class="form-label">Site web</label>
                <div class="flex rounded-md shadow-sm">
                    <span class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm">
                        https://
                    </span>
                    <input id="website" name="website_domain" type="text" 
                        value="{{ old('website_domain', str_replace('https://', '', $company->website ?? '')) }}"
                        class="form-input flex-1 rounded-none rounded-r-md @error('website') border-red-500 @enderror"
                        placeholder="www.votreentreprise.com">
                    <input type="hidden" id="website-full" name="website" 
                        value="{{ old('website', $company->website) }}">
                </div>
                @error('website')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">Description de l'entreprise</label>
                <textarea id="description" name="description" rows="4" 
                    class="form-textarea @error('description') border-red-500 @enderror"
                    placeholder="Décrivez brièvement votre entreprise, ses activités et sa culture...">{{ old('description', $company->description) }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
                <p class="form-help-text">Maximum 500 caractères</p>
                <p class="form-help-text" id="char-count">{{ old('description', $company->description) ? strlen(old('description', $company->description)) : '0' }}/500 caractères</p>
            </div>
        </div>
        
        <div class="flex justify-end space-x-4 mb-6">
            <a href="{{ route('recruiter.profile') }}" class="btn-secondary">
                Annuler
            </a>
            <button type="submit" class="btn-primary">
                Enregistrer les modifications
            </button>
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments du formulaire
        const form = document.getElementById('company-form');
        const nameField = document.getElementById('name');
        const countryField = document.getElementById('country');
        const countryCodeField = document.getElementById('country-code');
        const cityField = document.getElementById('city');
        const cityIdField = document.getElementById('city-id');
        const sectorField = document.getElementById('sector');
        const sectorCodeField = document.getElementById('sector-code');
        const sizeField = document.getElementById('size');
        const websiteField = document.getElementById('website');
        const websiteFullField = document.getElementById('website-full');
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
        
        // Liste des pays (exemple - à remplacer par votre propre source de données)
        const countries = [
            "Afghanistan", "Afrique du Sud", "Albanie", "Algérie", "Allemagne", "Andorre", "Angola", "Antigua-et-Barbuda", 
            "Arabie Saoudite", "Argentine", "Arménie", "Australie", "Autriche", "Azerbaïdjan", "Bahamas", "Bahreïn", 
            "Bangladesh", "Barbade", "Belgique", "Belize", "Bénin", "Bhoutan", "Biélorussie", "Birmanie", "Bolivie", 
            "Bosnie-Herzégovine", "Botswana", "Brésil", "Brunei", "Bulgarie", "Burkina Faso", "Burundi", "Cambodge", 
            "Cameroun", "Canada", "Cap-Vert", "Chili", "Chine", "Chypre", "Colombie", "Comores", "Congo", 
            "Corée du Nord", "Corée du Sud", "Costa Rica", "Côte d'Ivoire", "Croatie", "Cuba", "Danemark", "Djibouti", 
            "Dominique", "Égypte", "Émirats arabes unis", "Équateur", "Érythrée", "Espagne", "Estonie", "Eswatini", 
            "États-Unis", "Éthiopie", "Fidji", "Finlande", "France", "Gabon", "Gambie", "Géorgie", "Ghana", "Grèce", 
            "Grenade", "Guatemala", "Guinée", "Guinée équatoriale", "Guinée-Bissau", "Guyana", "Haïti", "Honduras", 
            "Hongrie", "Îles Marshall", "Îles Salomon", "Inde", "Indonésie", "Irak", "Iran", "Irlande", "Islande", 
            "Israël", "Italie", "Jamaïque", "Japon", "Jordanie", "Kazakhstan", "Kenya", "Kirghizistan", "Kiribati", 
            "Koweït", "Laos", "Lesotho", "Lettonie", "Liban", "Liberia", "Libye", "Liechtenstein", "Lituanie", 
            "Luxembourg", "Macédoine du Nord", "Madagascar", "Malaisie", "Malawi", "Maldives", "Mali", "Malte", 
            "Maroc", "Maurice", "Mauritanie", "Mexique", "Micronésie", "Moldavie", "Monaco", "Mongolie", "Monténégro", 
            "Mozambique", "Namibie", "Nauru", "Népal", "Nicaragua", "Niger", "Nigeria", "Niue", "Norvège", 
            "Nouvelle-Zélande", "Oman", "Ouganda", "Ouzbékistan", "Pakistan", "Palaos", "Palestine", "Panama", 
            "Papouasie-Nouvelle-Guinée", "Paraguay", "Pays-Bas", "Pérou", "Philippines", "Pologne", "Portugal", 
            "Qatar", "République centrafricaine", "République démocratique du Congo", "République dominicaine", 
            "République tchèque", "Roumanie", "Royaume-Uni", "Russie", "Rwanda", "Saint-Kitts-et-Nevis", "Saint-Marin", 
            "Saint-Vincent-et-les-Grenadines", "Sainte-Lucie", "Salvador", "Samoa", "São Tomé-et-Principe", "Sénégal", 
            "Serbie", "Seychelles", "Sierra Leone", "Singapour", "Slovaquie", "Slovénie", "Somalie", "Soudan", 
            "Soudan du Sud", "Sri Lanka", "Suède", "Suisse", "Suriname", "Syrie", "Tadjikistan", "Tanzanie", "Tchad", 
            "Thaïlande", "Timor oriental", "Togo", "Tonga", "Trinité-et-Tobago", "Tunisie", "Turkménistan", "Turquie", 
            "Tuvalu", "Ukraine", "Uruguay", "Vanuatu", "Vatican", "Venezuela", "Viêt Nam", "Yémen", "Zambie", "Zimbabwe"
        ];
        
        // Liste des secteurs d'activité (exemple)
        const sectors = [
            "Agriculture et agroalimentaire", "Banque et finance", "Commerce de détail", "Communication et médias",
            "Construction et immobilier", "Éducation et formation", "Énergie et environnement", "Hôtellerie et restauration",
            "Industrie manufacturière", "Informatique et technologie", "Santé et services sociaux", "Services aux entreprises",
            "Télécommunications", "Transport et logistique", "Tourisme et loisirs"
        ];
        
        // Fonction pour afficher les résultats d'autocomplétion des pays
        function showCountryResults(query) {
            countryResults.innerHTML = '';
            countryResults.style.display = 'none';
            
            if (!query) return;
            
            const filteredCountries = countries.filter(country => 
                country.toLowerCase().includes(query.toLowerCase())
            );
            
            if (filteredCountries.length === 0) return;
            
            filteredCountries.forEach(country => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = country;
                item.addEventListener('click', () => {
                    countryField.value = country;
                    countryCodeField.value = country;
                    countryResults.style.display = 'none';
                });
                countryResults.appendChild(item);
            });
            
            countryResults.style.display = 'block';
        }
        
        // Fonction pour afficher les résultats d'autocomplétion des secteurs
        function showSectorResults(query) {
            sectorResults.innerHTML = '';
            sectorResults.style.display = 'none';
            
            if (!query) return;
            
            const filteredSectors = sectors.filter(sector => 
                sector.toLowerCase().includes(query.toLowerCase())
            );
            
            if (filteredSectors.length === 0) return;
            
            filteredSectors.forEach(sector => {
                const item = document.createElement('div');
                item.className = 'autocomplete-item';
                item.textContent = sector;
                item.addEventListener('click', () => {
                    sectorField.value = sector;
                    sectorCodeField.value = sector;
                    sectorResults.style.display = 'none';
                });
                sectorResults.appendChild(item);
            });
            
            sectorResults.style.display = 'block';
        }
        
        // Fonction pour simuler les résultats d'autocomplétion des villes
        function showCityResults(country, query) {
            cityResults.innerHTML = '';
            cityResults.style.display = 'none';
            
            if (!query || !country) return;
            
            // Simuler un délai de chargement
            citySpinner.style.display = 'block';
            
            // Exemple de villes pour quelques pays (à remplacer par votre propre source de données)
            const citiesByCountry = {
                "France": ["Paris", "Marseille", "Lyon", "Toulouse", "Nice", "Nantes", "Strasbourg", "Montpellier", "Bordeaux", "Lille"],
                "Maroc": ["Casablanca", "Rabat", "Marrakech", "Fès", "Tanger", "Agadir", "Meknès", "Oujda", "Tétouan", "Kénitra"],
                "Canada": ["Toronto", "Montréal", "Vancouver", "Calgary", "Edmonton", "Ottawa", "Québec", "Winnipeg", "Hamilton", "Halifax"],
                "États-Unis": ["New York", "Los Angeles", "Chicago", "Houston", "Phoenix", "Philadelphie", "San Antonio", "San Diego", "Dallas", "San José"],
                "Royaume-Uni": ["Londres", "Birmingham", "Manchester", "Glasgow", "Liverpool", "Bristol", "Édimbourg", "Leeds", "Sheffield", "Leicester"]
            };
            
            // Simuler un délai de chargement
            setTimeout(() => {
                citySpinner.style.display = 'none';
                
                // Si le pays est dans notre liste, afficher ses villes
                if (citiesByCountry[country]) {
                    const filteredCities = citiesByCountry[country].filter(city => 
                        city.toLowerCase().includes(query.toLowerCase())
                    );
                    
                    if (filteredCities.length === 0) return;
                    
                    filteredCities.forEach(city => {
                        const item = document.createElement('div');
                        item.className = 'autocomplete-item';
                        item.textContent = city;
                        item.addEventListener('click', () => {
                            cityField.value = city;
                            cityIdField.value = city;
                            cityResults.style.display = 'none';
                        });
                        cityResults.appendChild(item);
                    });
                    
                    cityResults.style.display = 'block';
                }
            }, 300);
        }
        
        // Événements pour le champ pays
        countryField.addEventListener('input', function() {
            const query = this.value.trim();
            showCountryResults(query);
            
            if (query) {
                countryCodeField.value = query;
            } else {
                countryCodeField.value = "";
            }
        });
        
        countryField.addEventListener('focus', function() {
            if (this.value.trim()) {
                showCountryResults(this.value.trim());
            }
        });
        
        // Événements  {
                showCountryResults(this.value.trim());
            }
        );
        
        // Événements pour le champ ville
        cityField.addEventListener('input', function() {
            const query = this.value.trim();
            const country = countryField.value.trim();
            showCityResults(country, query);
            
            if (query) {
                cityIdField.value = query;
            } else {
                cityIdField.value = "";
            }
        });
        
        cityField.addEventListener('focus', function() {
            if (this.value.trim() && countryField.value.trim()) {
                showCityResults(countryField.value.trim(), this.value.trim());
            }
        });
        
        // Événements pour le champ secteur
        sectorField.addEventListener('input', function() {
            const query = this.value.trim();
            showSectorResults(query);
            
            if (query) {
                sectorCodeField.value = query;
            } else {
                sectorCodeField.value = "";
            }
        });
        
        sectorField.addEventListener('focus', function() {
            if (this.value.trim()) {
                showSectorResults(this.value.trim());
            }
        });
        
        // Événements pour les boutons de suppression
        clearCountryBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            countryField.value = '';
            countryCodeField.value = '';
            countryResults.style.display = 'none';
        });
        
        clearCityBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            cityField.value = '';
            cityIdField.value = '';
            cityResults.style.display = 'none';
        });
        
        clearSectorBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            sectorField.value = '';
            sectorCodeField.value = '';
            sectorResults.style.display = 'none';
        });
        
        // Fermer les résultats d'autocomplétion quand on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!countryField.contains(e.target) && !countryResults.contains(e.target)) {
                countryResults.style.display = 'none';
            }
            
            if (!cityField.contains(e.target) && !cityResults.contains(e.target)) {
                cityResults.style.display = 'none';
            }
            
            if (!sectorField.contains(e.target) && !sectorResults.contains(e.target)) {
                sectorResults.style.display = 'none';
            }
        });
        
        // Gérer l'URL du site web
        websiteField.addEventListener('input', function() {
            if (this.value.trim()) {
                // Construire l'URL complète
                const websiteUrl = 'https://' + this.value.trim();
                websiteFullField.value = websiteUrl;
            } else {
                websiteFullField.value = '';
            }
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
                websiteFullField.value = websiteUrl;
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
</script>
@endsection

