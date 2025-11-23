@extends('admin.dashboard')

@section('title', 'Gestion Utilisateurs - FormaCNI')
@section('page-title', 'Gestion des Utilisateurs')

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
                    👥 Gestion des Utilisateurs
                </h1>
                <p class="text-gray-600 font-medium">Gérez et supervisez tous les utilisateurs de la plateforme</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <a href="{{ route('admin.users.inactive') }}" 
               class="group flex items-center space-x-2 bg-gradient-to-r from-gray-500 to-gray-600 hover:from-gray-600 hover:to-gray-700 text-white hover:shadow-xl transform hover:scale-105 transition-all duration-300 py-3 px-6 rounded-xl font-semibold">
                <i class="fas fa-archive group-hover:animate-bounce"></i>
                <span>Comptes Désactivés</span>
            </a>
            <a href="{{ route('admin.users.create') }}" 
               class="group flex items-center space-x-2 bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white hover:shadow-xl transform hover:scale-105 transition-all duration-300 py-3 px-6 rounded-xl font-semibold">
                <i class="fas fa-user-plus group-hover:animate-bounce"></i>
                <span>Nouvel Utilisateur</span>
            </a>
        </div>
    </div>
</div>

<!-- Enhanced Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="group relative bg-gradient-to-br from-blue-500 via-blue-600 to-blue-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100 text-sm font-medium mb-2">Utilisateurs Totaux</p>
                    <p class="text-3xl font-bold">{{ $userStats['total'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-users text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-blue-400 border-opacity-30">
                <p class="text-blue-100 text-xs">Tous utilisateurs confondus</p>
            </div>
        </div>
    </div>

    <div class="group relative bg-gradient-to-br from-purple-500 via-purple-600 to-purple-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100 text-sm font-medium mb-2">Administrateurs</p>
                    <p class="text-3xl font-bold">{{ $userStats['admins'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-shield-alt text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-purple-400 border-opacity-30">
                <p class="text-purple-100 text-xs">Accès administrateur</p>
            </div>
        </div>
    </div>

    <div class="group relative bg-gradient-to-br from-green-500 via-green-600 to-green-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100 text-sm font-medium mb-2">Formateurs</p>
                    <p class="text-3xl font-bold">{{ $userStats['formateurs'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-chalkboard-teacher text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-green-400 border-opacity-30">
                <p class="text-green-100 text-xs">Enseignants certifiés</p>
            </div>
        </div>
    </div>

    <div class="group relative bg-gradient-to-br from-orange-500 via-orange-600 to-orange-700 p-6 rounded-2xl text-white shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 overflow-hidden">
        <div class="absolute top-0 right-0 w-20 h-20 bg-white bg-opacity-10 rounded-full -mr-6 -mt-6"></div>
        <div class="relative">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100 text-sm font-medium mb-2">Participants</p>
                    <p class="text-3xl font-bold">{{ $userStats['participants'] }}</p>
                </div>
                <div class="w-12 h-12 bg-white bg-opacity-20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
            </div>
            <div class="mt-4 pt-4 border-t border-orange-400 border-opacity-30">
                <p class="text-orange-100 text-xs">Étudiants actifs</p>
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
    
    <form method="GET" action="{{ route('admin.users.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Recherche</label>
            <div class="relative">
                <input type="text" name="search" placeholder="Nom, email..." 
                       value="{{ request('search') }}" 
                       class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Rôle</label>
            <select name="role" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                <option value="">Tous les rôles</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                <option value="formateur" {{ request('role') == 'formateur' ? 'selected' : '' }}>Formateur</option>
                <option value="participant" {{ request('role') == 'participant' ? 'selected' : '' }}>Participant</option>
            </select>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-3">Statut</label>
            <select name="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-300">
                <option value="">Tous les statuts</option>
                <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Actif</option>
                <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactif</option>
            </select>
        </div>
        
        <div class="flex space-x-3 items-end">
            <button type="submit" class="flex-1 group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-6 py-3 rounded-xl font-semibold transition-all duration-300 transform hover:scale-105 hover:shadow-lg">
                <i class="fas fa-filter group-hover:animate-pulse mr-2"></i>
                Appliquer
            </button>
            <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white w-12 h-12 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-105" title="Réinitialiser">
                <i class="fas fa-times"></i>
            </a>
        </div>
    </form>
</div>

<!-- Enhanced Users Table -->
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100">
        <div class="flex items-center justify-between">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-list-alt text-blue-500 mr-3"></i>
                Liste des Utilisateurs
            </h3>
            <div class="text-sm text-gray-500 font-medium">
                {{ $users->total() }} utilisateur(s) trouvé(s)
            </div>
        </div>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full table-auto">
            <thead class="bg-gray-50">
                <tr class="border-b-2 border-gray-200">
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Utilisateur</th>
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Rôle</th>
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Informations</th>
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Statut</th>
                    <th class="text-left py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Date d'Inscription</th>
                    <th class="text-right py-4 px-6 font-bold text-gray-900 text-sm uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody id="users-table">
                @forelse($users as $user)
                <tr class="border-b border-gray-100 hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 transition-all duration-300 transform hover:scale-[1.02] hover:shadow-lg group" 
                    data-role="{{ $user->role }}"
                    data-status="{{ $user->est_actif ? 'active' : 'inactive' }}">
                    <td class="py-5 px-6">
                        <div class="flex items-center space-x-4">
                            <div class="relative">
                                @if($user->photo)
                                    <img src="{{ Storage::url($user->photo) }}" 
                                         alt="Photo de {{ $user->nom }}"
                                         class="w-12 h-12 rounded-xl object-cover border-2 border-white shadow-lg cursor-pointer transform group-hover:scale-110 transition-all duration-300"
                                         onclick="showPhotoModal('{{ Storage::url($user->photo) }}', '{{ $user->nom }}')">
                                    <div class="absolute -bottom-1 -right-1 w-5 h-5 bg-green-400 border-2 border-white rounded-full"></div>
                                @else
                                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-500 rounded-xl flex items-center justify-center shadow-lg transform group-hover:scale-110 transition-all duration-300 cursor-pointer"
                                         onclick="showDefaultAvatar('{{ $user->nom }}')">
                                        <span class="text-white font-bold text-lg">{{ $user->initials }}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <h3 class="font-bold text-gray-900 text-lg">{{ $user->nom }}</h3>
                                    @if($user->photo)
                                        <i class="fas fa-camera text-blue-500 text-xs" title="Photo de profil"></i>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        <div class="flex items-center space-x-3">
                            @php
                                $roleConfig = [
                                    'admin' => ['color' => 'purple', 'icon' => 'shield-alt'],
                                    'formateur' => ['color' => 'green', 'icon' => 'chalkboard-teacher'],
                                    'participant' => ['color' => 'orange', 'icon' => 'user-graduate']
                                ];
                                $config = $roleConfig[$user->role] ?? ['color' => 'gray', 'icon' => 'user'];
                            @endphp
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 border border-{{ $config['color'] }}-200 transform group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-{{ $config['icon'] }} mr-2"></i>
                                {{ ucfirst($user->role) }}
                            </span>
                            
                            <!-- Enhanced Role Change Dropdown -->
                            <div class="relative">
                                <button class="role-dropdown-btn text-gray-400 hover:text-{{ $config['color'] }}-600 transition-colors duration-200 p-1 rounded-lg hover:bg-{{ $config['color'] }}-50"
                                        onclick="toggleRoleDropdown(this)">
                                    <i class="fas fa-chevron-down text-xs"></i>
                                </button>
                                <div class="role-dropdown-menu absolute left-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-20 hidden transform origin-top transition-all duration-300 scale-95 opacity-0">
                                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="px-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="role" value="admin">
                                        <input type="hidden" name="nom" value="{{ $user->nom }}">
                                        <button type="submit" 
                                                class="w-full text-left px-4 py-3 text-sm hover:bg-purple-50 rounded-lg flex items-center transition-all duration-200 {{ $user->role == 'admin' ? 'bg-purple-50 text-purple-700 border-l-4 border-purple-500' : 'text-gray-700' }}">
                                            <i class="fas fa-shield-alt mr-3 text-purple-500"></i>
                                            Administrateur
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="px-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="role" value="formateur">
                                        <input type="hidden" name="nom" value="{{ $user->nom }}">
                                        <button type="submit" 
                                                class="w-full text-left px-4 py-3 text-sm hover:bg-green-50 rounded-lg flex items-center transition-all duration-200 {{ $user->role == 'formateur' ? 'bg-green-50 text-green-700 border-l-4 border-green-500' : 'text-gray-700' }}">
                                            <i class="fas fa-chalkboard-teacher mr-3 text-green-500"></i>
                                            Formateur
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.users.update', $user) }}" method="POST" class="px-2">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="role" value="participant">
                                        <input type="hidden" name="nom" value="{{ $user->nom }}">
                                        <button type="submit" 
                                                class="w-full text-left px-4 py-3 text-sm hover:bg-orange-50 rounded-lg flex items-center transition-all duration-200 {{ $user->role == 'participant' ? 'bg-orange-50 text-orange-700 border-l-4 border-orange-500' : 'text-gray-700' }}">
                                            <i class="fas fa-user-graduate mr-3 text-orange-500"></i>
                                            Participant
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td class="py-5 px-6">
                        @if($user->isFormateur())
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-briefcase text-green-500 text-sm"></i>
                                    <span class="font-medium text-sm">{{ $user->specialite ?? 'Non spécifié' }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-clock text-gray-400 text-sm"></i>
                                    <span class="text-gray-600 text-xs">{{ $user->getFormattedExperienceAttribute() }}</span>
                                </div>
                            </div>
                        @elseif($user->isParticipant())
                            <div class="space-y-2">
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-chart-line text-orange-500 text-sm"></i>
                                    <span class="font-medium text-sm">{{ $user->niveau ?? 'Non spécifié' }}</span>
                                </div>
                                @if($user->pronoms)
                                <div class="flex items-center space-x-2">
                                    <i class="fas fa-user-tag text-gray-400 text-sm"></i>
                                    <span class="text-gray-600 text-xs">{{ $user->pronoms }}</span>
                                </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center text-gray-400 py-2">
                                <i class="fas fa-info-circle text-lg"></i>
                                <p class="text-sm mt-1">Aucune information spécifique</p>
                            </div>
                        @endif
                    </td>
                    <td class="py-5 px-6">
                        @if($user->est_actif)
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold bg-green-100 text-green-800 border border-green-300 transform group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-check-circle mr-2"></i>
                                Actif
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-2 rounded-full text-sm font-semibold bg-red-100 text-red-800 border border-red-300 transform group-hover:scale-105 transition-transform duration-300">
                                <i class="fas fa-times-circle mr-2"></i>
                                Inactif
                            </span>
                        @endif
                    </td>
                    <td class="py-5 px-6">
                        <div class="text-center bg-gray-50 p-3 rounded-lg border border-gray-200">
                            <div class="text-sm font-bold text-gray-900">{{ $user->created_at->format('d/m/Y') }}</div>
                            <div class="text-xs text-gray-500 mt-1">{{ $user->created_at->format('H:i') }}</div>
                        </div>
                    </td>
                    <td class="py-5 px-6 text-right">
                        <div class="flex items-center justify-end space-x-2">
                            <!-- Edit -->
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="group relative w-10 h-10 bg-green-100 hover:bg-green-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg" 
                               title="Modifier">
                                <i class="fas fa-edit text-green-600 group-hover:text-white transition-colors"></i>
                            </a>
                            
                            <!-- Toggle Status -->
                            @if($user->est_actif)
                                @if(auth()->id() === $user->id && $user->isAdmin())
                                    <span class="group relative w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center cursor-not-allowed" title="Vous ne pouvez pas vous désactiver">
                                        <i class="fas fa-user-slash text-gray-400"></i>
                                    </span>
                                @else
                                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                        @csrf
                                        <button type="submit" 
                                                class="group relative w-10 h-10 bg-red-100 hover:bg-red-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg"
                                                title="Désactiver"
                                                onclick="return confirm('Êtes-vous sûr de vouloir désactiver cet utilisateur ?')">
                                            <i class="fas fa-user-slash text-red-600 group-hover:text-white transition-colors"></i>
                                        </button>
                                    </form>
                                @endif
                            @else
                                <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                                    @csrf
                                    <button type="submit" 
                                            class="group relative w-10 h-10 bg-green-100 hover:bg-green-500 rounded-xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:shadow-lg"
                                            title="Activer"
                                            onclick="return confirm('Êtes-vous sûr de vouloir activer cet utilisateur ?')">
                                        <i class="fas fa-user-check text-green-600 group-hover:text-white transition-colors"></i>
                                    </button>
                                </form>
                            @endif
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
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Aucun utilisateur trouvé</h3>
                            <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche</p>
                            <a href="{{ route('admin.users.index') }}" 
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

    <!-- Enhanced Pagination -->
    @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600 font-medium">
                    Affichage de {{ $users->firstItem() }} à {{ $users->lastItem() }} sur {{ $users->total() }} utilisateurs
                </div>
                <div class="flex items-center space-x-2">
                    @if($users->onFirstPage())
                        <span class="px-4 py-2 border border-gray-300 rounded-xl text-gray-400 cursor-not-allowed">
                            <i class="fas fa-chevron-left mr-2"></i>Précédent
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" 
                           class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            <i class="fas fa-chevron-left mr-2"></i>Précédent
                        </a>
                    @endif
                    
                    <div class="flex items-center space-x-1">
                        @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                            @if($page == $users->currentPage())
                                <span class="px-4 py-2 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl font-semibold shadow-lg">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" 
                                   class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                                    {{ $page }}
                                </a>
                            @endif
                        @endforeach
                    </div>

                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" 
                           class="px-4 py-2 border border-gray-300 rounded-xl text-gray-700 hover:bg-white hover:shadow-lg transition-all duration-300 transform hover:scale-105">
                            Suivant<i class="fas fa-chevron-right ml-2"></i>
                        </a>
                    @else
                        <span class="px-4 py-2 border border-gray-300 rounded-xl text-gray-400 cursor-not-allowed">
                            Suivant<i class="fas fa-chevron-right ml-2"></i>
                        </span>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Photo Modal -->
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
                    <p>Cet utilisateur n'a pas encore uploadé de photo de profil.</p>
                    <p class="text-sm">L'avatar par défaut est généré à partir des initiales.</p>
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

@push('scripts')
<script>
// Role dropdown functionality
function toggleRoleDropdown(button) {
    const dropdown = button.nextElementSibling;
    const isHidden = dropdown.classList.contains('hidden');
    
    // Close all other dropdowns
    document.querySelectorAll('.role-dropdown-menu').forEach(menu => {
        if (menu !== dropdown) {
            menu.classList.add('hidden', 'scale-95', 'opacity-0');
        }
    });
    
    // Toggle current dropdown
    if (isHidden) {
        dropdown.classList.remove('hidden');
        setTimeout(() => {
            dropdown.classList.remove('scale-95', 'opacity-0');
        }, 10);
    } else {
        dropdown.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            dropdown.classList.add('hidden');
        }, 300);
    }
}

// Close dropdowns when clicking outside
document.addEventListener('click', function(e) {
    if (!e.target.closest('.relative')) {
        document.querySelectorAll('.role-dropdown-menu').forEach(menu => {
            menu.classList.add('scale-95', 'opacity-0');
            setTimeout(() => {
                menu.classList.add('hidden');
            }, 300);
        });
    }
});

// Photo modal functions
function showPhotoModal(photoUrl, userName) {
    const modal = document.getElementById('photoModal');
    const image = document.getElementById('photoModalImage');
    const title = document.getElementById('photoModalTitle');
    
    image.src = photoUrl;
    title.textContent = 'Photo de ' + userName;
    
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

// Role change confirmation
document.addEventListener('submit', function(e) {
    if (e.target.closest('form') && e.target.querySelector('input[name="role"]')) {
        const form = e.target;
        const newRole = form.querySelector('input[name="role"]').value;
        const userName = form.closest('tr').querySelector('.font-bold').textContent;
        
        if (!confirm(`Êtes-vous sûr de vouloir changer le rôle de ${userName} en ${newRole} ?`)) {
            e.preventDefault();
        }
    }
});

// Initialize animations
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

/* Smooth transitions */
* {
    transition-property: color, background-color, border-color, transform, box-shadow, opacity;
    transition-duration: 300ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}

/* Role dropdown animations */
.role-dropdown-menu {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Custom scrollbar */
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
@endpush