@extends('admin.dashboard')

@section('title', 'Gestion des Demandes - FormaCNI')
@section('page-title', 'Gestion des Demandes')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center space-x-4">
        <a href="{{ route('admin.dashboard') }}" 
           class="text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 flex items-center space-x-2 transition-colors">
            <i class="fas fa-arrow-left"></i>
            <span>Retour au tableau de bord</span>
        </a>
        <div class="h-6 border-l border-gray-300 dark:border-gray-600"></div>
        <div>
            <h2 class="text-2xl font-bold text-black dark:text-white mb-1">Demandes de Formations</h2>
            <p class="text-gray-900 dark:text-gray-300">Gérez les demandes de formations soumises par les formateurs</p>
        </div>
    </div>
    <div class="flex items-center space-x-4">
        <span class="bg-orange-500 text-white text-sm px-3 py-1 rounded-full">
            {{ $demandes->count() }} demande(s) en attente
        </span>
    </div>
</div>

<!-- Demandes List -->
<div class="card">
    <div class="p-6">
        @if($demandes->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="border-b border-gray-200 dark:border-gray-700">
                        <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-300">Demande</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-300">Formateur</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-300">Durée</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-300">Soumise le</th>
                        <th class="text-left py-3 px-4 font-medium text-gray-900 dark:text-gray-300">Statut</th>
                        <th class="text-right py-3 px-4 font-medium text-gray-900 dark:text-gray-300">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($demandes as $demande)
                    <tr class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="py-4 px-4">
                            <div>
                                <h3 class="font-semibold text-gray-900 dark:text-white">{{ $demande->titre }}</h3>
                                <p class="text-sm text-gray-900 dark:text-gray-400 mt-1">
                                    {{ Str::limit($demande->description, 100) }}
                                </p>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">{{ $demande->formateur->nom }}</p>
                                    <p class="text-sm text-gray-900 dark:text-gray-400">{{ $demande->formateur->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ $demande->duree_proposee ?? 'Non spécifiée' }}h
                            </span>
                        </td>
                        <td class="py-4 px-4">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $demande->created_at->format('d/m/Y') }}</p>
                                <p class="text-xs text-gray-800 dark:text-gray-500">{{ $demande->created_at->locale('fr')->diffForHumans() }}</p>
                            </div>
                        </td>
                        <td class="py-4 px-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
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
                        </td>
                        <td class="py-4 px-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- View Details -->
                                <a href="{{ route('admin.demandes.show', $demande) }}" 
                                   class="text-blue-600 hover:text-blue-800 p-1" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </a>
                                
                                @if($demande->statut === 'EN_ATTENTE')
                                <!-- Accept -->
                                <form action="{{ route('admin.demandes.accept', $demande) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="text-green-600 hover:text-green-800 p-1" 
                                            title="Accepter la demande"
                                            onclick="return confirm('Êtes-vous sûr de vouloir accepter cette demande ? Une formation sera automatiquement créée.')">
                                        <i class="fas fa-check"></i>
                                    </button>
                                </form>
                                
                                <!-- Reject -->
                                <button type="button" 
                                        onclick="showRejectModal({{ $demande->id }})"
                                        class="text-red-600 hover:text-red-800 p-1" 
                                        title="Refuser la demande">
                                    <i class="fas fa-times"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <!-- Empty State -->
        <div class="text-center py-12">
            <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                <i class="fas fa-file-alt text-2xl text-gray-400"></i>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune demande en attente</h3>
            <p class="text-gray-800 dark:text-gray-400">
                Toutes les demandes de formations ont été traitées.
            </p>
        </div>
        @endif
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen px-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg p-6 w-full max-w-md">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Refuser la demande</h3>
            
            <form id="rejectForm" method="POST">
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
function showRejectModal(demandeId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    
    form.action = `/admin/demandes/${demandeId}/reject`;
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