@extends('admin.dashboard')

@section('title', 'Modifier Formation - FormaCNI')
@section('page-title', 'Modifier Formation')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.formations.index') }}" 
           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center space-x-2 transition-colors">
            <i class="fas fa-arrow-left"></i>
            <span>Retour aux formations</span>
        </a>
        <div class="h-6 border-l border-gray-300 dark:border-gray-600"></div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Modifier Formation</h2>
            <p class="text-gray-700 dark:text-gray-300">Modifiez les détails de la formation</p>
        </div>
    </div>
</div>

<!-- Formation Details Card -->
<div class="card p-6 mb-6">
    <div class="flex items-center space-x-4 mb-6 p-4 bg-gray-50 dark:bg-gray-800 rounded-lg">
        <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
            <i class="fas fa-book text-white"></i>
        </div>
        <div>
            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $formation->titre }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Par {{ $formation->formateur->nom }} • 
                Créée {{ $formation->created_at->locale('fr')->diffForHumans() }}
            </p>
        </div>
        <div class="ml-auto">
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                @if($formation->statut === 'ACTIVE') bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-300
                @elseif($formation->statut === 'ATTENTE_VALIDATION') bg-orange-100 text-orange-800 dark:bg-orange-900/20 dark:text-orange-300
                @else bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300
                @endif">
                @switch($formation->statut)
                    @case('ACTIVE')
                        Active
                        @break
                    @case('ATTENTE_VALIDATION')
                        En attente
                        @break
                    @default
                        {{ $formation->statut }}
                @endswitch
            </span>
        </div>
    </div>

    <!-- Edit Form -->
    <form action="{{ route('admin.formations.update', $formation) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Left Column -->
            <div class="space-y-6">
                <!-- Titre -->
                <div>
                    <label for="titre" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                        Titre de la formation <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           id="titre" 
                           name="titre" 
                           value="{{ old('titre', $formation->titre) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    @error('titre')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" 
                              name="description" 
                              rows="4" 
                              required
                              class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white"
                              placeholder="Décrivez le contenu et les objectifs de la formation...">{{ old('description', $formation->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Durée -->
                <div>
                    <label for="duree" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                        Durée (heures) <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="duree" 
                           name="duree" 
                           value="{{ old('duree', $formation->duree) }}"
                           min="1" 
                           required
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    @error('duree')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Capacité -->
                <div>
                    <label for="capacite_max" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                        Capacité maximale <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           id="capacite_max" 
                           name="capacite_max" 
                           value="{{ old('capacite_max', $formation->capacite_max) }}"
                           min="1" 
                           max="100"
                           required
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    @error('capacite_max')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Right Column -->
            <div class="space-y-6">
                <!-- Date de début -->
                <div>
                    <label for="date_debut" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                        Date de début <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="date_debut" 
                           name="date_debut" 
                           value="{{ old('date_debut', $formation->date_debut->format('Y-m-d')) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    @error('date_debut')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Date de fin -->
                <div>
                    <label for="date_fin" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                        Date de fin <span class="text-red-500">*</span>
                    </label>
                    <input type="date" 
                           id="date_fin" 
                           name="date_fin" 
                           value="{{ old('date_fin', $formation->date_fin->format('Y-m-d')) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    @error('date_fin')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Heure de début -->
                <div>
                    <label for="heure_debut" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                        Heure de début <span class="text-red-500">*</span>
                    </label>
                    <input type="time" 
                           id="heure_debut" 
                           name="heure_debut" 
                           value="{{ old('heure_debut', $formation->heure_debut) }}"
                           required
                           class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                    @error('heure_debut')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Statut -->
                <div>
                    <label for="statut" class="block text-sm font-medium text-gray-800 dark:text-gray-300 mb-2">
                        Statut <span class="text-red-500">*</span>
                    </label>
                    <select id="statut" 
                            name="statut" 
                            required
                            class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent dark:bg-gray-700 dark:text-white">
                        <option value="ATTENTE_VALIDATION" {{ old('statut', $formation->statut) === 'ATTENTE_VALIDATION' ? 'selected' : '' }}>
                            En attente de validation
                        </option>
                        <option value="ACTIVE" {{ old('statut', $formation->statut) === 'ACTIVE' ? 'selected' : '' }}>
                            Active
                        </option>
                    </select>
                    @error('statut')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
            <div class="text-sm text-gray-600 dark:text-gray-400">
                <span class="text-red-500">*</span> Champs obligatoires
            </div>
            
            <div class="flex space-x-4">
                <a href="{{ route('admin.formations.index') }}" 
                   class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-800 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                    Annuler
                </a>
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center space-x-2">
                    <i class="fas fa-save"></i>
                    <span>Enregistrer les modifications</span>
                </button>
            </div>
        </div>
    </form>
</div>

<!-- Formation Stats -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Inscriptions -->
    <div class="card p-6">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center">
                <i class="fas fa-users text-white"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">Inscriptions</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Participants inscrits</p>
            </div>
        </div>
        <div class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
            {{ $formation->confirmed_inscriptions_count ?? 0 }}/{{ $formation->capacite_max }}
        </div>
        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
            <div class="bg-blue-500 h-2 rounded-full" 
                 style="width: {{ $formation->capacite_max > 0 ? (($formation->confirmed_inscriptions_count ?? 0) / $formation->capacite_max) * 100 : 0 }}%">
            </div>
        </div>
    </div>

    <!-- Formateur -->
    <div class="card p-6">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center">
                <i class="fas fa-chalkboard-teacher text-white"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">Formateur</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Responsable de la formation</p>
            </div>
        </div>
        <div class="space-y-2">
            <p class="font-medium text-gray-900 dark:text-white">{{ $formation->formateur->nom }}</p>
            <p class="text-sm text-gray-600 dark:text-gray-400">{{ $formation->formateur->email }}</p>
            @if($formation->formateur->specialite)
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $formation->formateur->specialite }}</p>
            @endif
        </div>
    </div>

    <!-- Dates importantes -->
    <div class="card p-6">
        <div class="flex items-center space-x-3 mb-4">
            <div class="w-10 h-10 bg-purple-500 rounded-full flex items-center justify-center">
                <i class="fas fa-calendar-alt text-white"></i>
            </div>
            <div>
                <h3 class="font-semibold text-gray-900 dark:text-white">Dates importantes</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Planning de la formation</p>
            </div>
        </div>
        <div class="space-y-3 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Début:</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $formation->date_debut->format('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Fin:</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $formation->date_fin->format('d/m/Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Heure:</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $formation->heure_debut_formattee }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600 dark:text-gray-400">Durée:</span>
                <span class="font-medium text-gray-900 dark:text-white">{{ $formation->duree }}h</span>
            </div>
        </div>
    </div>
</div>
@endsection