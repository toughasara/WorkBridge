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
    .search-input {
        @apply block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500;
    }
    .search-button {
        @apply bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out;
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
</style>
@endsection

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Search Section -->
    <div class="search-container py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <form action="{{ route('candidat.offres.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                        <button type="submit" class="search-button w-full">
                            <i class="fas fa-search mr-2"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Jobs Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-semibold text-gray-900">
                @if(isset($searchResults))
                    {{ $jobs->total() }} offres trouvées
                @else
                    Offres d'emploi recommandées
                @endif
            </h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Job Listings -->
            <div class="lg:col-span-1">
                <div class="job-list">
                    @if(count($jobs) > 0)
                        @foreach($jobs as $job)
                        <div class="job-card bg-white rounded-lg border p-4 mb-4 {{ request('job_id') == $job->id ? 'active' : '' }}" 
                            data-job-id="{{ $job->id }}">                               
                            <div class="flex items-start">
                                    <div class="company-logo mr-4">
                                    @if($job->company)
                                        <p class="text-gray-600 text-sm">{{ $job->company->name }}</p>
                                    @else
                                        <p class="text-gray-600 text-sm">Entreprise non spécifiée</p>
                                    @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $job->title }}</h3>
                                        @if($job->company)
                                            <p class="text-gray-600 text-sm">{{ $job->company->name }}</p>
                                        @else
                                            <p class="text-gray-600 text-sm">Entreprise non spécifiée</p>
                                        @endif
                                        <p class="text-gray-500 text-sm">{{ $job->location }}</p>
                                    </div>
                                    @if(isset($job->match_score))
                                        <div class="mt-3">
                                            <div class="flex justify-between items-center mb-1">
                                                <span class="text-xs font-medium text-indigo-700">Score de matching</span>
                                                <span class="text-xs font-medium text-indigo-700">{{ $job->match_score }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $job->match_score }}%"></div>
                                            </div>
                                        </div>
                                    @endif
                                    <div class="text-gray-500 text-xs">
                                        {{ $job->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="mt-4">
                        </div>
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
        'Accept': 'application/json',
        'X-Requested-With': 'XMLHttpRequest',
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

    document.addEventListener('DOMContentLoaded', function() {
        // gestion de clique sur une offre
        document.querySelectorAll('.job-card').forEach(card => {
            card.addEventListener('click', function(e) {
                const jobId = this.getAttribute('data-job-id');
                loadOfferDetails(jobId, this);
            });
        });

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