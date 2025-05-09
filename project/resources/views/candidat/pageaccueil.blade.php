@extends('layouts.candidat')

@section('title', 'Recherche d\'emploi')

@section('styles')
<style>
    .job-card {
        transition: all 0.2s;
        cursor: pointer;
    }
    .job-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    .job-card.active {
        border-color: #4f46e5;
        background-color: #f9f9ff;
    }
    .job-details {
        height: calc(100vh - 16rem);
        overflow-y: auto;
    }
    .search-container {
        background: linear-gradient(to right, #4f46e5, #6366f1);
    }
    .badge-skill {
        @apply bg-indigo-100 text-indigo-800 text-xs font-medium px-2.5 py-0.5 rounded-full;
    }
    .badge-language {
        @apply bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full;
    }
    .company-logo {
        width: 50px;
        height: 50px;
        background-color: #f3f4f6;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        overflow: hidden;
    }
    .company-logo img {
        max-width: 100%;
        max-height: 100%;
    }
    .company-logo-placeholder {
        font-size: 1.5rem;
        font-weight: bold;
        color: #6b7280;
    }
    .job-list {
        height: calc(100vh - 16rem);
        overflow-y: auto;
    }
    .job-list::-webkit-scrollbar, .job-details::-webkit-scrollbar {
        width: 6px;
    }
    .job-list::-webkit-scrollbar-track, .job-details::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
    .job-list::-webkit-scrollbar-thumb, .job-details::-webkit-scrollbar-thumb {
        background: #c5c5c5;
        border-radius: 3px;
    }
    .job-list::-webkit-scrollbar-thumb:hover, .job-details::-webkit-scrollbar-thumb:hover {
        background: #a8a8a8;
    }
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-align: center;
        padding: 2rem;
    }
    .empty-icon {
        font-size: 3rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }
    .search-loader {
        display: none;
        margin-left: 0.5rem;
    }
    .search-loader.active {
        display: inline-block;
    }
</style>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Search Section -->
    <div class="search-container py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <form id="search-form" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label for="keywords" class="block text-sm font-medium text-gray-700 mb-1">Mots-clés</label>
                        <input type="text" name="keywords" id="keywords" placeholder="Titre, compétences ou entreprise" 
                            class="search-input" value="{{ request('keywords') }}">
                    </div>
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-1">Lieu</label>
                        <input type="text" name="location" id="location" placeholder="Ville ou région" 
                            class="search-input" value="{{ request('location') }}">
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="search-button w-full flex items-center justify-center">
                            <i class="fas fa-search mr-2"></i> Rechercher
                            <div class="search-loader">
                                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                            </div>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jobs Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900" id="search-results-count">
                @if(isset($jobs) && $jobs->count() > 0)
                    {{ $jobs->count() }} offres trouvées
                @else
                    Offres d'emploi recommandées
                @endif
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Job Listings -->
            <div class="lg:col-span-1">
                <div class="job-list" id="job-list-container">
                    @if(isset($jobs) && $jobs->count() > 0)
                        @include('candidat.partials.job_list', ['jobs' => $jobs])
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="fas fa-search"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Aucune offre trouvée</h3>
                            <p class="text-gray-500 mt-1">Essayez de modifier vos critères de recherche</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Job Details -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg border h-full" id="job-details-container">
                    @if(isset($selectedJob))
                        @include('candidat.partials.offer_details', ['offer' => $selectedJob])
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="far fa-file-alt"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900">Sélectionnez une offre</h3>
                            <p class="text-gray-500 mt-1">Cliquez sur une offre pour voir les détails</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function handleApplication(event, offerId) 
    {
        event.preventDefault();
        event.stopPropagation();

        const form = event.target;
        const button = form.querySelector('button[type="submit"]');
        const originalButtonText = button.innerHTML;

        // Afficher le loader sur le bouton
        button.disabled = true;
        button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Envoi en cours...';

        fetch(form.action, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({})
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => { throw err; });
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                button.innerHTML = '<i class="fas fa-check mr-2"></i> Candidature envoyée';
                button.classList.remove('bg-blue-700', 'hover:bg-blue-800');
                button.classList.add('bg-gray-400', 'cursor-not-allowed');
            } else {
                if (data.redirect) {
                    window.location.href = data.redirect;
                } else {
                    showNotification(data.message, 'error');
                    button.disabled = false;
                    button.innerHTML = originalButtonText;
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification(error.message || 'Une erreur est survenue', 'error');
            button.disabled = false;
            button.innerHTML = originalButtonText;
        });
    }

    // Fonction pour afficher les notifications
    function showNotification(message, type) 
    {
        const notification = document.getElementById('notification-message');
        const notificationText = document.getElementById('notification-text');
        
        if (!notification || !notificationText) {
            alert(message);
            return;
        }
        
        notificationText.textContent = message;
        notification.classList.remove('hidden', 'bg-red-100', 'text-red-800', 'bg-green-100', 'text-green-800');
        
        if (type === 'success') {
            notification.classList.add('bg-green-100', 'text-green-800');
        } else {
            notification.classList.add('bg-red-100', 'text-red-800');
        }
        
        notification.classList.remove('hidden');
        
        // callback function pour masquer notif apret 5s
        setTimeout(() => {
            notification.classList.add('hidden');
        }, 5000);
    }

    function loadOfferDetails(jobId, element) {
        const detailsContainer = document.getElementById('job-details-container');
        detailsContainer.innerHTML = `
            <div class="empty-state">
                <div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-indigo-500 mx-auto"></div>
                <p class="text-gray-500 mt-4">Chargement des détails...</p>
            </div>
        `;

        fetch(`/candidat/offres/${jobId}`, { 
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            }
        })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Erreur serveur');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    detailsContainer.innerHTML = data.html;
                    document.querySelectorAll('form[data-ajax-application]').forEach(form => {
                        form.addEventListener('submit', (e) => handleApplication(e, jobId));
                    });
                    // mettre a jour url
                    const url = new URL(window.location);
                    url.searchParams.set('job_id', jobId);
                    window.history.pushState({}, '', url);
                    
                    // gestion des offres active
                    document.querySelectorAll('.job-card').forEach(card => {
                        card.classList.remove('active');
                    });
                    element.classList.add('active');
                } else {
                    throw new Error(data.message || 'Réponse inattendue');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                detailsContainer.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="fas fa-exclamation-triangle"></i>
                        </div>
                        <h3 class="text-lg font-medium text-gray-900">Erreur</h3>
                        <p class="text-gray-500 mt-1">${error.message}</p>
                    </div>
                `;
            });
    }

    function setupJobCardListeners() {
        document.querySelectorAll('.job-card').forEach(card => {
            card.addEventListener('click', function(e) {
                const jobId = this.getAttribute('data-job-id');
                loadOfferDetails(jobId, this);
            });
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Configurer le formulaire de recherche AJAX
        const jobListContainer = document.getElementById('job-list-container');
        const searchResultsCount = document.getElementById('search-results-count');
        const searchLoader = document.querySelector('.search-loader');
        
        // Configurer les écouteurs d'événements pour les cartes d'offres
        setupJobCardListeners();

        // Gestion du clic initial si une offre est sélectionnée
        const initialJobId = new URLSearchParams(window.location.search).get('job_id');
        if (initialJobId) {
            const card = document.querySelector(`.job-card[data-job-id="${initialJobId}"]`);
            if (card) {
                card.classList.add('active');
                loadOfferDetails(initialJobId, card);
            }
        }
    });
</script>
@endsection
