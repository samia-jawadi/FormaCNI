@extends('layouts.participant')

@section('title', 'Tableau de Bord - FormaCNI')

@section('page-title', 'Tableau de Bord Participant')

@section('content')
<!-- Welcome Section -->
<div class="mb-8">
    <div class="card p-6 bg-gradient-to-r from-emerald-500 to-teal-600 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold mb-2">Bienvenue, {{ Auth::user()->nom }}!</h2>
                <p class="text-emerald-100">Découvrez de nouvelles formations et développez vos compétences</p>
            </div>
            <div class="text-4xl opacity-20">
                <i class="fas fa-graduation-cap"></i>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
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
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-book text-xl"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Inscriptions</p>
                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ Auth::user()->inscriptions()->count() }}
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

<!-- Main Content Grid -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Recent Formations -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mes Formations Récentes</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    @forelse(Auth::user()->formationsInscrites()->take(5)->get() as $formation)
                    <div class="flex items-center justify-between p-4 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                        <div class="flex items-center space-x-4">
                            <div class="w-10 h-10 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full flex items-center justify-center">
                                <i class="fas fa-book text-white text-sm"></i>
                            </div>
                            <div>
                                <h4 class="font-medium text-gray-900 dark:text-white">{{ $formation->titre }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Par {{ $formation->formateur->nom }} • {{ $formation->date_formatee }}
                                </p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @php($label = $formation->terminee ? 'Terminée' : $formation->pivot->statut)
    <span class="badge {{ $formation->terminee ? 'badge-danger' : ($formation->pivot->statut == 'CONFIRMEE' ? 'badge-success' : ($formation->pivot->statut == 'EN_ATTENTE' ? 'badge-warning' : 'badge-info')) }}">
                                {{ $label }}
                            </span>
                            <a href="{{ route('formations.show', $formation) }}" class="text-emerald-600 hover:text-emerald-800">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <i class="fas fa-book-open text-4xl text-gray-400 mb-4"></i>
                        <p class="text-gray-600 dark:text-gray-400 mb-4">Aucune formation pour le moment</p>
                        <a href="{{ route('formations.index') }}" class="btn-primary px-6 py-2 rounded-lg inline-flex items-center">
                            <i class="fas fa-search mr-2"></i>
                            Parcourir les formations
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div>
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Actions Rapides</h3>
            </div>
            <div class="p-6">
                <div class="space-y-4">
                    <a href="{{ route('formations.index') }}" class="flex items-center p-4 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/30 rounded-lg transition-colors group">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-search text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-emerald-900 dark:text-emerald-100">Parcourir Formations</h4>
                            <p class="text-sm text-emerald-600 dark:text-emerald-400">Découvrez nouvelles formations</p>
                        </div>
                    </a>

                    <a href="{{ route('participant.formations') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 rounded-lg transition-colors group">
                        <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-book text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-blue-900 dark:text-blue-100">Mes Formations</h4>
                            <p class="text-sm text-blue-600 dark:text-blue-400">Gérer mes inscriptions</p>
                        </div>
                    </a>

                    <a href="{{ route('profile.show') }}" class="flex items-center p-4 bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 dark:hover:bg-purple-900/30 rounded-lg transition-colors group">
                        <div class="w-10 h-10 bg-purple-500 rounded-lg flex items-center justify-center mr-4 group-hover:scale-110 transition-transform">
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-medium text-purple-900 dark:text-purple-100">Mon Profil</h4>
                            <p class="text-sm text-purple-600 dark:text-purple-400">Modifier mes informations</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <!-- Progress Overview -->
        <div class="card mt-6">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Progression</h3>
            </div>
            <div class="p-6">
                <?php
                    $totalInscriptions = Auth::user()->inscriptions()->count();
                    $completedFormations = Auth::user()->inscriptions()->whereHas('formation', function($q) { $q->where('terminee', true); })->count();
                    $progressPercentage = $totalInscriptions > 0 ? round(($completedFormations / $totalInscriptions) * 100) : 0;
                ?>
                <div class="text-center">
                    <div class="relative w-20 h-20 mx-auto mb-4">
                        <svg class="w-20 h-20 transform -rotate-90" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                  fill="none" stroke="#e5e7eb" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                  fill="none" stroke="#10b981" stroke-width="3"
                                  stroke-dasharray="{{ $progressPercentage }}, 100"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-xl font-bold text-emerald-600">{{ $progressPercentage }}%</span>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Formations terminées</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">{{ $completedFormations }} sur {{ $totalInscriptions }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
