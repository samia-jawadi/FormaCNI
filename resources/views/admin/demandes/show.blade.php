@extends('admin.dashboard')

@section('title', 'Détails de la Demande - FormaCNI')
@section('page-title', 'Détails de la Demande')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.demandes.index') }}" 
           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center space-x-2 transition-colors">
            <i class="fas fa-arrow-left"></i>
            <span>Retour aux demandes</span>
        </a>
        <div class="h-6 border-l border-gray-300"></div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">{{ $demande->titre }}</h2>
    </div>
    <div>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
            @if($demande->statut === 'EN_ATTENTE') bg-orange-100 text-orange-800
            @elseif($demande->statut === 'ACCEPTEE') bg-green-100 text-green-800
            @elseif($demande->statut === 'REFUSEE') bg-red-100 text-red-800
            @endif">
            @switch($demande->statut)
                @case('EN_ATTENTE')
                    En attente
                    @break
                @case('ACCEPTEE')
                    Acceptée
                    @break
                @case('REFUSEE')
                    Refusée
                    @break
                @default
                    {{ $demande->statut }}
            @endswitch
        </span>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Description de la demande -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Description de la demande</h3>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $demande->description }}</p>
            </div>
        </div>

        <!-- Objectifs pédagogiques -->
        @if($demande->objectifs_pedagogiques)
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Objectifs pédagogiques</h3>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $demande->objectifs_pedagogiques }}</p>
            </div>
        </div>
        @endif

        <!-- Contenu proposé -->
        @if($demande->contenu_propose)
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contenu proposé</h3>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $demande->contenu_propose }}</p>
            </div>
        </div>
        @endif

        <!-- Public cible -->
        @if($demande->public_cible)
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Public cible</h3>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $demande->public_cible }}</p>
            </div>
        </div>
        @endif

        <!-- Prérequis -->
        @if($demande->prerequis)
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Prérequis</h3>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $demande->prerequis }}</p>
            </div>
        </div>
        @endif

        <!-- Raison du refus (si applicable) -->
        @if($demande->statut === 'REFUSEE' && $demande->raison_refus)
        <div class="card p-6 border-red-200 bg-red-50 dark:bg-red-900/20">
            <h3 class="text-lg font-semibold text-red-900 dark:text-red-300 mb-4">Raison du refus</h3>
            <div class="prose dark:prose-invert max-w-none">
                <p class="text-red-700 dark:text-red-300 whitespace-pre-line">{{ $demande->raison_refus }}</p>
            </div>
        </div>
        @endif

        <!-- Actions -->
        @if($demande->statut === 'EN_ATTENTE')
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Actions administrateur</h3>
            <div class="flex space-x-4">
                <!-- Accept Button -->
                <form action="{{ route('admin.demandes.accept', $demande) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" 
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg flex items-center space-x-2"
                            onclick="return confirm('Êtes-vous sûr de vouloir accepter cette demande ? Une formation sera automatiquement créée.')">
                        <i class="fas fa-check"></i>
                        <span>Accepter la demande</span>
                    </button>
                </form>
                
                <!-- Reject Button -->
                <button type="button" 
                        onclick="showRejectModal()"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg flex items-center space-x-2">
                    <i class="fas fa-times"></i>
                    <span>Refuser la demande</span>
                </button>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Informations du formateur -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Formateur</h3>
            <div class="flex items-center space-x-4 mb-4">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">{{ $demande->formateur->nom }}</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $demande->formateur->email }}</p>
                </div>
            </div>
            
            @if($demande->formateur->specialite)
            <div class="mb-3">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Spécialité</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $demande->formateur->specialite }}</p>
            </div>
            @endif
            
            @if($demande->formateur->experience)
            <div class="mb-3">
                <p class="text-sm font-medium text-gray-700 dark:text-gray-300">Expérience</p>
                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $demande->formateur->experience }} ans</p>
            </div>
            @endif
            
            <div class="flex items-center space-x-2">
                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                    {{ $demande->formateur->est_actif ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $demande->formateur->est_actif ? 'Actif' : 'Inactif' }}
                </span>
            </div>
        </div>

        <!-- Détails de la demande -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Détails</h3>
            <div class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Durée proposée</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $demande->duree_proposee ?? 'Non spécifiée' }}h</span>
                </div>
                
                @if($demande->niveau_requis)
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Niveau requis</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $demande->niveau_requis }}</span>
                </div>
                @endif
                
                @if($demande->modalite_formation)
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Modalité</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $demande->modalite_formation }}</span>
                </div>
                @endif
                
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Soumise le</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $demande->created_at->format('d/m/Y à H:i') }}</span>
                </div>
                
                <div class="flex justify-between">
                    <span class="text-gray-600 dark:text-gray-400">Dernière modification</span>
                    <span class="font-medium text-gray-900 dark:text-white">{{ $demande->updated_at->format('d/m/Y à H:i') }}</span>
                </div>
            </div>
        </div>

        <!-- Ressources nécessaires -->
        @if($demande->ressources_necessaires)
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ressources nécessaires</h3>
            <p class="text-sm text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $demande->ressources_necessaires }}</p>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Refuser la demande</h3>
            
            <form action="{{ route('admin.demandes.reject', $demande) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="raison_refus" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Raison du refus
                    </label>
                    <textarea id="raison_refus" 
                              name="raison_refus" 
                              rows="4" 
                              required
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"
                              placeholder="Expliquez pourquoi cette demande est refusée..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            onclick="hideRejectModal()"
                            class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600">
                        Annuler
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700">
                        Refuser
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showRejectModal() {
    const modal = document.getElementById('rejectModal');
    modal.classList.remove('hidden');
    
    // Focus on textarea
    document.getElementById('raison_refus').focus();
}

function hideRejectModal() {
    const modal = document.getElementById('rejectModal');
    const textarea = document.getElementById('raison_refus');
    
    modal.classList.add('hidden');
    textarea.value = '';
}

// Close modal on background click
document.getElementById('rejectModal').addEventListener('click', function(e) {
    if (e.target === this) {
        hideRejectModal();
    }
});

// Close modal on Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        hideRejectModal();
    }
});
</script>
@endsection