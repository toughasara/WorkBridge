@extends('layouts.candidat')

@section('content')
<div class="max-w-3xl mx-auto py-6 px-4 bg-white shadow-md rounded-lg">
    <div class="mb-6">
        <a href="{{ route('profil.candidat') }}" class="inline-flex items-center text-gray-700 hover:text-gray-900 font-medium">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            <span>Retour</span>
        </a>
    </div>

    <!-- Informations personnelles -->
    <div class="mb-8 border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-start">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $resume->user->name }}</h1>
                <div class="mt-3 text-gray-600 space-y-2">
                    <p>{{ $resume->phone }}</p>
                    <p>{{ $resume->user->email }}</p>
                    <p>{{ $resume->ville }}, {{ $resume->pays }}</p>
                    <p>Né(e) le {{ \Carbon\Carbon::parse($resume->birthDate)->format('d/m/Y') }}</p>
                    <p>
                        @if($resume->relocation_possible)
                            Déménagement possible n'importe où
                        @else
                            Pas de déménagement possible
                        @endif
                    </p>
                </div>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('resume.update', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Modifier">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </a>
                <form action="{{ route('resume.delete', $resume->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer votre CV?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Récapitulatif -->
    <div class="mb-8 border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Récapitulatif</h2>
            <a href="#" class="text-blue-800 hover:text-blue-600" title="Ajouter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>
        <div class="text-gray-600">
            @if(isset($resume->summary) && !empty($resume->summary))
                <p>{{ $resume->summary }}</p>
            @else
                <p class="text-gray-500 italic">Votre récapitulatif apparaîtra ici.</p>
            @endif
        </div>
    </div>

    <!-- Expérience professionnelle -->
    <div class="mb-8 border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Expérience professionnelle</h2>
            <a href="{{ route('experience.create', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Ajouter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>  stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>

        @if(count($resume->experiences) > 0)
            <div class="space-y-4">
                @foreach($resume->experiences as $experience)
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 relative">
                        <div class="absolute right-3 top-3 flex space-x-3">
                            <a href="{{ route('experience.update', $experience->id) }}" class="text-blue-800 hover:text-blue-600" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('experience.delete', $experience->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette expérience?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="pr-16">
                            <h3 class="font-semibold text-lg text-gray-800">{{ $experience->job_title }}</h3>
                            <p class="text-gray-600">{{ $experience->company_name }}</p>
                            <p class="text-gray-500 text-sm">
                                {{ \Carbon\Carbon::parse($experience->start_date)->format('M Y') }} - 
                                @if($experience->end_date)
                                    {{ \Carbon\Carbon::parse($experience->end_date)->format('M Y') }}
                                @else
                                    Actuellement
                                @endif
                            </p>
                            @if($experience->description)
                                <p class="mt-2 text-gray-700">{{ $experience->description }}</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500 bg-white rounded-lg shadow-sm border border-gray-200">
                <p>Aucune expérience professionnelle ajoutée</p>
            </div>
        @endif
    </div>

    <!-- Éducation -->
    <div class="mb-8 border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Éducation</h2>
            <a href="{{ route('education.create', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Ajouter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>

        @if(count($resume->education) > 0)
            <div class="space-y-4">
                @foreach($resume->education as $edu)
                    <div class="bg-white rounded-lg p-4 shadow-sm border border-gray-200 relative">
                        <div class="absolute right-3 top-3 flex space-x-3">
                            <a href="{{ route('education.update', $edu->id) }}" class="text-blue-800 hover:text-blue-600" title="Modifier">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                            </a>
                            <form action="{{ route('education.delete', $edu->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette formation?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <div class="pr-16">
                            <h3 class="font-semibold text-lg text-gray-800">{{ $edu->degree }} en {{ $edu->field_of_study }}</h3>
                            <p class="text-gray-600">{{ $edu->institution_name }}</p>
                            <p class="text-gray-500 text-sm">
                                {{ \Carbon\Carbon::parse($edu->start_date)->format('Y') }} - 
                                {{ \Carbon\Carbon::parse($edu->end_date)->format('Y') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500 bg-white rounded-lg shadow-sm border border-gray-200">
                <p>Aucune formation ajoutée</p>
            </div>
        @endif
    </div>

    <!-- Compétences -->
    <div class="mb-8 border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Compétences</h2>
            <a href="{{ route('skill.create', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Ajouter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>

        @if(count($resume->skills) > 0)
            <div class="flex flex-wrap gap-2">
                @foreach($resume->skills as $skill)
                    <div class="bg-white rounded-full px-4 py-2 shadow-sm border border-gray-200 flex items-center">
                        <span class="text-gray-700">{{ $skill->name }}</span>
                        <form action="{{ route('skill.delete', ['resume' => $resume->id, 'skill' => $skill->id]) }}" method="POST" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500 bg-white rounded-lg shadow-sm border border-gray-200">
                <p>Aucune compétence ajoutée</p>
            </div>
        @endif
    </div>

    <!-- Langues -->
    <div class="border border-gray-200 rounded-lg p-6 bg-gray-50">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-xl font-semibold text-gray-800">Langues</h2>
            <a href="{{ route('language.create', $resume->id) }}" class="text-blue-800 hover:text-blue-600" title="Ajouter">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
            </a>
        </div>

        @if(count($resume->languages) > 0)
            <div class="flex flex-wrap gap-2">
                @foreach($resume->languages as $language)
                    <div class="bg-white rounded-full px-4 py-2 shadow-sm border border-gray-200 flex items-center">
                        <span class="text-gray-700">{{ $language->name }}</span>
                        <form action="{{ route('language.delete', ['resume' => $resume->id, 'language' => $language->id]) }}" method="POST" class="ml-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-blue-800 hover:text-blue-600" title="Supprimer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-6 text-gray-500 bg-white rounded-lg shadow-sm border border-gray-200">
                <p>Aucune langue ajoutée</p>
            </div>
        @endif
    </div>
</div>
@endsection

