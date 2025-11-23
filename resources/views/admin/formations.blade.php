@extends('admin.dashboard')

@section('title', 'Gestion des Formations - FormaCNI')
@section('page-title', 'Gestion des Formations')

@section('content')
<!-- Header Section -->
<div class="relative mb-8">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.dashboard') }}" 
               class="group flex items-center space-x-2 text-blue-600 hover:text-blue-700 transition-all duration-300 transform hover:translate-x-1">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </div>
                <span class="font-medium">Retour au tableau de bord</span>
            </a>
            <div class="h-8 w-px bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                    🎓 Gestion des Formations
                </h1>
                <p class="text-gray-600 font-medium">Gérez et supervisez toutes les formations de la plateforme</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.demandes.index') }}" 
               class="group flex items-center space-x-2 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white hover:shadow-xl transform hover:scale-105 transition-all duration-300 py-3 px-6 rounded-xl font-semibold">
                <i class="fas fa-file-alt group-hover:animate-bounce"></i>
                <span>Voir Demandes</span>
            </a>
        </div>
    </div>
</div>

<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
    <div class="group relative bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-2">Total Formations</p>
                    <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-book text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-blue-400 border-opacity-30">
                <p class="text-blue-100 text-xs">Toutes formations confondues</p>
            </div>
        </div>
    </div>
    
    <div class="group relative bg-gradient-to-br from-green-500 via-green-600 to-green-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-2">Actives</p>
                    <p class="text-3xl font-bold">{{ $stats['active'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-play-circle text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-green-400 border-opacity-30">
                <p class="text-green-100 text-xs">En cours de déroulement</p>
            </div>
        </div>
    </div>
    
    <div class="group relative bg-gradient-to-br from-orange-500 via-orange-600 to-orange-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium mb-2">En Attente</p>
                    <p class="text-3xl font-bold">{{ $stats['pending'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-clock text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-orange-400 border-opacity-30">
                <p class="text-orange-100 text-xs">En attente de validation</p>
            </div>
        </div>
    </div>
    
    <div class="group relative bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-2">Terminées</p>
                    <p class="text-3xl font-bold">{{ $stats['completed'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-graduation-cap text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-purple-400 border-opacity-30">
                <p class="text-purple-100 text-xs">Formations achevées</p>
            </div>
        </div>
    </div>
    
    <div class="group relative bg-gradient-to-br from-teal-500 via-teal-600 to-teal-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-teal-100 text-sm font-medium mb-2">À Venir</p>
                    <p class="text-3xl font-bold">{{ $stats['upcoming'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-calendar-alt text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-teal-400 border-opacity-30">
                <p class="text-teal-100 text-xs">Programmées prochainement</p>
            </div>
        </div>
    </div>
</div>

<!-- Filter Tabs -->
<div class="mb-8">
    <div class="flex space-x-2 bg-gray-100 p-2 rounded-2xl">
        <button onclick="filterFormations('all')" 
                class="filter-btn active flex-1 text-center py-3 px-6 rounded-xl text-sm font-semibold transition-all duration-300 bg-white text-gray-900 shadow-lg transform hover:scale-105 border-2 border-transparent hover:border-blue-200">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-layer-group text-blue-600"></i>
                <span>Toutes ({{ $formations->count() }})</span>
            </div>
        </button>
        <button onclick="filterFormations('ACTIVE')" 
                class="filter-btn flex-1 text-center py-3 px-6 rounded-xl text-sm font-semibold transition-all duration-300 text-gray-700 hover:text-gray-900 hover:bg-white hover:shadow-lg transform hover:scale-105 border-2 border-transparent hover:border-green-200">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-play-circle text-green-600"></i>
                <span>Actives ({{ $formations->where('statut', 'ACTIVE')->count() }})</span>
            </div>
        </button>
        <button onclick="filterFormations('ATTENTE_VALIDATION')" 
                class="filter-btn flex-1 text-center py-3 px-6 rounded-xl text-sm font-semibold transition-all duration-300 text-gray-700 hover:text-gray-900 hover:bg-white hover:shadow-lg transform hover:scale-105 border-2 border-transparent hover:border-orange-200">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-clock text-orange-600"></i>
                <span>En Attente ({{ $formations->where('statut', 'ATTENTE_VALIDATION')->count() }})</span>
            </div>
        </button>
        <button onclick="filterFormations('TERMINEE')" 
                class="filter-btn flex-1 text-center py-3 px-6 rounded-xl text-sm font-semibold transition-all duration-300 text-gray-700 hover:text-gray-900 hover:bg-white hover:shadow-lg transform hover:scale-105 border-2 border-transparent hover:border-purple-200">
            <div class="flex items-center justify-center space-x-2">
                <i class="fas fa-graduation-cap text-purple-600"></i>
                <span>Terminées ({{ $formations->where('terminee', true)->count() }})</span>
            </div>
        </button>
    </div>
</div>

<!-- Formations List -->
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <i class="fas fa-list-alt text-blue-500 mr-3"></i>
            Liste des Formations
        </h3>
    </div>
    
    <div class="p-6">
        @if($formations->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="border-b-2 border-gray-200">
                        <th class="text-left py-4 px-4 font-bold text-gray-900 text-sm uppercase tracking-wider">Formation</th>
                        <th class="text-left py-4 px-4 font-bold text-gray-900 text-sm uppercase tracking-wider">Formateur</th>
                        <th class="text-left py-4 px-4 font-bold text-gray-900 text-sm uppercase tracking-wider">Durée</th>
                        <th class="text-left py-4 px-4 font-bold text-gray-900 text-sm uppercase tracking-wider">Dates</th>
                        <th class="text-left py-4 px-4 font-bold text-gray-900 text-sm uppercase tracking-wider">Inscriptions</th>
                        <th class="text-left py-4 px-4 font-bold text-gray-900 text-sm uppercase tracking-wider">Statut</th>
                        <th class="text-right py-4 px-4 font-bold text-gray-900 text-sm uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody id="formations-table">
                    @foreach($formations as $formation)
                    <tr class="formation-row border-b border-gray-100 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg group" 
                        data-status="{{ $formation->statut }}"
                        data-completed="{{ $formation->terminee ? 'true' : 'false' }}">
                        <td class="py-5 px-4">
                            <div class="flex items-start space-x-4">
                                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-graduation-cap text-white"></i>
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-900 text-lg mb-1">{{ $formation->titre }}</h3>
                                    <p class="text-sm text-gray-600 leading-relaxed">
                                        {{ Str::limit($formation->description, 80) }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 px-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center shadow-lg">
                                    <i class="fas fa-user text-white text-sm"></i>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900">{{ $formation->formateur->nom }}</p>
                                    <p class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full inline-block">
                                        {{ $formation->formateur->specialite ?? 'Formateur' }}
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 px-4">
                            <div class="text-center">
                                <span class="inline-flex items-center justify-center w-12 h-12 bg-blue-100 rounded-full">
                                    <span class="font-bold text-blue-700 text-sm">{{ $formation->duree }}h</span>
                                </span>
                            </div>
                        </td>
                        <td class="py-5 px-4">
                            <div class="text-sm bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <div class="flex items-center space-x-2 text-gray-700 mb-1">
                                    <i class="fas fa-play text-green-500 text-xs"></i>
                                    <span class="font-medium">{{ $formation->date_debut->format('d/m/Y') }}</span>
                                </div>
                                <div class="flex items-center space-x-2 text-gray-700">
                                    <i class="fas fa-flag-checkered text-red-500 text-xs"></i>
                                    <span class="font-medium">{{ $formation->date_fin->format('d/m/Y') }}</span>
                                </div>
                                <div class="mt-2 text-xs text-gray-500 bg-white px-2 py-1 rounded border">
                                    <i class="fas fa-clock text-blue-500 mr-1"></i>
                                    {{ $formation->heure_debut_formattee }}
                                </div>
                            </div>
                        </td>
                        <td class="py-5 px-4">
                            <div class="text-center">
                                <p class="font-bold text-gray-900 text-lg mb-2">
                                    {{ $formation->confirmed_inscriptions_count ?? 0 }}/{{ $formation->capacite_max }}
                                </p>
                                <div class="relative">
                                    <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden shadow-inner">
                                        <div class="bar h-3 rounded-full bg-gradient-to-r from-green-400 to-green-600 transition-all duration-1000 ease-out" 
                                             style="width: {{ $formation->capacite_max > 0 ? (($formation->confirmed_inscriptions_count ?? 0) / $formation->capacite_max) * 100 : 0 }}%">
                                        </div>
                                    </div>
                                    <div class="text-xs text-gray-500 mt-1 font-medium">
                                        {{ $formation->capacite_max > 0 ? round((($formation->confirmed_inscriptions_count ?? 0) / $formation->capacite_max) * 100) : 0 }}% complet
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="py-5 px-4">
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold shadow-sm border-2
                                @if($formation->terminee) bg-purple-100 text-purple-800 border-purple-300
                                @elseif($formation->statut === 'ACTIVE') bg-green-100 text-green-800 border-green-300
                                @elseif($formation->statut === 'ATTENTE_VALIDATION') bg-orange-100 text-orange-800 border-orange-300
                                @else bg-gray-100 text-gray-800 border-gray-300
                                @endif transform group-hover:scale-110 transition-transform duration-300">
                                @if($formation->terminee)
                                    <i class="fas fa-graduation-cap mr-2"></i>Terminée
                                @elseif($formation->statut === 'ACTIVE')
                                    <i class="fas fa-play-circle mr-2"></i>Active
                                @elseif($formation->statut === 'ATTENTE_VALIDATION')
                                    <i class="fas fa-clock mr-2"></i>En attente
                                @else
                                    <i class="fas fa-question-circle mr-2"></i>{{ $formation->statut }}
                                @endif
                            </span>
                        </td>
                        <td class="py-5 px-4 text-right">
                            <div class="flex items-center justify-end space-x-2">
                                <!-- View Details -->
                                <a href="{{ route('admin.formations.show', $formation) }}" 
                                   class="group relative w-10 h-10 bg-blue-100 hover:bg-blue-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg" 
                                   title="Voir détails">
                                    <i class="fas fa-eye text-blue-600 group-hover:text-white transition-colors"></i>
                                </a>
                                
                                <!-- Edit -->
                                <a href="{{ route('admin.formations.edit', $formation) }}" 
                                   class="group relative w-10 h-10 bg-green-100 hover:bg-green-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg" 
                                   title="Modifier">
                                    <i class="fas fa-edit text-green-600 group-hover:text-white transition-colors"></i>
                                </a>
                                
                                @if($formation->statut === 'ATTENTE_VALIDATION')
                                <!-- Approve -->
                                <form action="{{ route('admin.formations.update', $formation) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="statut" value="ACTIVE">
                                    <input type="hidden" name="titre" value="{{ $formation->titre }}">
                                    <input type="hidden" name="description" value="{{ $formation->description }}">
                                    <input type="hidden" name="duree" value="{{ $formation->duree }}">
                                    <input type="hidden" name="date_debut" value="{{ $formation->date_debut->format('Y-m-d') }}">
                                    <input type="hidden" name="date_fin" value="{{ $formation->date_fin->format('Y-m-d') }}">
                                    <input type="hidden" name="heure_debut" value="{{ $formation->heure_debut }}">
                                    <input type="hidden" name="capacite_max" value="{{ $formation->capacite_max }}">
                                    <button type="submit" 
                                            class="group relative w-10 h-10 bg-green-100 hover:bg-green-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg" 
                                            title="Approuver la formation"
                                            onclick="return confirm('Êtes-vous sûr de vouloir approuver cette formation ?')">
                                        <i class="fas fa-check text-green-600 group-hover:text-white transition-colors"></i>
                                    </button>
                                </form>
                                @endif
                                
                                @if($formation->statut === 'ACTIVE' && !$formation->terminee)
                                <!-- Single Terminate Button -->
                                <form action="{{ route('admin.formations.terminate', $formation) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="group relative w-10 h-10 bg-purple-100 hover:bg-purple-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg" 
                                            title="Terminer la formation"
                                            onclick="return confirm('Êtes-vous sûr de vouloir terminer cette formation ? Cette action est irréversible.')">
                                        <i class="fas fa-stop text-purple-600 group-hover:text-white transition-colors"></i>
                                    </button>
                                </form>
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
        <div class="text-center py-16">
            <div class="w-20 h-20 mx-auto bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                <i class="fas fa-book text-3xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Aucune formation trouvée</h3>
            <p class="text-gray-600 max-w-md mx-auto mb-6">
                Les formations apparaitront ici une fois créées par les formateurs ou approuvées depuis les demandes.
            </p>
            <a href="{{ route('admin.demandes.index') }}" 
               class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                <i class="fas fa-file-alt"></i>
                <span>Vérifier les demandes en attente</span>
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
function filterFormations(status) {
    const rows = document.querySelectorAll('.formation-row');
    const buttons = document.querySelectorAll('.filter-btn');
    
    // Update active button with animation
    buttons.forEach(btn => {
        btn.classList.remove('active', 'bg-white', 'text-gray-900', 'shadow-lg', 'border-2', 'border-blue-200');
        btn.classList.add('text-gray-700', 'hover:text-gray-900', 'hover:bg-white', 'hover:shadow-lg', 'border-transparent');
    });
    
    event.target.classList.remove('text-gray-700', 'hover:text-gray-900', 'hover:bg-white', 'hover:shadow-lg', 'border-transparent');
    event.target.classList.add('active', 'bg-white', 'text-gray-900', 'shadow-lg', 'border-2', 'border-blue-200');
    
    // Filter rows with animation
    rows.forEach((row, index) => {
        const rowStatus = row.getAttribute('data-status');
        const rowCompleted = row.getAttribute('data-completed') === 'true';
        
        let show = false;
        
        if (status === 'all') {
            show = true;
        } else if (status === 'TERMINEE') {
            show = rowCompleted;
        } else {
            show = rowStatus === status && !rowCompleted;
        }
        
        if (show) {
            row.style.display = '';
            // Add entrance animation
            setTimeout(() => {
                row.style.opacity = '1';
                row.style.transform = 'translateY(0) scale(1)';
            }, index * 50);
        } else {
            row.style.opacity = '0';
            row.style.transform = 'translateY(10px) scale(0.95)';
            setTimeout(() => {
                row.style.display = 'none';
            }, 300);
        }
    });
}

// Initialize animations on page load
document.addEventListener('DOMContentLoaded', function() {
    // Animate stats cards
    const statsCards = document.querySelectorAll('.bg-gradient-to-br');
    statsCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
    
    // Animate table rows
    const tableRows = document.querySelectorAll('.formation-row');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.5s ease-out';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 50 + 300);
    });
    
    // Initialize progress bars animation
    const progressBars = document.querySelectorAll('.bar');
    progressBars.forEach(bar => {
        const width = bar.style.width;
        bar.style.width = '0';
        setTimeout(() => {
            bar.style.transition = 'width 1s ease-in-out';
            bar.style.width = width;
        }, 500);
    });
    
    // Initialize filter buttons
    const firstButton = document.querySelector('.filter-btn');
    if (firstButton) {
        firstButton.classList.add('bg-white', 'text-gray-900', 'shadow-lg', 'border-2', 'border-blue-200');
        firstButton.classList.remove('text-gray-700', 'border-transparent');
    }
});
</script>

<style>
/* Custom animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.group:hover .floating {
    animation: float 2s ease-in-out infinite;
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, transform, box-shadow, opacity;
    transition-duration: 300ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar for table */
.overflow-x-auto::-webkit-scrollbar {
    height: 8px;
}

.overflow-x-auto::-webkit-scrollbar-track {
    background: #f1f5f9;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.overflow-x-auto::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}
</style>
@endsection