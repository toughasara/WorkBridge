<div class="job-details p-6">
    <div class="flex items-start justify-between mb-6">
        <div class="flex items-start">
            <div class="company-logo mr-4">
                @if($offer->company->name)
                    <div class="company-logo-placeholder">{{ substr($offer->company->name, 0, 1) }}</div>
                @else
                    <div class="company-logo-placeholder">Ent</div>
                @endif
            </div>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">{{ $offer->title }}</h1>
                @if($offer->company->name)
                    <p class="text-gray-600">{{ $offer->company->name }} • {{ $offer->location }}</p>
                @else
                    <p class="text-gray-600">Entreprise non spécifiée • {{ $offer->location }}</p>                
                @endif
                <div class="flex items-center text-gray-500 text-sm mt-1">
                    <span class="mr-3"><i class="far fa-clock mr-1"></i> {{ $offer->mode_travail }}</span>
                    <span><i class="far fa-calendar-alt mr-1"></i> Publié {{ $offer->created_at->diffForHumans() }}</span>
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

    <div class="px-6 py-4">
        <div class="flex flex-wrap gap-2 mb-6">
            @foreach($offer->skills as $skill)
                <span class="bg-sky-100 text-sky-800 text-xs font-medium px-2.5 py-0.5 rounded-full">{{ $skill->name }}</span>
            @endforeach
        </div>
    </div>

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Description du poste</h2>
        <div class="prose max-w-none text-gray-700">
            {!! $offer->description !!}
        </div>
    </div>

    <div class="mb-6">
        <div class="flex flex-wrap gap-2">
            @if(count($offer->languages) > 0)
                @foreach($offer->languages as $language)
                    <span class="inline-flex items-center rounded-full bg-green-100 text-green-800 text-xs px-2 py-1">
                        {{ $language->name }} ({{ $language->pivot->level }})
                    </span>
                @endforeach
            @else
                <p class="text-gray-500">Aucune langue spécifique requise.</p>
            @endif
        </div>
    </div>

    <div class="border-t pt-6 mt-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm">Soyez parmi les premiers à postuler</p>
            </div>
            <button id="apply-button" data-offer-id="{{ $offer->id }}" class="bg-blue-700 hover:bg-blue-800 text-white font-medium py-2 px-4 rounded-md transition duration-150 ease-in-out">
                <i class="fas fa-paper-plane mr-2"></i> Postuler maintenant
            </button>
        </div>
    </div>

    <!-- Message de notification -->
    <div id="notification-message" class="mt-4 p-4 rounded-md hidden">
        <p id="notification-text"></p>
    </div>
    
</div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const applyButton = document.getElementById('apply-button');
    const notificationMessage = document.getElementById('notification-message');
    const notificationText = document.getElementById('notification-text');
    
    applyButton.addEventListener('click', function() {
        const offerId = this.getAttribute('data-offer-id');
        
        // Désactiver le bouton pendant la requête
        applyButton.disabled = true;
        applyButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Traitement...';
        
        // Envoyer la requête AJAX
        fetch(`/candidat/offres/${offerId}/postuler`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Réactiver le bouton
            applyButton.disabled = false;
            applyButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Postuler maintenant';
            
            // Afficher le message de notification
            notificationMessage.classList.remove('hidden');
            
            if (data.success) {
                // Message de succès
                notificationMessage.classList.add('bg-green-100', 'text-green-800');
                notificationMessage.classList.remove('bg-red-100', 'text-red-800');
                notificationText.textContent = data.message;
                
                // Désactiver le bouton définitivement
                applyButton.disabled = true;
                applyButton.innerHTML = '<i class="fas fa-check mr-2"></i> Candidature envoyée';
                applyButton.classList.remove('bg-blue-700', 'hover:bg-blue-800');
                applyButton.classList.add('bg-green-700');
                
                // Masquer le message après 3 secondes
                setTimeout(() => {
                    notificationMessage.classList.add('hidden');
                }, 3000);
            } else {
                // Message d'erreur
                notificationMessage.classList.add('bg-red-100', 'text-red-800');
                notificationMessage.classList.remove('bg-green-100', 'text-green-800');
                notificationText.textContent = data.message;
                
                // Si une redirection est nécessaire (pour compléter le profil)
                if (data.redirect) {
                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2000);
                }
            }
        })
        .catch(error => {
            console.error('Erreur:', error);
            
            // Réactiver le bouton
            applyButton.disabled = false;
            applyButton.innerHTML = '<i class="fas fa-paper-plane mr-2"></i> Postuler maintenant';
            
            // Afficher un message d'erreur
            notificationMessage.classList.remove('hidden');
            notificationMessage.classList.add('bg-red-100', 'text-red-800');
            notificationMessage.classList.remove('bg-green-100', 'text-green-800');
            notificationText.textContent = 'Une erreur est survenue. Veuillez réessayer.';
        });
    });
});
</script>