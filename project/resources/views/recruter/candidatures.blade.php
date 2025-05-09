@extends('layouts.recruteur')

@section('title', 'Comsulter les candidatures')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">Gestion des candidatures</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Liste des offres (colonne de gauche) -->
        <div class="md:col-span-1 bg-white rounded-lg shadow-md p-4">
            <h2 class="text-lg font-semibold mb-4">Mes offres d'emploi</h2>
            
            <div class="space-y-2">
                @forelse($offres as $offre)
                    <div class="offer-item p-3 rounded-md cursor-pointer hover:bg-gray-100 transition-colors {{ $selectedOffre && $selectedOffre->id == $offre->id ? 'bg-blue-50 border-l-4 border-blue-500' : '' }}"
                        data-offer-id="{{ $offre->id }}">
                        <h3 class="font-medium">{{ $offre->title }}</h3>
                        <div class="text-sm text-gray-500 flex items-center justify-between">
                            <span>{{ $offre->location }}</span>
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2 py-0.5 rounded-full">
                                {{ $offre->applications_count ?? 0 }} candidat(s)
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-4">
                        <p>Aucune offre publiée</p>
                        <a href="{{ route('recruter.offres.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                            Publier une offre
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
        
        <!-- Liste des candidatures (colonne de droite) -->
        <div class="md:col-span-3 bg-white rounded-lg shadow-md p-4">
            @if($selectedOffre)
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-lg font-semibold">Candidatures pour : {{ $selectedOffre->title }}</h2>
                    <div class="flex space-x-2">
                        <select id="filter-status" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                            <option value="all">Tous les statuts</option>
                            <option value="pending">En attente</option>
                            <option value="accepted">Accepté</option>
                            <option value="rejected">Refusé</option>
                            <option value="interview">Entretien</option>
                        </select>
                    </div>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Candidat
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Matching
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="applications-container">
                            @forelse($applications as $application)
                                <tr class="application-row" data-status="{{ $application->status }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10">
                                                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 font-semibold">
                                                    {{ substr($application->user->name ?? 'U', 0, 1) }}
                                                </div>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $application->user->name ?? 'Utilisateur inconnu' }}
                                                </div>
                                                <div class="text-sm text-gray-500">
                                                    {{ $application->user->email ?? 'Email non disponible' }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $application->created_at->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $application->created_at->format('H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $application->match_score ?? '' }}%"></div>
                                            </div>
                                            <span class="ml-2 text-sm text-gray-700">{{ $application->match_score ?? ''}}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <select class="status-select text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                                data-application-id="{{ $application->id }}">
                                            <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                            <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepté</option>
                                            <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Refusé</option>
                                            <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Entretien</option>
                                        </select>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('candidatures.show', ['offre' => $selectedOffre->id, 'application' => $application->id]) }}" 
                                                class="text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-eye"></i> Voir
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        Aucune candidature pour cette offre
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-4">
                    {{ $applications->links() }}
                </div>
            @else
                <div class="flex flex-col items-center justify-center py-12">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-2 text-lg font-medium text-gray-900">Aucune offre sélectionnée</h3>
                    <p class="mt-1 text-sm text-gray-500">
                        Sélectionnez une offre dans la liste pour voir les candidatures associées.
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Notification de mise à jour du statut -->
<div id="status-notification" class="fixed bottom-4 right-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-md transform translate-y-full opacity-0 transition-all duration-300">
    <div class="flex">
        <div class="py-1"><svg class="fill-current h-6 w-6 text-green-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
        <div>
            <p class="font-bold">Statut mis à jour</p>
            <p class="text-sm">Le statut de la candidature a été mis à jour avec succès.</p>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sélection d'une offre
    const offerItems = document.querySelectorAll('.offer-item');
    offerItems.forEach(item => {
        item.addEventListener('click', function() {
            const offerId = this.getAttribute('data-offer-id');
            window.location.href = `/candidatures/${offerId}`;
        });
    });

    // Filtrage par statut
    const filterStatus = document.getElementById('filter-status');
    if (filterStatus) {
        filterStatus.addEventListener('change', function() {
            const status = this.value;
            const rows = document.querySelectorAll('.application-row');
            
            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                if (status === 'all' || status === rowStatus) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
    
    // Mise à jour du statut
    const statusSelects = document.querySelectorAll('.status-select');
    statusSelects.forEach(select => {
        select.addEventListener('change', function() {
            const applicationId = this.getAttribute('data-application-id');
            const newStatus = this.value;
            const offerId = {{ $selectedOffre->id ?? 'null' }};
            
            if (!offerId) return;
            
            fetch(`/candidatures/${offerId}/application/${applicationId}/status`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.closest('.application-row').setAttribute('data-status', newStatus);
                    
                    const notification = document.getElementById('status-notification');
                    notification.classList.remove('translate-y-full', 'opacity-0');
                    
                    setTimeout(() => {
                        notification.classList.add('translate-y-full', 'opacity-0');
                    }, 3000);
                } else {
                    alert('Erreur lors de la mise à jour du statut');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Une erreur est survenue lors de la mise à jour du statut');
            });
        });
    });
});
</script>
@endsection
