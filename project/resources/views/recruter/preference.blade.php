@extends('layouts.recruteur')

@section('title', 'Préférences de matching')

@section('styles')
<style>
    .header-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }
    
    .back-button {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: 9999px;
        background-color: #f3f4f6;
        color: #4b5563;
        transition: all 0.2s;
    }
    
    .back-button:hover {
        background-color: #e5e7eb;
    }
    
    .card {
        background-color: white;
        border-radius: 0.5rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .job-info {
        display: flex;
        align-items: flex-start;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .job-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 3rem;
        height: 3rem;
        background-color: #f3f4f6;
        border-radius: 0.5rem;
        margin-right: 1rem;
        color: #4b5563;
    }
    
    .job-details h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.25rem;
    }
    
    .job-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
        color: #6b7280;
        font-size: 0.875rem;
    }
    
    .job-meta-item {
        display: flex;
        align-items: center;
    }
    
    .job-meta-item i {
        margin-right: 0.375rem;
    }
    
    .section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
    }
    
    .section-description {
        color: #6b7280;
        margin-bottom: 1.5rem;
    }
    
    .toggle-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 1rem;
        background-color: #f9fafb;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
    
    .toggle-label {
        font-weight: 500;
        color: #374151;
    }
    
    .toggle-switch {
        position: relative;
        display: inline-block;
        width: 3.5rem;
        height: 2rem;
    }
    
    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    
    .toggle-slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e5e7eb;
        transition: .4s;
        border-radius: 2rem;
    }
    
    .toggle-slider:before {
        position: absolute;
        content: "";
        height: 1.5rem;
        width: 1.5rem;
        left: 0.25rem;
        bottom: 0.25rem;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    
    input:checked + .toggle-slider {
        background-color: #2563eb;
    }
    
    input:checked + .toggle-slider:before {
        transform: translateX(1.5rem);
    }
    
    .weights-container {
        margin-bottom: 2rem;
    }
    
    .weight-item {
        margin-bottom: 1.5rem;
    }
    
    .weight-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 0.5rem;
    }
    
    .weight-label {
        font-weight: 500;
        color: #374151;
    }
    
    .weight-value {
        font-weight: 600;
        color: #2563eb;
    }
    
    .weight-slider {
        -webkit-appearance: none;
        width: 100%;
        height: 0.5rem;
        border-radius: 0.25rem;
        background: #e5e7eb;
        outline: none;
    }
    
    .weight-slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        background: #2563eb;
        cursor: pointer;
    }
    
    .weight-slider::-moz-range-thumb {
        width: 1.25rem;
        height: 1.25rem;
        border-radius: 50%;
        background: #2563eb;
        cursor: pointer;
    }
    
    .weight-description {
        font-size: 0.875rem;
        color: #6b7280;
        margin-top: 0.5rem;
    }
    
    .total-weight {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem;
        background-color: #f9fafb;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
    
    .total-weight-label {
        font-weight: 500;
        color: #374151;
    }
    
    .total-weight-value {
        font-weight: 600;
        font-size: 1.125rem;
    }
    
    .total-weight-value.valid {
        color: #059669;
    }
    
    .total-weight-value.invalid {
        color: #dc2626;
    }
    
    .buttons-container {
        display: flex;
        justify-content: flex-end;
        gap: 1rem;
    }
    
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        border-radius: 0.375rem;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
    }
    
    .btn-primary {
        background-color: #2563eb;
        color: white;
    }
    
    .btn-primary:hover {
        background-color: #1d4ed8;
    }
    
    .btn-secondary {
        background-color: #f3f4f6;
        color: #4b5563;
    }
    
    .btn-secondary:hover {
        background-color: #e5e7eb;
    }
    
    .alert {
        padding: 1rem;
        border-radius: 0.375rem;
        margin-bottom: 1.5rem;
    }
    
    .alert-warning {
        background-color: #fef3c7;
        color: #92400e;
    }
    
    .hidden {
        display: none;
    }
</style>
@endsection

@section('content')
<div class="container mx-auto py-6 px-4">
    <!-- Header -->
    <div class="header-container">
        <h1 class="text-2xl font-bold text-gray-900">Préférences de matching</h1>
        <a href="{{ route('offers.index') }}" class="back-button">
            <i class="fas fa-times"></i>
        </a>
    </div>
    
    @if(session('success'))
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p>{{ session('success') }}</p>
    </div>
    @endif
    
    @if(session('error'))
    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
        <p>{{ session('error') }}</p>
    </div>
    @endif
    
    <div class="card">
        <!-- Job Information -->
        <div class="job-info">
            <div class="job-icon">
                <i class="fas fa-briefcase fa-lg"></i>
            </div>
            <div class="job-details">
                <h3>{{ $offre->title }}</h3>
                <div class="job-meta">
                    <div class="job-meta-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <span>{{ $offre->location }}</span>
                    </div>
                    <div class="job-meta-item">
                        <i class="fas fa-clock"></i>
                        <span>{{ $offre->type_contrat }}</span>
                    </div>
                    <div class="job-meta-item">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Publié le {{ $offre->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <h2 class="section-title">Paramètres de matching des candidats</h2>
        <p class="section-description">
            Personnalisez la façon dont nous trouvons les meilleurs candidats pour votre offre d'emploi.
            Vous pouvez utiliser notre IA pour un matching automatique ou définir vos propres critères de priorité.
        </p>
        
        <form action="{{ route('preference.store', $offre->id) }}" method="POST" id="preferences-form">
            @csrf
            
            <!-- AI Toggle -->
            <div class="toggle-container">
                <div class="toggle-label">Utiliser l'IA pour le matching des candidats</div>
                <label class="toggle-switch">
                    <input type="checkbox" name="use_ai" id="use-ai-toggle" {{ $preference && $preference->use_ai ? 'checked' : '' }}>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            
            <!-- Weights Section -->
            <div id="weights-section" class="{{ $preference && $preference->use_ai ? 'hidden' : '' }}">
                <h3 class="section-title">Personnaliser les poids de matching</h3>
                <p class="section-description">
                    Ajustez l'importance de chaque critère pour trouver les candidats qui correspondent le mieux à vos besoins.
                    La somme des pourcentages doit être égale à 100%.
                </p>
                
                <div class="weights-container">
                    <!-- Skills Weight -->
                    <div class="weight-item">
                        <div class="weight-header">
                            <div class="weight-label">Compétences</div>
                            <div class="weight-value" id="skills-value">{{ $preference ? ($preference->skills_weight * 100) : 40 }}%</div>
                        </div>
                        <input type="range" min="0" max="100" step="5" class="weight-slider" id="skills-slider" 
                               name="skills_weight" value="{{ $preference ? ($preference->skills_weight * 100) : 40 }}">
                        <div class="weight-description">
                            L'importance des compétences techniques et professionnelles du candidat.
                        </div>
                    </div>
                    
                    <!-- Languages Weight -->
                    <div class="weight-item">
                        <div class="weight-header">
                            <div class="weight-label">Langues</div>
                            <div class="weight-value" id="languages-value">{{ $preference ? ($preference->languages_weight * 100) : 20 }}%</div>
                        </div>
                        <input type="range" min="0" max="100" step="5" class="weight-slider" id="languages-slider" 
                               name="languages_weight" value="{{ $preference ? ($preference->languages_weight * 100) : 20 }}">
                        <div class="weight-description">
                            L'importance des compétences linguistiques du candidat.
                        </div>
                    </div>
                    
                    <!-- Experience Weight -->
                    <div class="weight-item">
                        <div class="weight-header">
                            <div class="weight-label">Expérience</div>
                            <div class="weight-value" id="experience-value">{{ $preference ? ($preference->experience_weight * 100) : 25 }}%</div>
                        </div>
                        <input type="range" min="0" max="100" step="5" class="weight-slider" id="experience-slider" 
                               name="experience_weight" value="{{ $preference ? ($preference->experience_weight * 100) : 25 }}">
                        <div class="weight-description">
                            L'importance de l'expérience professionnelle du candidat.
                        </div>
                    </div>
                    
                    <!-- Location Weight -->
                    <div class="weight-item">
                        <div class="weight-header">
                            <div class="weight-label">Localisation</div>
                            <div class="weight-value" id="location-value">{{ $preference ? ($preference->location_weight * 100) : 15 }}%</div>
                        </div>
                        <input type="range" min="0" max="100" step="5" class="weight-slider" id="location-slider" 
                               name="location_weight" value="{{ $preference ? ($preference->location_weight * 100) : 15 }}">
                        <div class="weight-description">
                            L'importance de la proximité géographique du candidat.
                        </div>
                    </div>
                </div>
                
                <!-- Total Weight -->
                <div class="total-weight">
                    <div class="total-weight-label">Total</div>
                    <div class="total-weight-value" id="total-weight-value">100%</div>
                </div>
                
                <div class="alert alert-warning hidden" id="total-warning">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    Le total des poids doit être égal à 100%.
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="buttons-container">
                <a href="{{ route('offers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times mr-2"></i>
                    Annuler
                </a>
                <button type="submit" class="btn btn-primary" id="save-button">
                    <i class="fas fa-save mr-2"></i>
                    Enregistrer les préférences
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Éléments DOM
        const useAiToggle = document.getElementById('use-ai-toggle');
        const weightsSection = document.getElementById('weights-section');
        const sliders = document.querySelectorAll('.weight-slider');
        const totalWeightValue = document.getElementById('total-weight-value');
        const totalWarning = document.getElementById('total-warning');
        const saveButton = document.getElementById('save-button');
        const form = document.getElementById('preferences-form');
        
        // Afficher/masquer la section des poids selon l'état de l'IA
        useAiToggle.addEventListener('change', function() {
            weightsSection.classList.toggle('hidden', this.checked);
            
            // Si l'IA est activée, on peut toujours enregistrer
            if (this.checked) {
                saveButton.disabled = false;
                totalWarning.classList.add('hidden');
            } else {
                // Sinon, on vérifie si la somme est égale à 100%
                checkTotal();
            }
        });
        
        // Mettre à jour les valeurs affichées quand les sliders changent
        sliders.forEach(slider => {
            const valueDisplay = document.getElementById(slider.id.replace('-slider', '-value'));
            
            slider.addEventListener('input', function() {
                valueDisplay.textContent = this.value + '%';
                checkTotal();
            });
        });
        
        // Vérifier si la somme est égale à 100%
        function checkTotal() {
            let total = 0;
            sliders.forEach(slider => {
                total += parseInt(slider.value);
            });
            
            totalWeightValue.textContent = total + '%';
            
            // Vérifier si le total est égal à 100%
            const isValid = total === 100;
            
            // Mettre à jour les classes CSS
            totalWeightValue.classList.toggle('valid', isValid);
            totalWeightValue.classList.toggle('invalid', !isValid);
            totalWarning.classList.toggle('hidden', isValid);
            
            // Activer/désactiver le bouton d'enregistrement
            saveButton.disabled = !isValid && !useAiToggle.checked;
        }
        
        // Vérifier avant la soumission du formulaire
        form.addEventListener('submit', function(e) {
            if (!useAiToggle.checked) {
                let total = 0;
                sliders.forEach(slider => {
                    total += parseInt(slider.value);
                });
                
                if (total !== 100) {
                    e.preventDefault();
                    totalWarning.classList.remove('hidden');
                    totalWarning.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });
        
        // Vérification initiale
        checkTotal();
    });
</script>
@endsection
