@extends('admin.dashboard')

@section('title', 'Tableau de Bord - FormaCNI')
@section('page-title', 'Tableau de Bord')

@section('content')
<!-- Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
    <div class="stat-card gradient-animated p-6 rounded-xl hover-glow animate-in">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100">Participants Totaux</p>
                <p class="text-3xl font-bold mt-2" data-count="{{ $totalParticipants }}">0</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
        </div>
        <div class="flex items-center mt-4 text-blue-100">
            <span class="relative inline-flex mr-2">
                <span class="animate-ping absolute inline-flex h-2 w-2 rounded-full bg-white opacity-75"></span>
                <span class="relative inline-flex rounded-full h-2 w-2 bg-white"></span>
            </span>
            <i class="fas fa-arrow-up mr-1"></i>
            <span class="text-sm" data-count="{{ $newParticipantsThisMonth }}">0 ce mois</span>
        </div>
    </div>


    <div class="stat-card gradient-animated p-6 rounded-xl hover-glow animate-in animate-in-delay-1">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100">Formations en Cours</p>
                <p class="text-3xl font-bold mt-2" data-count="{{ $formationsEnCours }}">0</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-play-circle text-xl"></i>
            </div>
        </div>
        <div class="flex items-center mt-4 text-blue-100">
            <i class="fas fa-users mr-1"></i>
            <span class="text-sm"><span data-count="{{ $participantsActifs }}">0</span> participants actifs</span>
        </div>
    </div>

    <div class="stat-card gradient-animated p-6 rounded-xl hover-glow animate-in animate-in-delay-2">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-blue-100">Validations en Attente</p>
                <p class="text-3xl font-bold mt-2" data-count="{{ $validationsEnAttente }}">0</p>
            </div>
            <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                <i class="fas fa-clock text-xl"></i>
            </div>
        </div>
        <div class="flex items-center mt-4 text-blue-100">
            <i class="fas fa-exclamation-circle mr-1"></i>
            <span class="text-sm"><span data-count="{{ $demandesEnAttente }}">0</span> demandes</span>
        </div>
    </div>
</div>

<!-- Quick Actions & Recent Activity -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Quick Actions -->
    <div class="card p-6">
        <h3 class="text-lg font-semibold mb-4">Actions Rapides</h3>
        <div class="space-y-3">
            <a href="{{ route('admin.users.create') }}" class="w-full btn-primary py-3 px-4 rounded-lg flex items-center justify-center space-x-2 block">
                <i class="fas fa-user-plus"></i>
                <span>Ajouter Utilisateur</span>
            </a>
            <a href="{{ route('admin.users.index') }}" class="w-full bg-green-500 hover:bg-green-600 text-white py-3 px-4 rounded-lg flex items-center justify-center space-x-2 transition-colors block">
                <i class="fas fa-user-edit"></i>
                <span>Gérer Utilisateurs</span>
            </a>
            <a href="{{ route('admin.formations.index') }}" class="w-full bg-purple-500 hover:bg-purple-600 text-white py-3 px-4 rounded-lg flex items-center justify-center space-x-2 transition-colors block">
                <i class="fas fa-book"></i>
                <span>Gérer Formations</span>
            </a>
            <a href="{{ route('admin.analytics') }}" class="w-full bg-indigo-500 hover:bg-indigo-600 text-white py-3 px-4 rounded-lg flex items-center justify-center space-x-2 transition-colors block">
                <i class="fas fa-chart-bar"></i>
                <span>Voir Rapports</span>
            </a>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Activité Récente</h3>
            <span class="text-xs text-gray-800 dark:text-gray-500">Mise à jour en temps réel</span>
        </div>
        <div class="space-y-3">
            @forelse($recentActivities as $activity)
            <div class="flex items-start space-x-3 p-3 {{ $activity['bg'] ?? 'bg-gray-50' }} dark:bg-opacity-20 rounded-lg hover:shadow-sm transition-all duration-200">
                <div class="w-10 h-10 {{ str_replace('text-', 'bg-', $activity['color'] ?? 'bg-gray-500') }} rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="{{ $activity['icon'] ?? 'fas fa-bell' }} text-white text-sm"></i>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium {{ $activity['color'] ?? 'text-gray-900' }} leading-tight">
                                {{ $activity['message'] }}
                            </p>
                            @if(isset($activity['details']))
                                <p class="text-xs text-gray-900 dark:text-gray-600 mt-1 leading-relaxed">
                                    {{ $activity['details'] }}
                                </p>
                            @endif
                        </div>
                        <div class="ml-2 flex-shrink-0">
                            <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium 
                                @if($activity['priority'] == 1) bg-red-100 text-red-800
                                @elseif($activity['priority'] == 2) bg-yellow-100 text-yellow-800  
                                @else bg-gray-100 text-gray-600 @endif">
                                @if($activity['priority'] == 1) <i class="fas fa-circle text-red-500 mr-1" style="font-size: 6px;"></i> @endif
                                {{ $activity['time'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center text-gray-800 dark:text-gray-500 py-8">
                <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center">
                    <i class="fas fa-history text-2xl text-gray-400"></i>
                </div>
                <h4 class="font-medium text-gray-900 dark:text-white mb-1">Aucune activité récente</h4>
                <p class="text-sm text-gray-800 dark:text-gray-500">Les dernières actions apparaitront ici</p>
            </div>
            @endforelse
        </div>
        
        @if(count($recentActivities) > 0)
        <div class="mt-4 pt-4 border-t border-gray-200">
            <div class="flex items-center justify-center">
                <button class="text-sm text-blue-600 hover:text-blue-800 font-medium flex items-center"
                        onclick="location.reload()">
                    <i class="fas fa-sync-alt mr-1"></i>
                    Actualiser
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Formations en Attente Section -->
<div class="mt-6">
    <div class="card p-6">
        <div class="flex items-center justify-between mb-6">
            <h3 class="text-lg font-semibold">Formations en Attente de Validation</h3>
            <div class="flex items-center space-x-4">
                <span class="bg-yellow-500 text-white text-sm px-3 py-1 rounded-full">
                    {{ $pendingFormations->count() }} en attente
                </span>
                <a href="{{ route('admin.formations.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Voir toutes →
                </a>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($pendingFormations as $formation)
            <div class="border border-yellow-200 rounded-lg p-4 bg-yellow-50 dark:bg-yellow-900/20">
                <div class="flex items-start justify-between mb-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-yellow-500 rounded-lg flex items-center justify-center">
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm">{{ Str::limit($formation->titre, 40) }}</h4>
                            <p class="text-xs text-gray-800 dark:text-gray-500">Par {{ $formation->formateur->nom }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="space-y-2 text-xs text-gray-900 dark:text-gray-600">
                    <div class="flex justify-between">
                        <span>Durée:</span>
                        <span class="font-medium">{{ $formation->duree }}h</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Date début:</span>
                        <span class="font-medium">{{ $formation->date_debut->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Capacité:</span>
                        <span class="font-medium">{{ $formation->capacite_max }} places</span>
                    </div>
                </div>
                
                <div class="flex justify-between items-center mt-4 pt-3 border-t border-yellow-200">
                    <span class="text-xs text-gray-500">
                        {{ $formation->created_at->locale('fr')->diffForHumans() }}
                    </span>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.formations.edit', $formation) }}" 
                           class="text-blue-600 hover:text-blue-800 text-sm" title="Modifier">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.formations.update', $formation) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="statut" value="ACTIVE">
                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm" title="Valider">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center text-gray-500 py-8">
                <i class="fas fa-check-circle text-4xl mb-3 text-green-500"></i>
                <p class="text-lg font-medium">Aucune formation en attente</p>
                <p class="text-sm">Toutes les formations sont validées</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection