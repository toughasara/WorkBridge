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
                    <span class="mr-3"><i class="far fa-clock mr-1"></i> {{ $offer->job_type }}</span>
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

    <div class="flex flex-wrap gap-2 mb-6">
        @foreach($offer->skills as $skill)
            <span class="badge-skill">{{ $skill->name }}</span>
        @endforeach
    </div>

    <div class="mb-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-3">Description du poste</h2>
        <div class="prose max-w-none text-gray-700">
            {!! $offer->description !!}
        </div>
    </div>

    <div class="border-t pt-6 mt-6">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-gray-500 text-sm">Soyez parmi les premiers à postuler</p>
            </div>
                <form method="POST" action="{{ route('candidat.offres.postuler', $offer->id) }}">
                    @csrf
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-paper-plane mr-2"></i> Postuler maintenant
                    </button>
                </form>
        </div>
    </div>
</div>