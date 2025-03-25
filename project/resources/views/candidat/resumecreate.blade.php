@extends('layouts.candidat')

@section('title', 'Créer votre CV WorkBridge')

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
        border-top: 2px solid #2557a7;
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
<div class="max-w-3xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Créer votre CV WorkBridge</h1>
        <p class="mt-2 text-gray-600">Complétez les informations ci-dessous pour créer votre CV professionnel.</p>
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
    
    <form action="{{ route('resume.store') }}" method="POST">
        @csrf
        
        <div class="form-section">
            <h2 class="form-section-title">Informations personnelles</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-group">
                    <label for="birthDate" class="form-label">Date de naissance</label>
                    <input type="date" id="birthDate" name="birthDate" class="form-input" value="{{ old('birthDate') }}" required>
                    @error('birthDate')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Numéro de téléphone</label>
                    <input type="tel" id="phone" name="phone" class="form-input" value="{{ old('phone') }}" required>
                    @error('phone')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="pays" class="form-label">Pays</label>
                    <div class="input-with-icon">
                        <input type="text" id="pays" name="pays" class="form-input" value="{{ old('pays') }}" required placeholder="Sélectionner un pays...">
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
                    <label for="ville" class="form-label">Ville</label>
                    <div class="input-with-icon">
                        <input type="text" id="ville" name="ville" class="form-input" value="{{ old('ville') }}" required placeholder="Sélectionner une ville..." {{ old('pays') ? '' : 'disabled' }}>
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
            
            <div class="form-group mt-4">
                <div class="flex items-center">
                    <input type="checkbox" id="relocation_possible" name="relocation_possible" class="form-checkbox" value="1" {{ old('relocation_possible') ? 'checked' : '' }}>
                    <label for="relocation_possible" class="ml-2 text-gray-700">Je suis prêt(e) à déménager pour un emploi</label>
                </div>
                <p class="form-help-text">Cochez cette case si vous êtes ouvert(e) à des opportunités qui nécessitent un déménagement.</p>
            </div>
        </div>
        
        <div class="flex justify-end mt-8">
            <a href="{{ route('profil.candidat') }}" class="btn-cancel">
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
        // Éléments du formulaire
        const paysField = document.getElementById('pays');
        const countryCodeField = document.getElementById('country-code');
        const villeField = document.getElementById('ville');
        const cityIdField = document.getElementById('city-id');
        
        // Résultats d'autocomplétion
        const countryResults = document.getElementById('country-results');
        const cityResults = document.getElementById('city-results');
        
        // Spinners
        const countrySpinner = document.getElementById('country-spinner');
        const citySpinner = document.getElementById('city-spinner');
        
        // Boutons de suppression
        const clearCountryBtn = document.getElementById('clear-country');
        const clearCityBtn = document.getElementById('clear-city');
        
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
                    paysField.value = country;
                    countryCodeField.value = country;
                    countryResults.style.display = 'none';
                    
                    // Activer le champ ville
                    villeField.disabled = false;
                    villeField.placeholder = "Sélectionner une ville...";
                    
                    // Simuler un événement input pour déclencher d'autres comportements
                    const event = new Event('input', { bubbles: true });
                    paysField.dispatchEvent(event);
                });
                countryResults.appendChild(item);
            });
            
            countryResults.style.display = 'block';
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
                            villeField.value = city;
                            cityIdField.value = city;
                            cityResults.style.display = 'none';
                        });
                        cityResults.appendChild(item);
                    });
                    
                    cityResults.style.display = 'block';
                } else {
                    // Si le pays n'est pas dans notre liste, permettre la saisie libre
                    cityIdField.value = villeField.value;
                }
            }, 500);
        }
        
        // Événements pour le champ pays
        paysField.addEventListener('input', function() {
            const query = this.value.trim();
            showCountryResults(query);
            
            if (query) {
                countryCodeField.value = query;
                villeField.disabled = false;
                villeField.placeholder = "Sélectionner une ville...";
            } else {
                countryCodeField.value = "";
                villeField.disabled = true;
                villeField.value = "";
                cityIdField.value = "";
                villeField.placeholder = "Sélectionner d'abord un pays...";
            }
        });
        
        paysField.addEventListener('focus', function() {
            if (this.value.trim()) {
                showCountryResults(this.value.trim());
            }
        });
        
        // Événements pour le champ ville
        villeField.addEventListener('input', function() {
            const query = this.value.trim();
            const country = paysField.value.trim();
            showCityResults(country, query);
            
            if (query) {
                cityIdField.value = query;
            } else {
                cityIdField.value = "";
            }
        });
        
        villeField.addEventListener('focus', function() {
            if (this.value.trim() && paysField.value.trim()) {
                showCityResults(paysField.value.trim(), this.value.trim());
            }
        });
        
        // Événements pour les boutons de suppression
        clearCountryBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            paysField.value = '';
            countryCodeField.value = '';
            countryResults.style.display = 'none';
            
            // Désactiver et réinitialiser le champ ville
            villeField.disabled = true;
            villeField.value = '';
            cityIdField.value = '';
            villeField.placeholder = "Sélectionner d'abord un pays...";
        });
        
        clearCityBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            villeField.value = '';
            cityIdField.value = '';
            cityResults.style.display = 'none';
        });
        
        // Fermer les résultats d'autocomplétion quand on clique ailleurs
        document.addEventListener('click', function(e) {
            if (!paysField.contains(e.target) && !countryResults.contains(e.target)) {
                countryResults.style.display = 'none';
            }
            
            if (!villeField.contains(e.target) && !cityResults.contains(e.target)) {
                cityResults.style.display = 'none';
            }
        });
    });
</script>
@endsection

