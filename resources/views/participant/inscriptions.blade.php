@extends('layouts.participant')

@section('title', 'Mes Inscriptions - FormaCNI')

@section('page-title', 'Mes Inscriptions')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Mes Inscriptions</h2>
            <p class="text-gray-600 dark:text-gray-400">Gérez toutes vos inscriptions aux formations</p>
        </div>
        <div class="flex items-center space-x-4">
            <select id="filter-status" class="input-field px-4 py-2 rounded-lg">
                <option value="">Tous les statuts</option>
                <option value="CONFIRMEE">Confirmées</option>
                <option value="EN_ATTENTE">En attente</option>
                <option value="REFUSEE">Refusées</option>
            </select>
            <a href="{{ route('formations.index') }}" class="btn-primary px-6 py-2 rounded-lg inline-flex items-center">
                <i class="fas fa-plus mr-2"></i>
                Nouvelle Inscription
            </a>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 mr-4">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Confirmées</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ Auth::user()->inscriptions()->where('statut', 'CONFIRMEE')->count() }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 mr-4">
                <i class="fas fa-clock text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">En Attente</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ Auth::user()->inscriptions()->where('statut', 'EN_ATTENTE')->count() }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                <i class="fas fa-times-circle text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Refusées</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ Auth::user()->inscriptions()->where('statut', 'REFUSEE')->count() }}
                </p>
            </div>
        </div>
    </div>
    
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <i class="fas fa-star text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Terminées</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ Auth::user()->inscriptions()->whereHas('formation', function($q) { $q->where('terminee', true); })->count() }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Inscriptions List -->
<div class="card">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            <i class="fas fa-list mr-2"></i>Toutes mes Inscriptions
        </h3>
    </div>
    <div class="p-6">
        <div class="space-y-4" id="inscriptions-list">
            @forelse(Auth::user()->inscriptions()->with('formation.formateur')->orderBy('created_at', 'desc')->get() as $inscription)
            <div class="inscription-card bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors border border-gray-200 dark:border-gray-700" 
                 data-status="{{ strtolower($inscription->statut) }}">
                
                <div class="flex justify-between items-start mb-4">
                    <!-- Formation Info -->
                    <div class="flex-1">
                        <div class="flex items-center space-x-4 mb-3">
                            <div class="w-12 h-12 bg-gradient-to-r from-blue-500 to-emerald-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-book text-white"></i>
                            </div>
                            <div>
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    {{ $inscription->formation->titre }}
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400">
                                    Par {{ $inscription->formation->formateur->nom }}
                                </p>
                            </div>
                        </div>
                        
                        <!-- Formation Details Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>{{ $inscription->formation->date_formatee }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ $inscription->formation->duree_formatee }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-calendar-plus mr-2"></i>
                                <span>Inscrit le {{ $inscription->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        
                        <!-- Description -->
                        <p class="text-gray-600 dark:text-gray-400 mb-4">
                            {{ Str::limit($inscription->formation->description, 150) }}
                        </p>
                    </div>
                    
                    <!-- Status and Actions -->
                    <div class="ml-6 flex flex-col items-end space-y-3">
                        <!-- Status Badge -->
                        <div>
                            @if($inscription->statut === 'CONFIRMEE')
                                <span class="badge badge-success">
                                    <i class="fas fa-check-circle mr-1"></i>Confirmée
                                </span>
                            @elseif($inscription->statut === 'EN_ATTENTE')
                                <span class="badge badge-warning">
                                    <i class="fas fa-clock mr-1"></i>En attente
                                </span>
                            @elseif($inscription->statut === 'REFUSEE')
                                <span class="badge badge-danger">
                                    <i class="fas fa-times-circle mr-1"></i>Refusée
                                </span>
                            @endif
                        </div>
                        
                        <!-- Formation Status -->
                        @if($inscription->formation->terminee)
                            <span class="badge bg-purple-100 text-purple-800">
                                <i class="fas fa-flag-checkered mr-1"></i>Terminée
                            </span>
                        @elseif($inscription->formation->statut === 'ACTIVE')
                            <span class="badge bg-blue-100 text-blue-800">
                                <i class="fas fa-play-circle mr-1"></i>Active
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Progress Bar for Active Formations -->
                @if($inscription->formation->statut === 'ACTIVE' && !$inscription->formation->terminee)
                <div class="mb-4">
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                        <span>Participants inscrits</span>
                        <span>{{ $inscription->formation->getNombreInscriptions() }}/{{ $inscription->formation->capacite_max }}</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                        <div class="bg-gradient-to-r from-blue-500 to-emerald-500 h-2 rounded-full transition-all duration-300" 
                             style="width: {{ $inscription->formation->progression }}%"></div>
                    </div>
                </div>
                @endif
                
                <!-- Action Buttons -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('formations.show', $inscription->formation) }}" 
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            <i class="fas fa-eye mr-1"></i>Voir détails
                        </a>
                        
                        @if($inscription->statut === 'CONFIRMEE' && $inscription->formation->statut === 'ACTIVE')
                            <span class="text-emerald-600 font-medium">
                                <i class="fas fa-graduation-cap mr-1"></i>Inscription validée
                            </span>
                        @endif
                    </div>
                    
                    <!-- Contextual Actions -->
                    <div class="flex items-center space-x-2">
                        @if($inscription->statut === 'EN_ATTENTE')
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                <i class="fas fa-hourglass-half mr-1"></i>En cours de validation
                            </span>
                        @elseif($inscription->statut === 'REFUSEE')
                            <button onclick="showRefusalReason('{{ $inscription->id }}')" 
                                    class="text-red-600 hover:text-red-800 text-sm">
                                <i class="fas fa-info-circle mr-1"></i>Voir la raison
                            </button>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-clipboard-list text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune inscription</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Vous n'avez pas encore d'inscription aux formations</p>
                <a href="{{ route('formations.index') }}" class="btn-primary px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-search mr-2"></i>
                    Découvrir les formations
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Timeline View (Optional) -->
@if(Auth::user()->inscriptions()->count() > 0)
<div class="card mt-8">
    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
            <i class="fas fa-history mr-2"></i>Chronologie des Inscriptions
        </h3>
    </div>
    <div class="p-6">
        <div class="relative">
            <div class="absolute left-4 top-0 bottom-0 w-0.5 bg-gray-200 dark:bg-gray-700"></div>
            
            @foreach(Auth::user()->inscriptions()->with('formation')->orderBy('created_at', 'desc')->take(5)->get() as $inscription)
            <div class="relative flex items-start space-x-4 pb-8">
                <div class="relative z-10 w-8 h-8 bg-gradient-to-r from-blue-500 to-emerald-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-plus text-white text-xs"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center space-x-2 mb-1">
                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                            Inscription à {{ $inscription->formation->titre }}
                        </h4>
                        <span class="badge {{ $inscription->statut === 'CONFIRMEE' ? 'badge-success' : ($inscription->statut === 'EN_ATTENTE' ? 'badge-warning' : 'badge-danger') }}">
                            {{ $inscription->statut }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">
                        {{ $inscription->created_at->format('d/m/Y à H:i') }}
                    </p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif
@endsection

@section('scripts')
<script>
    // Filter functionality
    document.getElementById('filter-status').addEventListener('change', function() {
        const statusFilter = this.value.toLowerCase();
        const cards = document.querySelectorAll('.inscription-card');
        
        cards.forEach(card => {
            if (!statusFilter || card.dataset.status === statusFilter) {
                card.style.display = 'block';
                card.classList.remove('hidden');
            } else {
                card.style.display = 'none';
                card.classList.add('hidden');
            }
        });
    });
    
    // Show refusal reason (placeholder function)
    function showRefusalReason(inscriptionId) {
        // This would typically show a modal with the refusal reason
        alert('Fonctionnalité à implémenter: afficher la raison du refus pour l\'inscription ' + inscriptionId);
    }
</script>
@endsection