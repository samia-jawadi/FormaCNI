@extends('layouts.formateur')

@section('title', 'My Formations')

@section('page-title', 'My Formations')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <p class="text-gray-600">Manage your created formations, track approval status, and handle participants.</p>
        <a href="{{ route('formateur.formations.create') }}" 
           class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Create New Formation
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="card p-6 rounded-lg text-center">
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-list text-blue-600 text-xl"></i>
        </div>
        <h3 class="font-semibold text-gray-800">Total</h3>
        <p class="text-2xl font-bold text-blue-600">{{ $myFormations->count() }}</p>
    </div>
    
    <div class="card p-6 rounded-lg text-center">
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-check text-green-600 text-xl"></i>
        </div>
        <h3 class="font-semibold text-gray-800">Approved</h3>
        <p class="text-2xl font-bold text-green-600">{{ $myFormations->where('statut', 'ACCEPTEE')->count() }}</p>
    </div>
    
    <div class="card p-6 rounded-lg text-center">
        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-clock text-yellow-600 text-xl"></i>
        </div>
        <h3 class="font-semibold text-gray-800">Pending</h3>
        <p class="text-2xl font-bold text-yellow-600">{{ $myFormations->where('statut', 'ATTENTE_VALIDATION')->count() }}</p>
    </div>
    
    <div class="card p-6 rounded-lg text-center">
        <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-3">
            <i class="fas fa-times text-red-600 text-xl"></i>
        </div>
        <h3 class="font-semibold text-gray-800">Rejected</h3>
        <p class="text-2xl font-bold text-red-600">{{ $myFormations->where('statut', 'REFUSEE')->count() }}</p>
    </div>
</div>

<!-- Formations List -->
<div class="space-y-6">
    @forelse($myFormations as $formation)
        <div class="card rounded-lg overflow-hidden">
            <div class="p-6">
                <!-- Formation Header -->
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <div class="flex items-start justify-between">
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $formation->titre }}</h3>
                            <div class="flex items-center space-x-2 ml-4">
                                <!-- Status Badge -->
                                @php($st = $formation->terminee ? 'TERMINEE' : $formation->statut)
                                @if($st === 'TERMINEE')
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-flag-checkered mr-1"></i>Terminée
                                    </span>
                                @elseif($st === 'ACCEPTEE')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-check mr-1"></i>Approved
                                    </span>
                                @elseif($st === 'ATTENTE_VALIDATION')
                                    <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-clock mr-1"></i>Pending Approval
                                    </span>
                                @elseif($st === 'REFUSEE')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-times mr-1"></i>Rejected
                                    </span>
                                @elseif($st === 'ACTIVE')
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        <i class="fas fa-play mr-1"></i>Active
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-gray-100 text-gray-800 rounded-full text-sm font-medium">
                                        {{ $st }}
                                    </span>
                                @endif
                                
                                <!-- Action Dropdown -->
                                <div x-data="{ open: false }" class="relative">
                                    <button @click="open = !open" 
                                            class="p-2 text-gray-500 hover:text-gray-700 rounded-lg hover:bg-gray-100">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    
                                    <div x-show="open" 
                                         @click.away="open = false"
                                         x-transition
                                         class="absolute right-0 mt-2 w-48 card rounded-lg shadow-lg z-10">
                                        <div class="py-2">
                                            <a href="{{ route('formateur.formations.show', $formation) }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                <i class="fas fa-eye mr-3 w-4"></i>
                                                View Details
                                            </a>
                                            
                                            <a href="{{ route('formateur.formations.edit', $formation) }}" 
                                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                <i class="fas fa-edit mr-3 w-4"></i>
                                                Edit Description
                                            </a>
                                            
                                            @if($formation->statut === 'ACCEPTEE' || $formation->statut === 'ACTIVE')
                                                <button onclick="manageParticipants('{{ $formation->id }}')" 
                                                        class="w-full flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                                    <i class="fas fa-users mr-3 w-4"></i>
                                                    Manage Participants
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Formation Details -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm text-gray-600 mb-4">
                            <div class="flex items-center">
                                <i class="fas fa-calendar mr-2 text-gray-400"></i>
                                <span>{{ \Carbon\Carbon::parse($formation->date_debut)->format('M j, Y') }} - {{ \Carbon\Carbon::parse($formation->date_fin)->format('M j, Y') }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-clock mr-2 text-gray-400"></i>
                                <span>{{ $formation->duree }} weeks · {{ \Carbon\Carbon::parse($formation->heure_debut)->format('H:i') }}</span>
                            </div>
                            
                            <div class="flex items-center">
                                <i class="fas fa-users mr-2 text-gray-400"></i>
                                <span>{{ $formation->inscriptions_count ?? $formation->participants()->count() }} / {{ $formation->capacite_max }} participants</span>
                            </div>
                        </div>
                        
                        <!-- Formation Description -->
                        <p class="text-gray-700 text-sm leading-relaxed mb-4">{{ Str::limit($formation->description, 200) }}</p>
                    </div>
                </div>

                <!-- Participants Section -->
                @if((($formation->statut === 'ACCEPTEE' || $formation->statut === 'ACTIVE') && !$formation->terminee) && $formation->participants()->count() > 0)
                    <div class="border-t pt-4">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="font-medium text-gray-800">
                                Participants 
                                <span class="text-sm text-gray-500">({{ $formation->participants()->count() }})</span>
                            </h4>
                            <button onclick="toggleParticipants('{{ $formation->id }}')" 
                                    class="text-sm text-blue-600 hover:text-blue-700">
                                <span id="toggle-text-{{ $formation->id }}">Show All</span>
                                <i class="fas fa-chevron-down ml-1" id="toggle-icon-{{ $formation->id }}"></i>
                            </button>
                        </div>
                        
                        <!-- Participants Preview -->
                        <div class="flex flex-wrap gap-2 mb-3">
                            @foreach($formation->participants()->take(5)->get() as $participant)
                                <div class="flex items-center space-x-2 bg-gray-50 rounded-full px-3 py-1">
                                    <div class="w-6 h-6 bg-blue-600 rounded-full flex items-center justify-center">
                                        <span class="text-white text-xs font-medium">{{ substr($participant->nom, 0, 1) }}</span>
                                    </div>
                                    <span class="text-sm text-gray-700">{{ $participant->nom }} {{ $participant->prenom }}</span>
                                </div>
                            @endforeach
                            
                            @if($formation->participants()->count() > 5)
                                <div class="flex items-center space-x-2 bg-gray-100 rounded-full px-3 py-1">
                                    <span class="text-sm text-gray-600">+{{ $formation->participants()->count() - 5 }} more</span>
                                </div>
                            @endif
                        </div>
                        
                        <!-- Full Participants List (Hidden by default) -->
                        <div id="participants-{{ $formation->id }}" class="hidden space-y-2">
                            @foreach($formation->participants as $participant)
                                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                            <span class="text-white text-sm font-medium">{{ substr($participant->nom, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $participant->nom }} {{ $participant->prenom }}</p>
                                            <p class="text-sm text-gray-600">{{ $participant->email }}</p>
                                        </div>
                                    </div>
                                    
                                    @if($formation->statut === 'ACCEPTEE' || $formation->statut === 'ACTIVE')
                                        <button onclick="removeParticipant('{{ $formation->id }}', '{{ $participant->id }}')" 
                                                class="text-red-600 hover:text-red-700 p-2 rounded-lg hover:bg-red-50">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @elseif(($formation->statut === 'ACCEPTEE' || $formation->statut === 'ACTIVE') && !$formation->terminee)
                    <div class="border-t pt-4 text-center text-gray-500">
                        <i class="fas fa-users text-2xl mb-2"></i>
                        <p>No participants enrolled yet</p>
                    </div>
                @endif
            </div>
        </div>
    @empty
        <div class="text-center py-12">
            <div class="max-w-sm mx-auto">
                <i class="fas fa-graduation-cap text-gray-300 text-6xl mb-4"></i>
                <h3 class="text-xl font-medium text-gray-600 mb-2">No Formations Created</h3>
                <p class="text-gray-500 mb-6">You haven't created any formations yet. Start by creating your first formation.</p>
                <a href="{{ route('formateur.formations.create') }}" 
                   class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Formation
                </a>
            </div>
        </div>
    @endforelse
</div>

<!-- Participants Management Modal -->
<div id="participantsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50" x-data="{ open: false }">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="card rounded-lg max-w-2xl w-full max-h-96 overflow-hidden">
            <div class="p-6 border-b">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-800">Manage Participants</h3>
                    <button onclick="closeParticipantsModal()" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="p-6 overflow-y-auto">
                <div id="modalContent">
                    <!-- Content will be loaded dynamically -->
                </div>
            </div>
            <div class="p-4 border-t bg-gray-50 flex justify-end">
                <button onclick="closeParticipantsModal()" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800">
                    Annuler
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleParticipants(formationId) {
    const participantsDiv = document.getElementById(`participants-${formationId}`);
    const toggleText = document.getElementById(`toggle-text-${formationId}`);
    const toggleIcon = document.getElementById(`toggle-icon-${formationId}`);
    
    if (participantsDiv.classList.contains('hidden')) {
        participantsDiv.classList.remove('hidden');
        toggleText.textContent = 'Hide';
        toggleIcon.classList.remove('fa-chevron-down');
        toggleIcon.classList.add('fa-chevron-up');
    } else {
        participantsDiv.classList.add('hidden');
        toggleText.textContent = 'Show All';
        toggleIcon.classList.remove('fa-chevron-up');
        toggleIcon.classList.add('fa-chevron-down');
    }
}

function manageParticipants(formationId) {
    // Show modal
    document.getElementById('participantsModal').classList.remove('hidden');
    
    // Load content (you can implement AJAX loading here)
    document.getElementById('modalContent').innerHTML = `
        <div class="text-center">
            <i class="fas fa-spinner fa-spin text-2xl text-gray-400"></i>
            <p class="mt-2 text-gray-600">Loading participants...</p>
        </div>
    `;
    
    // You can implement AJAX call here to load participants management interface
}

function closeParticipantsModal() {
    document.getElementById('participantsModal').classList.add('hidden');
}

function removeParticipant(formationId, participantId) {
    if (confirm('Are you sure you want to remove this participant from the formation?')) {
        // Implement AJAX call to remove participant
        // For now, we'll just reload the page
        fetch(`/formateur/formations/${formationId}/participants/${participantId}/remove`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error removing participant: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the participant');
        });
    }
}

// Close modal when clicking outside
document.getElementById('participantsModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeParticipantsModal();
    }
});
</script>
@endpush