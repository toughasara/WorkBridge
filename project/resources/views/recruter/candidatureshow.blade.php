@extends('layouts.recruteur')

@section('title', 'Comsulter les details de candidature')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('candidatures.index', ['offre' => $offre->id]) }}" class="text-blue-600 hover:text-blue-800">
            <i class="fas fa-arrow-left mr-2"></i> Retour aux candidatures
        </a>
    </div>
    
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <!-- En-tête avec les informations du candidat -->
        <div class="bg-gray-50 p-6 border-b">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div class="flex items-center">
                    <div class="h-16 w-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-600 text-xl font-semibold">
                        {{ substr($application->user->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="ml-4">
                        <h1 class="text-2xl font-bold text-gray-900">{{ $application->user->name }}</h1>
                        <div class="flex items-center text-gray-600">
                            <i class="far fa-envelope mr-2"></i>
                            <a href="mailto:{{ $application->user->email }}" class="hover:text-blue-600">{{ $application->user->email }}</a>
                        </div>
                        @if($application->user->phone)
                            <div class="flex items-center text-gray-600 mt-1">
                                <i class="fas fa-phone mr-2"></i>
                                <a href="tel:{{ $application->user->phone }}" class="hover:text-blue-600">{{ $application->user->phone }}</a>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="mt-4 md:mt-0">
                    <div class="flex flex-col items-end">
                        <div class="text-sm text-gray-500">Candidature soumise le {{ $application->created_at->format('d/m/Y à H:i') }}</div>
                        
                        <div class="mt-2 flex items-center">
                            <span class="mr-2 text-sm text-gray-700">Statut:</span>
                            <select id="application-status" class="text-sm border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                    data-application-id="{{ $application->id }}">
                                <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>En attente</option>
                                <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepté</option>
                                <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Refusé</option>
                                <option value="interview" {{ $application->status == 'interview' ? 'selected' : '' }}>Entretien</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contenu principal -->
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Colonne de gauche: Informations sur l'offre -->
                <div class="md:col-span-1">
                    <div class="bg-gray-50 rounded-lg p-4">
                        <h2 class="text-lg font-semibold mb-4">Détails de l'offre</h2>
                        
                        <div class="mb-4">
                            <h3 class="font-medium text-gray-900">{{ $offre->title }}</h3>
                            <p class="text-sm text-gray-600">{{ $offre->location }}</p>
                        </div>
                        
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-700">Compétences requises</h4>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @forelse($offre->skills as $skill)
                                    <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $skill->name }}</span>
                                @empty
                                    <span class="text-sm text-gray-500">Aucune compétence spécifiée</span>
                                @endforelse
                            </div>
                        </div>
                        
                        @if(count($offre->languages) > 0)
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700">Langues requises</h4>
                                <div class="flex flex-wrap gap-2 mt-2">
                                    @foreach($offre->languages as $language)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $language->name }} ({{ $language->pivot->level }})
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        
                        @if($application->match_score)
                            <div class="mt-6">
                                <h4 class="text-sm font-medium text-gray-700">Score de matching</h4>
                                <div class="flex items-center mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $application->match_score }}%"></div>
                                    </div>
                                    <span class="ml-2 text-sm font-medium text-gray-700">{{ $application->match_score }}%</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Colonne de droite: CV et informations du candidat -->
                <div class="md:col-span-2">
                    <div class="mb-6">
                        <h2 class="text-lg font-semibold mb-4">CV du candidat</h2>
                        
                        @if($resume)
                            <!-- Expériences -->
                            <div class="mb-6">
                                <h3 class="text-md font-medium text-gray-900 mb-3">Expériences professionnelles</h3>
                                
                                @if($resume && $resume->experiences)
                                    @forelse($resume->experiences as $experience)
                                        <div class="mb-4 border-l-2 border-gray-200 pl-4">
                                            <div class="flex justify-between">
                                                <h4 class="font-medium">{{ $experience->job_title }}</h4>
                                                <span class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                                                    {{ $experience->end_date ? \Carbon\Carbon::parse($experience->end_date)->format('M Y') : 'Présent' }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $experience->company_name }}</p>
                                            <p class="text-sm mt-2">{{ $experience->description }}</p>
                                        </div>
                                    @empty
                                        <p class="text-gray-500">Aucune expérience professionnelle renseignée</p>
                                    @endforelse
                                @else
                                    <p>Le CV n'est pas disponible.</p>
                                @endif
                            </div>
                            
                            <!-- Formations -->
                            <div class="mb-6">
                                <h3 class="text-md font-medium text-gray-900 mb-3">Formation</h3>
                                
                                @if($resume && $resume->education)
                                    @forelse($resume->education as $edu)
                                        <div class="mb-4 border-l-2 border-gray-200 pl-4">
                                            <div class="flex justify-between">
                                                <h4 class="font-medium">{{ $edu->degree }}</h4>
                                                <span class="text-sm text-gray-500">
                                                    {{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - 
                                                    {{ $edu->end_date ? \Carbon\Carbon::parse($edu->end_date)->format('Y') : 'Présent' }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-600">{{ $edu->institution_name }}</p>
                                            <p class="text-sm text-gray-600 mt-1">{{ $edu->field_of_study }}</p>
                                        </div>
                                    @empty
                                        <p class="text-gray-500">Aucune formation renseignée</p>
                                    @endforelse
                                @else
                                    <p>Le CV n'est pas disponible.</p>
                                @endif
                            </div>
                            
                            <!-- Compétences -->
                            <div class="mb-6">
                                <h3 class="text-md font-medium text-gray-900 mb-3">Compétences</h3>
                                
                                <div class="flex flex-wrap gap-2">
                                    @forelse($resume->skills as $skill)
                                        <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $skill->name }}</span>
                                    @empty
                                        <p class="text-gray-500">Aucune compétence renseignée</p>
                                    @endforelse
                                </div>
                            </div>
                            
                            <!-- Langues -->
                            <div class="mb-6">
                                <h3 class="text-md font-medium text-gray-900 mb-3">Langues</h3>
                                
                                <div class="flex flex-wrap gap-2">
                                    @forelse($resume->languages as $language)
                                        <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded-full">
                                            {{ $language->name }} ({{ $language->pivot->level }})
                                        </span>
                                    @empty
                                        <p class="text-gray-500">Aucune langue renseignée</p>
                                    @endforelse
                                </div>
                            </div>
                        @else
                            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
                                <div class="flex">
                                    <div class="flex-shrink-0">
                                        <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm text-yellow-700">
                                            Ce candidat n'a pas encore créé de CV détaillé.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif
                        
                        <!-- CV téléchargé -->
                        @if($cv && $cv->filePath)
                            <div class="mt-6">
                                <h3 class="text-md font-medium text-gray-900 mb-3">CV téléchargé</h3>
                                
                                <div class="border border-gray-200 rounded-lg p-4 flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="h-8 w-8 text-red-500" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                            <path d="M181.9 256.1c-5-16-4.9-46.9-2-46.9 8.4 0 7.6 36.9 2 46.9zm-1.7 47.2c-7.7 20.2-17.3 43.3-28.4 62.7 18.3-7 39-17.2 62.9-21.9-12.7-9.6-24.9-23.4-34.5-40.8zM86.1 428.1c0 .8 13.2-5.4 34.9-40.2-6.7 6.3-29.1 24.5-34.9 40.2zM248 160h136v328c0 13.3-10.7 24-24 24H24c-13.3 0-24-10.7-24-24V24C0 10.7 10.7 0 24 0h200v136c0 13.2 10.8 24 24 24zm-8 171.8c-20-12.2-33.3-29-42.7-53.8 9.4 6.4 45.7 29.5 54.2 49.1-14.7-1.1-35.7 9.5-67.4-38.6l-30.5 12.1c3.6 1.1 7.2 2.2 10.7 3.2-1.8.2-3.5.4-5.3.5-38.9 6.6-68.8 60.4-70.3 63.2-.9 1.7 2.3 3.5 3.3 2.1 9.1-13.8 17.1-26.7 22.6-35.5 136.1-22.2 147.9-102.5 147.1-123.1L256 388.1c-1.3 13.1 11 21.9 23.5 21.9 15.9 0 28.5-13.6 28.5-30.2.1-16.5-12.2-30.9-28-30.9z"/>
                                        </svg>
                                        <div class="ml-3">
                                            <p class="text-sm font-medium text-gray-900">CV_{{ $application->user->name }}.pdf</p>
                                            <p class="text-xs text-gray-500">PDF • {{ round($cv->file_size / 1024) }} Ko</p>
                                        </div>
                                    </div>
                                    <a href="{{ route('candidatures.cv.show', $cv->id) }}" target="_blank" class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                                        <i class="fas fa-eye mr-2"></i> Voir
                                    </a>
                                </div>
                            </div>
                        @else
                            <h3 class="text-md font-medium text-gray-900 mb-3">Candidat n'a pas de CV</h3>
                        @endif
                    </div>
                    
                    <!-- Actions -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <button id="reject-button" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                            Refuser la candidature
                        </button>
                        <button id="interview-button" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                            Inviter à un entretien
                        </button>
                    </div>
                </div>
            </div>
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

<!-- Modal d'invitation à un entretien -->
<div id="interview-modal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-medium text-gray-900">Inviter à un entretien</h3>
            <button id="close-modal" class="text-gray-400 hover:text-gray-500">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        
        <form id="interview-form">
            <div class="mb-4">
                <label for="interview-date" class="block text-sm font-medium text-gray-700 mb-1">Date de l'entretien</label>
                <input type="date" id="interview-date" name="interview_date" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>
            
            <div class="mb-4">
                <label for="interview-time" class="block text-sm font-medium text-gray-700 mb-1">Heure de l'entretien</label>
                <input type="time" id="interview-time" name="interview_time" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
            </div>
            
            <div class="mb-4">
                <label for="interview-type" class="block text-sm font-medium text-gray-700 mb-1">Type d'entretien</label>
                <select id="interview-type" name="interview_type" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" required>
                    <option value="video">Entretien vidéo</option>
                    <option value="phone">Entretien téléphonique</option>
                    <option value="in_person">Entretien en personne</option>
                </select>
            </div>
            
            <div class="mb-4">
                <label for="interview-notes" class="block text-sm font-medium text-gray-700 mb-1">Notes supplémentaires</label>
                <textarea id="interview-notes" name="interview_notes" rows="3" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"></textarea>
            </div>
            
            <div class="mt-6 flex justify-end space-x-3">
                <button type="button" id="cancel-interview" class="bg-white border border-gray-300 hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Annuler
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                    Envoyer l'invitation
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mise à jour du statut
    const statusSelect = document.getElementById('application-status');
    if (statusSelect) {
        statusSelect.addEventListener('change', function() {
            const applicationId = this.getAttribute('data-application-id');
            const newStatus = this.value;
            const offerId = {{ $offre->id }};
            
            // Mise à jour via AJAX
            fetch(`/recruter/candidatures/${offerId}/application/${applicationId}/status`, {
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
                    // Afficher la notification
                    const notification = document.getElementById('status-notification');
                    notification.classList.remove('translate-y-full', 'opacity-0');
                    
                    // Masquer la notification après 3 secondes
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
    }
    
    // Gestion du modal d'entretien
    const interviewButton = document.getElementById('interview-button');
    const interviewModal = document.getElementById('interview-modal');
    const closeModal = document.getElementById('close-modal');
    const cancelInterview = document.getElementById('cancel-interview');
    const interviewForm = document.getElementById('interview-form');
    
    if (interviewButton && interviewModal) {
        interviewButton.addEventListener('click', function() {
            interviewModal.classList.remove('hidden');
            
            // Mettre à jour le statut à "interview"
            if (statusSelect) {
                statusSelect.value = 'interview';
                statusSelect.dispatchEvent(new Event('change'));
            }
        });
        
        closeModal.addEventListener('click', function() {
            interviewModal.classList.add('hidden');
        });
        
        cancelInterview.addEventListener('click', function() {
            interviewModal.classList.add('hidden');
        });
        
        interviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Ici, vous pouvez ajouter le code pour envoyer l'invitation par email
            // Pour l'instant, nous allons simplement fermer le modal et afficher une notification
            
            interviewModal.classList.add('hidden');
            
            // Afficher la notification
            const notification = document.getElementById('status-notification');
            notification.querySelector('p.font-bold').textContent = 'Invitation envoyée';
            notification.querySelector('p.text-sm').textContent = 'L\'invitation à l\'entretien a été envoyée au candidat.';
            notification.classList.remove('translate-y-full', 'opacity-0');
            
            // Masquer la notification après 3 secondes
            setTimeout(() => {
                notification.classList.add('translate-y-full', 'opacity-0');
            }, 3000);
        });
    }
    
    // Gestion du bouton de rejet
    const rejectButton = document.getElementById('reject-button');
    if (rejectButton && statusSelect) {
        rejectButton.addEventListener('click', function() {
            if (confirm('Êtes-vous sûr de vouloir refuser cette candidature ?')) {
                statusSelect.value = 'rejected';
                statusSelect.dispatchEvent(new Event('change'));
            }
        });
    }
});
</script>
@endsection
