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
                </div>
            </div>
        </div>
    </div>
@endsection
