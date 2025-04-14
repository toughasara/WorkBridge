@extends('layouts.candidate')

@section('title', 'Recherche d\'emploi')

@section('styles')
<style>
    .job-card {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    .job-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
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
                <form action="{{ route('jobs.search') }}" method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4">
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
                                 onclick="window.location.href='{{ route('jobs.show', $job->id) }}'">
                                <div class="flex items-start">
                                    <div class="company-logo mr-4">
                                        @if($job->company->logo)
                                            <img src="{{ asset('storage/' . $job->company->logo) }}" alt="{{ $job->company->name }}">
                                        @else
                                            <div class="company-logo-placeholder">{{ substr($job->company->name, 0, 1) }}</div>
                                        @endif
                                    </div>
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-900">{{ $job->title }}</h3>
                                        <p class="text-gray-600 text-sm">{{ $job->company->name }}</p>
                                        <p class="text-gray-500 text-sm">{{ $job->location }}</p>
                                    </div>
                                    <div class="text-gray-500 text-xs">
                                        {{ $job->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="mt-4">
                            {{ $jobs->links() }}
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
                <div class="bg-white rounded-lg border h-full">
                    @if(isset($selectedJob))
                        <div class="job-details p-6">
                            <div class="flex items-start justify-between mb-6">
                                <div class="flex items-start">
                                    <div class="company-logo mr-4">
                                        @if($selectedJob->company->logo)
                                            <img src="{{ asset('storage/' . $selectedJob->company->logo) }}" alt="{{ $selectedJob->company->name }}">
                                        @else
                                            <div class="company-logo-placeholder">{{ substr($selectedJob->company->name, 0, 1) }}</div>
                                        @endif
                                    </div>
                                    <div>
                                        <h1 class="text-2xl font-bold text-gray-900">{{ $selectedJob->title }}</h1>
                                        <p class="text-gray-600">{{ $selectedJob->company->name }} • {{ $selectedJob->location }}</p>
                                        <div class="flex items-center text-gray-500 text-sm mt-1">
                                            <span class="mr-3"><i class="far fa-clock mr-1"></i> {{ $selectedJob->job_type }}</span>
                                            <span><i class="far fa-calendar-alt mr-1"></i> Publié {{ $selectedJob->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex space-x-2">
                                    <button class="btn-secondary text-sm">
                                        <i class="far fa-bookmark"></i>
                                    </button>
                                    <button class="btn-secondary text-sm">
                                        <i class="fas fa-share-alt"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2 mb-6">
                                @foreach($selectedJob->skills as $skill)
                                    <span class="badge-skill">{{ $skill->name }}</span>
                                @endforeach
                            </div>

                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-3">Description du poste</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! $selectedJob->description !!}
                                </div>
                            </div>

                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-3">Compétences requises</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! $selectedJob->requirements !!}
                                </div>
                            </div>

                            <div class="mb-6">
                                <h2 class="text-lg font-semibold text-gray-900 mb-3">Ce que nous offrons</h2>
                                <div class="prose max-w-none text-gray-700">
                                    {!! $selectedJob->benefits !!}
                                </div>
                            </div>

                            <div class="border-t pt-6 mt-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-gray-500 text-sm">Soyez parmi les premiers à postuler</p>
                                    </div>
                                    @if(auth()->user()->hasAppliedToJob($selectedJob->id))
                                        <button class="btn-secondary" disabled>
                                            <i class="fas fa-check mr-2"></i> Candidature envoyée
                                        </button>
                                    @else
                                        <a href="{{ route('jobs.apply', $selectedJob->id) }}" class="btn-primary">
                                            <i class="fas fa-paper-plane mr-2"></i> Postuler maintenant
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
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
    document.addEventListener('DOMContentLoaded', function() {
        // Scroll to active job card if exists
        const activeCard = document.querySelector('.job-card.active');
        if (activeCard) {
            activeCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
@endsection
