@extends('layouts.participant')

@section('title', 'Mes Formations - FormaCNI')

@section('page-title', 'Mes Formations')

@section('content')
<div class="mb-6">
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">Mes Formations</h2>
            <p class="text-gray-600 dark:text-gray-400">Gérez vos formations et découvrez de nouvelles opportunités</p>
        </div>
        <a href="{{ route('formations.index') }}" class="btn-primary px-6 py-3 rounded-lg inline-flex items-center">
            <i class="fas fa-plus mr-2"></i>
            Parcourir Formations
        </a>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="card p-6">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 mr-4">
                <i class="fas fa-check-circle text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Formations Confirmées</p>
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
            <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                <i class="fas fa-star text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Formations Terminées</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ Auth::user()->inscriptions()->whereHas('formation', function($q) { $q->where('terminee', true); })->count() }}
                </p>
            </div>
        </div>
    </div>
</div>

<!-- My Formations List -->
<div class="card">
    <div class="p-6">
        <div class="space-y-4">
            @forelse(Auth::user()->formationsInscrites as $formation)
            <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-6 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $formation->titre }}</h3>
                            <span class="badge {{ $formation->pivot->statut == 'CONFIRMEE' ? 'badge-success' : 'badge-warning' }}">
                                {{ $formation->pivot->statut }}
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="far fa-calendar-alt mr-2"></i>
                                <span>{{ $formation->date_formatee }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-user mr-2"></i>
                                <span>{{ $formation->formateur->nom }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-clock mr-2"></i>
                                <span>{{ $formation->duree_formatee }}</span>
                            </div>
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-users mr-2"></i>
                                <span>{{ $formation->getNombreInscriptions() }}/{{ $formation->capacite_max }}</span>
                            </div>
                        </div>
                        
                        <p class="text-gray-600 dark:text-gray-400 mb-4">{{ Str::limit($formation->description, 150) }}</p>
                        
                        <div class="flex items-center space-x-3">
                            <a href="{{ route('formations.show', $formation) }}" class="text-emerald-600 hover:text-emerald-800 font-medium">
                                <i class="fas fa-eye mr-1"></i>Voir détails
                            </a>
                            @if($formation->pivot->statut == 'CONFIRMEE')
                                <span class="text-emerald-600">
                                    <i class="fas fa-check-circle mr-1"></i>Inscription confirmée
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12">
                <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Aucune inscription</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">Vous n'êtes inscrit(e) à aucune formation pour le moment</p>
                <a href="{{ route('formations.index') }}" class="btn-primary px-6 py-3 rounded-lg inline-flex items-center">
                    <i class="fas fa-search mr-2"></i>
                    Découvrir les formations
                </a>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

