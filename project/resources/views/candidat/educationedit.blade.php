@extends('layouts.candidat')

@section('title', 'Modifier une formation')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-semibold mb-6">Modifier une formation</h1>

    <form action="{{ route('resumes.education.update', [$resume->id ,$education->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="institution_name" class="block text-gray-700 text-sm font-bold mb-2">Nom de l'établissement</label>
            <input type="text" id="institution_name" name="institution_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $education->institution_name }}" required>
        </div>

        <div class="mb-4">
            <label for="degree" class="block text-gray-700 text-sm font-bold mb-2">Diplôme</label>
            <input type="text" id="degree" name="degree" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $education->degree }}" required>
        </div>

        <div class="mb-4">
            <label for="field_of_study" class="block text-gray-700 text-sm font-bold mb-2">Domaine d'études</label>
            <input type="text" id="field_of_study" name="field_of_study" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $education->field_of_study }}" required>
        </div>

        <div class="mb-4">
            <label for="start_date" class="block text-gray-700 text-sm font-bold mb-2">Date de début</label>
            <input type="date" id="start_date" name="start_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $education->start_date }}" required>
        </div>

        <div class="mb-4">
            <label for="end_date" class="block text-gray-700 text-sm font-bold mb-2">Date de fin (ou prévue)</label>
            <input type="date" id="end_date" name="end_date" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $education->end_date }}">
        </div>

        <div class="flex items-center justify-between">
            <a href="{{ route('resume.view') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Annuler
            </a>
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Mettre à jour
            </button>
        </div>
    </form>
</div>
@endsection