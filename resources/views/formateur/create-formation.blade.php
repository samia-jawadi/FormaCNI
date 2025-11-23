@extends('layouts.formateur')

@section('title', 'Créer une Formation')
@section('page-title', 'Créer une Nouvelle Formation')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Créer une Nouvelle Formation</h2>
            <p class="text-gray-600">Remplissez les informations ci-dessous pour créer votre formation. Elle sera soumise pour validation par l'administration.</p>
        </div>

        <form action="{{ route('formateur.formations.store') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- Titre de la formation -->
            <div>
                <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre de la formation <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="titre" 
                       name="titre" 
                       value="{{ old('titre') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('titre') border-red-500 @enderror"
                       placeholder="Ex: Introduction à Laravel"
                       required>
                @error('titre')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Description <span class="text-red-500">*</span>
                </label>
                <textarea id="description" 
                          name="description" 
                          rows="5"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror"
                          placeholder="Décrivez le contenu, les objectifs et les prérequis de votre formation..."
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Durée et Capacité -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="duree" class="block text-sm font-medium text-gray-700 mb-2">
                        Durée (en heures) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="duree" 
                           name="duree" 
                           value="{{ old('duree') }}"
                           min="1" 
                           max="200"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('duree') border-red-500 @enderror"
                           placeholder="Ex: 20"
                           required>
                    @error('duree')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="capacite_max" class="block text-sm font-medium text-gray-700 mb-2">
                        Capacité maximale <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="capacite_max" 
                           name="capacite_max" 
                           value="{{ old('capacite_max') }}"
                           min="1" 
                           max="100"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('capacite_max') border-red-500 @enderror"
                           placeholder="Ex: 25"
                           required>
                    @error('capacite_max')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Dates -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de début <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="date_debut" 
                           name="date_debut" 
                           value="{{ old('date_debut') }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_debut') border-red-500 @enderror"
                           required>
                    @error('date_debut')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-700 mb-2">
                        Date de fin <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="date_fin" 
                           name="date_fin" 
                           value="{{ old('date_fin') }}"
                           min="{{ date('Y-m-d') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date_fin') border-red-500 @enderror"
                           required>
                    @error('date_fin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Heure de début -->
            <div>
                <label for="heure_debut" class="block text-sm font-medium text-gray-700 mb-2">
                    Heure de début <span class="text-red-500">*</span>
                </label>
                <input type="time" 
                       id="heure_debut" 
                       name="heure_debut" 
                       value="{{ old('heure_debut') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('heure_debut') border-red-500 @enderror"
                       required>
                @error('heure_debut')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Information sur le processus -->
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800">Processus de validation</h3>
                        <div class="mt-2 text-sm text-blue-700">
                            <p>Votre formation sera soumise pour validation par l'administration. Vous recevrez une notification une fois qu'elle sera approuvée ou si des modifications sont nécessaires.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Boutons d'action -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('formateur.formations.index') }}" 
                   class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Annuler
                </a>
                
                <button type="submit" 
                        class="px-8 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Créer la Formation
                </button>
            </div>
        </form>
    </div>
</div>

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-update end date when start date changes
    const dateDebut = document.getElementById('date_debut');
    const dateFin = document.getElementById('date_fin');
    
    dateDebut.addEventListener('change', function() {
        if (this.value) {
            dateFin.min = this.value;
            if (dateFin.value && dateFin.value < this.value) {
                dateFin.value = this.value;
            }
        }
    });
    
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const startDate = new Date(dateDebut.value);
        const endDate = new Date(dateFin.value);
        
        if (endDate < startDate) {
            e.preventDefault();
            alert('La date de fin doit être postérieure à la date de début.');
            return false;
        }
        
        // Show loading state
        const submitBtn = form.querySelector('button[type="submit"]');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Création en cours...';
    });
});
</script>
@endsection
@endsection