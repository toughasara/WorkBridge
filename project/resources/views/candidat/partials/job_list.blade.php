@if(count($jobs) > 0)
    @foreach($jobs as $job)
    <div class="job-card bg-white rounded-lg border p-4 mb-4 {{ request('job_id') == $job->id ? 'active' : '' }}" 
        data-job-id="{{ $job->id }}">                               
        <div class="flex items-start">
            <div class="company-logo mr-4">
                @if($job->company)
                    <div class="company-logo-placeholder">{{ substr($job->company->name, 0, 1) }}</div>
                @else
                    <div class="company-logo-placeholder">E</div>
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
        </div>
        <div class="mt-3">
            <div class="flex justify-between items-center mb-1">
                <span class="text-xs font-medium text-indigo-700">Score de matching</span>
                <span class="text-xs font-medium text-indigo-700">{{ $job->match_score }}%</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-indigo-600 h-2.5 rounded-full" style="width: {{ $job->match_score }}%"></div>
            </div>
        </div>
        <div class="text-gray-500 text-xs mt-2">
            {{ $job->created_at->diffForHumans() }}
        </div>
    </div>
    @endforeach
@else
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-search"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900">Aucune offre trouvée</h3>
        <p class="text-gray-500 mt-1">Essayez de modifier vos critères de recherche</p>
    </div>
@endif