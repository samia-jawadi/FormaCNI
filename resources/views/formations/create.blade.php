@extends('layouts.formateur')

@section('title', 'Créer une Formation')
@section('page-title', 'Créer une nouvelle formation')

@section('content')
<div class="card p-6 rounded-xl max-w-3xl">
    @if($errors->any())
        <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
            <ul class="list-disc list-inside text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('formateur.formations.store') }}" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-2">Titre <span class="text-red-500">*</span></label>
            <input type="text" name="titre" value="{{ old('titre') }}" required
                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Titre de la formation">
        </div>

        <div>
            <label class="block text-sm font-medium mb-2">Description <span class="text-red-500">*</span></label>
            <textarea name="description" rows="5" required
                      class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Décrivez la formation...">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Durée (semaines) <span class="text-red-500">*</span></label>
                <input type="number" name="duree" value="{{ old('duree') }}" min="1" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="6">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Date de début <span class="text-red-500">*</span></label>
                <input type="date" name="date_debut" value="{{ old('date_debut') }}" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Date de fin <span class="text-red-500">*</span></label>
                <input type="date" name="date_fin" value="{{ old('date_fin') }}" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-2">Heure de début <span class="text-red-500">*</span></label>
                <input type="time" name="heure_debut" value="{{ old('heure_debut') }}" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
            <div>
                <label class="block text-sm font-medium mb-2">Capacité maximale <span class="text-red-500">*</span></label>
                <input type="number" name="capacite_max" value="{{ old('capacite_max') }}" min="1" required
                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="20">
            </div>
        </div>

        <div class="flex items-center justify-end space-x-3 pt-2">
            <a href="{{ route('formateur.formations.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800">Annuler</a>
            <button type="submit" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">Créer la formation</button>
        </div>
    </form>
</div>
@endsection