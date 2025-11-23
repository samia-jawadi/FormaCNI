@extends('layouts.formateur')

@section('title', 'Modifier la Formation')
@section('page-title', 'Modifier la Formation')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Modifier la Formation</h2>
            <p class="text-gray-600">Modifiez les informations de votre formation. Les modifications seront soumises pour validation si nécessaire.</p>
        </div>

        <form action="{{ route('formateur.formations.update', $formation) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            
            <!-- Titre de la formation -->
            <div>
                <label for="titre" class="block text-sm font-medium text-gray-700 mb-2">
                    Titre de la formation <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       id="titre" 
                       name="titre" 
                       value="{{ old('titre', $formation->titre) }}"
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
                          required>{{ old('description', $formation->description) }}</textarea>
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
                           value="{{ old('duree', $formation->duree) }}"
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
                           value="{{ old('capacite_max', $formation->capacite_max) }}"
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
                           value="{{ old('date_debut', $formation->date_debut->format('Y-m-d')) }}"
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
                           value="{{ old('date_fin', $formation->date_fin->format('Y-m-d')) }}"
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
                       value="{{ old('heure_debut', $formation->heure_debut) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('heure_debut') border-red-500 @enderror"
                       required>
                @error('heure_debut')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Statut actuel -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-gray-600 mt-1"></i>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-gray-800">Statut actuel</h3>
                        <div class="mt-2 text-sm text-gray-700">
                            <p>
                                Statut: 
                                <span class="px-2 py-1 rounded-full text-xs font-medium 
                                    {{ $formation->statut === 'ACTIVE' ? 'bg-green-100 text-green-800' : 
                                       ($formation->statut === 'ATTENTE_VALIDATION' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $formation->statut === 'ACTIVE' ? 'Approuvée' : 
                                       ($formation->statut === 'ATTENTE_VALIDATION' ? 'En attente de validation' : 'Refusée') }}
                                </span>
                            </p>
                            @if($formation->inscriptions()->count() > 0)
                                <p class="mt-1">
                                    <i class="fas fa-users mr-1"></i>
                                    {{ $formation->inscriptions()->count() }} participant(s) inscrit(s)
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Information sur les modifications -->
            @if($formation->statut === 'ACTIVE' && $formation->inscriptions()->count() > 0)
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-yellow-800">Attention</h3>
                            <div class="mt-2 text-sm text-yellow-700">
                                <p>Cette formation a des participants inscrits. Les modifications importantes peuvent nécessiter une nouvelle validation.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <i class="fas fa-info-circle text-blue-600 mt-1"></i>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Processus de validation</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <p>Vos modifications seront soumises pour validation par l'administration si nécessaire.</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

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
                    Enregistrer les Modifications
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
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Enregistrement en cours...';
    });
});
</script>
@endsection
@endsection