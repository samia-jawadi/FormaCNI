@extends('admin.dashboard')

@section('title', 'Gestion des Participants - FormaCNI')
@section('page-title', 'Gestion des Participants')

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
                    👥 Gestion des Participants
                </h1>
                <p class="text-gray-600 font-medium">Gérez et supervisez tous les participants de la plateforme</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.create') }}" 
               class="group flex items-center space-x-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white hover:shadow-xl transform hover:scale-105 transition-all duration-300 py-3 px-6 rounded-xl font-semibold">
                <i class="fas fa-user-plus group-hover:animate-bounce"></i>
                <span>Nouveau Participant</span>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="group relative bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-2">Total Participants</p>
                    <p class="text-3xl font-bold">{{ $stats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-blue-400 border-opacity-30">
                <p class="text-blue-100 text-xs">Tous participants confondus</p>
            </div>
        </div>
    </div>

    <div class="group relative bg-gradient-to-br from-green-500 via-green-600 to-green-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-2">Participants Actifs</p>
                    <p class="text-3xl font-bold">{{ $stats['active'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-check-circle text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-green-400 border-opacity-30">
                <p class="text-green-100 text-xs">Comptes actuellement actifs</p>
            </div>
        </div>
    </div>

    <div class="group relative bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-2">Avec Photos</p>
                    <p class="text-3xl font-bold">{{ $stats['with_photos'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-camera text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-purple-400 border-opacity-30">
                <p class="text-purple-100 text-xs">Profils avec photo</p>
            </div>
        </div>
    </div>

    <div class="group relative bg-gradient-to-br from-red-500 via-red-600 to-red-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-red-100 text-sm font-medium mb-2">Comptes Supprimés</p>
                    <p class="text-3xl font-bold">{{ $stats['deactivated'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-user-times text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-red-400 border-opacity-30">
                <p class="text-red-100 text-xs">Comptes désactivés</p>
            </div>
        </div>
    </div>
</div>

<!-- Enhanced Filters and Search -->
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-6 mb-8">
    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100 -mx-6 -mt-6 mb-6">
        <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <i class="fas fa-filter text-blue-500 mr-3"></i>
            Filtres et Recherche
        </h3>
    </div>
    
    <form method="GET" action="{{ route('admin.participants') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Recherche</label>
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Nom, email..." 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Statut</label>
            <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                <option value="">Tous les statuts</option>
                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Actifs</option>
                <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactifs</option>
                <option value="deactivated" {{ request('status') === 'deactivated' ? 'selected' : '' }}>Supprimés</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Niveau</label>
            <select name="niveau" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                <option value="">Tous les niveaux</option>
                <option value="debutant" {{ request('niveau') === 'debutant' ? 'selected' : '' }}>Débutant</option>
                <option value="intermediaire" {{ request('niveau') === 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                <option value="avance" {{ request('niveau') === 'avance' ? 'selected' : '' }}>Avancé</option>
            </select>
        </div>
        
        <div class="flex space-x-3 items-end">
            <button type="submit" class="flex-1 group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                <i class="fas fa-search group-hover:animate-pulse mr-2"></i>
                Appliquer
            </button>
            <a href="{{ route('admin.participants') }}" class="bg-gray-500 hover:bg-gray-600 text-white w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-105" title="Réinitialiser">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </form>
</div>

<!-- Enhanced Level Distribution -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-seedling text-blue-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Débutants</p>
                    <p class="text-2xl font-bold text-blue-600">{{ $stats['debutant'] }}</p>
                </div>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-blue-400 to-blue-600 h-3 rounded-full transition-all duration-1000 ease-out" 
                 style="width: {{ $stats['total'] > 0 ? ($stats['debutant'] / $stats['total']) * 100 : 0 }}%">
            </div>
        </div>
        <div class="mt-2 text-right">
            <span class="text-sm text-gray-500">{{ $stats['total'] > 0 ? round(($stats['debutant'] / $stats['total']) * 100) : 0 }}%</span>
        </div>
    </div>
    
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-yellow-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-chart-line text-yellow-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Intermédiaires</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['intermediaire'] }}</p>
                </div>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-yellow-400 to-yellow-600 h-3 rounded-full transition-all duration-1000 ease-out" 
                 style="width: {{ $stats['total'] > 0 ? ($stats['intermediaire'] / $stats['total']) * 100 : 0 }}%">
            </div>
        </div>
        <div class="mt-2 text-right">
            <span class="text-sm text-gray-500">{{ $stats['total'] > 0 ? round(($stats['intermediaire'] / $stats['total']) * 100) : 0 }}%</span>
        </div>
    </div>
    
    <div class="group bg-white rounded-2xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
        <div class="flex items-center justify-between mb-4">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                    <i class="fas fa-trophy text-green-600"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Avancés</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['avance'] }}</p>
                </div>
            </div>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-3">
            <div class="bg-gradient-to-r from-green-400 to-green-600 h-3 rounded-full transition-all duration-1000 ease-out" 
                 style="width: {{ $stats['total'] > 0 ? ($stats['avance'] / $stats['total']) * 100 : 0 }}%">
            </div>
        </div>
        <div class="mt-2 text-right">
            <span class="text-sm text-gray-500">{{ $stats['total'] > 0 ? round(($stats['avance'] / $stats['total']) * 100) : 0 }}%</span>
        </div>
    </div>
</div>

<!-- Enhanced Participants Table -->
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-list-alt text-blue-500 mr-3"></i>
                Liste des Participants
            </h3>
            <div class="text-sm text-gray-500">
                {{ $participants->total() }} participant(s) trouvé(s)
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-gray-50">
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Participant</th>
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Contact</th>
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Niveau</th>
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Inscriptions</th>
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Statut</th>
                    <th class="text-right py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="participants-table">
                @forelse($participants as $participant)
                <tr class="border-b border-gray-100 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg group" 
                    data-status="{{ $participant->est_actif ? 'active' : 'inactive' }}"
                    data-niveau="{{ $participant->niveau }}">
                    <td class="py-5 px-6">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                @if($participant->photo)
                                    <img src="{{ Storage::url($participant->photo) }}" 
                                         alt="Photo de {{ $participant->nom }}"
                                         class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-lg cursor-pointer transform group-hover:scale-110 transition-all duration-300"
                                         onclick="showPhotoModal('{{ Storage::url($participant->photo) }}', '{{ $participant->nom }}')">
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 border-2 border-white rounded-full"></div>
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-all duration-300 cursor-pointer"
                                         onclick="showDefaultAvatar('{{ $participant->nom }}')">
                                        <span class="text-white font-bold text-lg">{{ substr($participant->nom, 0, 1) }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $participant->nom }}</h3>
                                    @if($participant->photo)
                                        <i class="fas fa-camera text-blue-500 text-xs" title="Photo de profil"></i>
                                    @endif
                                </div>
                                @if($participant->pronoms)
                                    <div class="text-sm text-gray-600 bg-gray-100 px-2 py-1 rounded-full inline-block mt-1">
                                        {{ $participant->pronoms }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <div class="space-y-1">
                            <div class="flex items-center space-x-2 text-gray-900">
                                <i class="fas fa-envelope text-blue-500 text-sm"></i>
                                <span class="font-medium text-sm">{{ $participant->email }}</span>
                            </div>
                            <div class="flex items-center space-x-2 text-gray-500 text-xs">
                                <i class="fas fa-calendar text-gray-400"></i>
                                <span>Inscrit le {{ $participant->created_at->format('d/m/Y') }}</span>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        @if($participant->niveau)
                            @php
                                $niveauConfig = [
                                    'debutant' => ['color' => 'blue', 'icon' => 'seedling'],
                                    'intermediaire' => ['color' => 'yellow', 'icon' => 'chart-line'],
                                    'avance' => ['color' => 'green', 'icon' => 'trophy']
                                ];
                                $config = $niveauConfig[$participant->niveau] ?? ['color' => 'gray', 'icon' => 'question'];
                            @endphp
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 border border-{{ $config['color'] }}-200 transform group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-{{ $config['icon'] }} mr-2"></i>
                                {{ ucfirst($participant->niveau) }}
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 border border-gray-200">
                                <i class="fas fa-question-circle mr-2"></i>
                                Non défini
                            </span>
                        @endif
                    </td>
                    <td class="py-5 px-6">
                        <div class="text-center">
                            <div class="flex items-center justify-center space-x-4 mb-3">
                                <div class="text-center">
                                    <div class="text-2xl font-bold text-gray-900">{{ $participant->inscriptions_count }}</div>
                                    <div class="text-xs text-gray-500">Total</div>
                                </div>
                                <div class="h-8 w-px bg-gray-300"></div>
                                <div class="text-center">
                                    <div class="text-xl font-bold text-green-600">{{ $participant->confirmed_inscriptions_count }}</div>
                                    <div class="text-xs text-gray-500">Confirmées</div>
                                </div>
                            </div>
                            @if($participant->pending_inscriptions_count > 0)
                                <div class="text-xs text-orange-600 bg-orange-50 px-2 py-1 rounded-full border border-orange-200">
                                    <i class="fas fa-clock mr-1"></i>
                                    {{ $participant->pending_inscriptions_count }} en attente
                                </div>
                            @endif
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        @if($participant->est_actif)
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-300 transform group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-check-circle mr-2"></i>
                                Actif
                            </span>
                        @elseif($participant->deactivated_at)
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800 border border-red-300 transform group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-user-times mr-2"></i>
                                Supprimé
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold bg-yellow-100 text-yellow-800 border border-yellow-300 transform group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-pause-circle mr-2"></i>
                                Inactif
                            </span>
                        @endif
                    </td>
                    <td class="py-5 px-6 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <!-- Edit -->
                            <a href="{{ route('admin.users.edit', $participant) }}" 
                               class="group relative w-10 h-10 bg-green-100 hover:bg-green-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg" 
                               title="Modifier">
                                <i class="fas fa-edit text-green-600 group-hover:text-white transition-colors"></i>
                            </a>
                            
                            <!-- Toggle Status -->
                            <form method="POST" action="{{ route('admin.users.toggle-status', $participant) }}" class="inline">
                                @csrf
                                @if($participant->est_actif)
                                    <button type="submit" 
                                            class="group relative w-10 h-10 bg-red-100 hover:bg-red-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg"
                                            title="Désactiver"
                                            onclick="return confirm('Êtes-vous sûr de vouloir désactiver cet utilisateur ?')">
                                        <i class="fas fa-user-slash text-red-600 group-hover:text-white transition-colors"></i>
                                    </button>
                                @else
                                    <button type="submit" 
                                            class="group relative w-10 h-10 bg-green-100 hover:bg-green-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg"
                                            title="Activer"
                                            onclick="return confirm('Êtes-vous sûr de vouloir activer cet utilisateur ?')">
                                        <i class="fas fa-user-check text-green-600 group-hover:text-white transition-colors"></i>
                                    </button>
                                @endif
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="py-16 text-center">
                        <div class="text-gray-500">
                            <div class="w-20 h-20 mx-auto bg-gray-100 rounded-2xl flex items-center justify-center mb-4">
                                <i class="fas fa-users text-3xl text-gray-400"></i>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Aucun participant trouvé</h3>
                            <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche</p>
                            <a href="{{ route('admin.participants') }}" 
                               class="inline-flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                                <i class="fas fa-refresh"></i>
                                <span>Réinitialiser les filtres</span>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if($participants->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $participants->links() }}
        </div>
    @endif
</div>

<!-- Enhanced Photo Modal -->
<div id="photoModal" class="fixed inset-0 bg-black bg-opacity-80 overflow-y-auto h-full w-full z-50 hidden transition-opacity duration-300">
    <div class="relative top-10 mx-auto p-4 max-w-2xl">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 id="photoModalTitle" class="text-xl font-bold text-gray-900">Photo de profil</h3>
                <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <div class="p-6">
                <div class="flex justify-center mb-6">
                    <img id="photoModalImage" src="" alt="Photo" class="max-w-full h-auto rounded-xl shadow-lg transform transition-transform duration-500">
                </div>
                <div class="text-center">
                    <button onclick="closePhotoModal()" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-times mr-2"></i>
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Default Avatar Modal -->
<div id="avatarModal" class="fixed inset-0 bg-black bg-opacity-80 overflow-y-auto h-full w-full z-50 hidden transition-opacity duration-300">
    <div class="relative top-10 mx-auto p-4 max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden transform transition-all duration-300 scale-95">
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 id="avatarModalTitle" class="text-xl font-bold text-gray-900">Avatar par défaut</h3>
                <button onclick="closeAvatarModal()" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 p-2 rounded-lg hover:bg-gray-100">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>
            
            <div class="p-6">
                <div class="flex justify-center mb-6">
                    <div id="avatarModalContent" class="w-32 h-32 bg-gradient-to-br from-blue-400 to-purple-500 rounded-2xl flex items-center justify-center shadow-2xl">
                        <span id="avatarInitial" class="text-white font-bold text-4xl"></span>
                    </div>
                </div>
                <div class="text-center text-gray-600 mb-6">
                    <p>Ce participant n'a pas encore uploadé de photo de profil.</p>
                    <p class="text-sm">L'avatar par défaut est généré à partir de la première lettre du nom.</p>
                </div>
                <div class="text-center">
                    <button onclick="closeAvatarModal()" class="bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105">
                        <i class="fas fa-times mr-2"></i>
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
function showPhotoModal(photoUrl, userName) {
    const modal = document.getElementById('photoModal');
    const image = document.getElementById('photoModalImage');
    const title = document.getElementById('photoModalTitle');
    
    image.src = photoUrl;
    title.textContent = 'Photo de ' + userName;
    
    // Reset and apply animations
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.style.opacity = '1';
        image.style.transform = 'scale(1)';
    }, 50);
}

function closePhotoModal() {
    const modal = document.getElementById('photoModal');
    modal.style.opacity = '0';
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

function showDefaultAvatar(userName) {
    const modal = document.getElementById('avatarModal');
    const initial = document.getElementById('avatarInitial');
    const title = document.getElementById('avatarModalTitle');
    
    initial.textContent = userName.charAt(0).toUpperCase();
    title.textContent = 'Avatar de ' + userName;
    
    modal.classList.remove('hidden');
    setTimeout(() => {
        modal.style.opacity = '1';
    }, 50);
}

function closeAvatarModal() {
    const modal = document.getElementById('avatarModal');
    modal.style.opacity = '0';
    setTimeout(() => {
        modal.classList.add('hidden');
    }, 300);
}

// Close modals when clicking outside or pressing ESC
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed')) {
        closePhotoModal();
        closeAvatarModal();
    }
});

document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        closePhotoModal();
        closeAvatarModal();
    }
});

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
    const tableRows = document.querySelectorAll('tbody tr');
    tableRows.forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateX(-20px)';
        
        setTimeout(() => {
            row.style.transition = 'all 0.5s ease-out';
            row.style.opacity = '1';
            row.style.transform = 'translateX(0)';
        }, index * 50 + 300);
    });
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

/* Modal animations */
#photoModal, #avatarModal {
    transition: opacity 0.3s ease-in-out;
}

#photoModalImage {
    transition: transform 0.5s ease-in-out;
}
</style>
@endsection