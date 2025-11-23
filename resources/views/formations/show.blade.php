@extends('layouts.participant')

@section('title', $formation->titre . ' - FormaCNI')

@section('page-title', 'Détails de la Formation')

@section('content')
<!-- Formation Header -->
<div class="mb-8">
    <div class="card p-6 bg-gradient-to-r from-blue-500 to-emerald-600 text-white">
        <div class="flex justify-between items-start">
            <div class="flex-1">
                <div class="flex items-center space-x-4 mb-4">
                    <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <i class="fas fa-graduation-cap text-white text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold mb-2">{{ $formation->titre }}</h1>
                        <p class="text-blue-100 text-lg">Formation {{ $formation->niveau ?? 'Tous niveaux' }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-user text-blue-200"></i>
                        <div>
                            <p class="text-blue-100 text-sm">Formateur</p>
                            <p class="font-semibold">{{ $formation->formateur->nom }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-calendar text-blue-200"></i>
                        <div>
                            <p class="text-blue-100 text-sm">Période</p>
                            <p class="font-semibold">{{ $formation->date_formatee }}</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <i class="fas fa-clock text-blue-200"></i>
                        <div>
                            <p class="text-blue-100 text-sm">Durée</p>
                            <p class="font-semibold">{{ $formation->duree_formatee }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="ml-8">
                @if($formation->terminee)
                    @if(Auth::user()->formationsInscrites->contains($formation->id))
                        <div class="bg-purple-500/20 text-white px-8 py-3 rounded-lg font-bold border border-white/30">
                            <i class="fas fa-flag-checkered mr-2"></i>Cette formation est terminée.
                        </div>
                    @else
                        <div class="bg-red-500/20 text-white px-8 py-3 rounded-lg font-bold border border-white/30">
                            <i class="fas fa-times mr-2"></i>Non disponible
                        </div>
                    @endif
                @elseif($formation->peutEtreInscrit() && !Auth::user()->formationsInscrites->contains($formation->id))
                    <form action="{{ route('inscriptions.store', $formation) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-blue-50 transition-colors">
                            <i class="fas fa-plus mr-2"></i>S'inscrire maintenant
                        </button>
                    </form>
                @elseif(Auth::user()->formationsInscrites->contains($formation->id))
                    <div class="bg-emerald-500/20 text-white px-8 py-3 rounded-lg font-bold border border-white/30">
                        <i class="fas fa-check mr-2"></i>Déjà inscrit(e)
                    </div>
                @else
                    <div class="bg-red-500/20 text-white px-8 py-3 rounded-lg font-bold border border-white/30">
                        <i class="fas fa-times mr-2"></i>Non disponible
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-8">
        <!-- Description -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-info-circle mr-2"></i>Description de la Formation
                </h2>
            </div>
            <div class="p-6">
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-lg">
                    {{ $formation->description }}
                </p>
            </div>
        </div>

        <!-- Formateur Info -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-user-tie mr-2"></i>À propos du Formateur
                </h2>
            </div>
            <div class="p-6">
                <div class="flex items-start space-x-6">
                    <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-emerald-500 rounded-full flex items-center justify-center">
                        <i class="fas fa-user text-white text-2xl"></i>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $formation->formateur->nom }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            @if($formation->formateur->specialite)
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-star mr-2"></i>
                                <span><strong>Spécialité:</strong> {{ $formation->formateur->specialite }}</span>
                            </div>
                            @endif
                            
                            @if($formation->formateur->experience)
                            <div class="flex items-center text-gray-600 dark:text-gray-400">
                                <i class="fas fa-briefcase mr-2"></i>
                                <span><strong>Expérience:</strong> {{ $formation->formateur->formatted_experience }}</span>
                            </div>
                            @endif
                        </div>
                        
                        <div class="flex items-center space-x-4">
                            <span class="badge badge-info">Formateur Certifié</span>
                            <span class="text-sm text-gray-500">
                                {{ $formation->formateur->formations_count ?? 0 }} formations données
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Autres formations du même formateur -->
        @php
            $autresFormations = $formation->formateur->formations()
                ->where('id', '!=', $formation->id)
                ->where('statut', 'ACTIVE')
                ->where('terminee', false)
                ->take(3)
                ->get();
        @endphp
        
        @if($autresFormations->count() > 0)
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">
                    <i class="fas fa-book mr-2"></i>Autres Formations du Formateur
                </h2>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($autresFormations as $autreFormation)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 hover:shadow-md transition-all">
                        <h4 class="font-semibold text-gray-900 dark:text-white mb-2">{{ $autreFormation->titre }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ Str::limit($autreFormation->description, 80) }}</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xs text-gray-500">{{ $autreFormation->date_formatee }}</span>
                            <a href="{{ route('formations.show', $autreFormation) }}" class="text-blue-600 hover:text-blue-800 text-sm">
                                Voir détails →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Formation Status -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">État de la Formation</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Statut</span>
                    <span class="badge {{ $formation->statut == 'ACTIVE' ? 'badge-success' : 'badge-warning' }}">
                        {{ $formation->statut_libelle }}
                    </span>
                </div>
                
                <div class="flex justify-between items-center">
                    <span class="text-gray-600 dark:text-gray-400">Places occupées</span>
                    <span class="font-semibold">{{ $formation->getNombreInscriptions() }}/{{ $formation->capacite_max }}</span>
                </div>
                
                <div>
                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                        <span>Progression</span>
                        <span>{{ $formation->progression }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-3">
                        <div class="bg-gradient-to-r from-blue-500 to-emerald-500 h-3 rounded-full transition-all duration-300" 
                             style="width: {{ $formation->progression }}%"></div>
                    </div>
                </div>
                
                <div class="pt-2">
                    @if($formation->terminee)
                        <span class="badge badge-danger w-full text-center">Formation Terminée</span>
                    @elseif($formation->estComplete())
                        <span class="badge badge-warning w-full text-center">Formation Complète</span>
                    @elseif($formation->peutEtreInscrit())
                        <span class="badge badge-success w-full text-center">Places Disponibles</span>
                    @else
                        <span class="badge badge-danger w-full text-center">Inscription Fermée</span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Formation Details -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Détails</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center space-x-3">
                    <i class="fas fa-calendar-alt text-blue-500"></i>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Date de début</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ optional($formation->date_debut)->format('d M Y') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <i class="fas fa-calendar-check text-emerald-500"></i>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Date de fin</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ optional($formation->date_fin)->format('d M Y') }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <i class="fas fa-clock text-purple-500"></i>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Heure</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $formation->heure_debut_formattee }}</p>
                    </div>
                </div>
                
                <div class="flex items-center space-x-3">
                    <i class="fas fa-users text-yellow-500"></i>
                    <div>
                        <p class="font-medium text-gray-900 dark:text-white">Capacité maximale</p>
                        <p class="text-gray-600 dark:text-gray-400">{{ $formation->capacite_max }} participants</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Actions Rapides</h3>
            </div>
            <div class="p-6 space-y-3">
                <a href="{{ route('formations.index') }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                    <i class="fas fa-arrow-left text-blue-600 mr-3"></i>
                    <span class="text-blue-700 dark:text-blue-300">Retour aux formations</span>
                </a>
                
                @if(Auth::user()->formationsInscrites->contains($formation->id))
                <a href="{{ route('participant.inscriptions') }}" class="flex items-center p-3 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-900/20 dark:hover:bg-emerald-900/30 rounded-lg transition-colors">
                    <i class="fas fa-list text-emerald-600 mr-3"></i>
                    <span class="text-emerald-700 dark:text-emerald-300">Mes inscriptions</span>
                </a>
                @endif
                
                <a href="{{ route('participant.dashboard') }}" class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 dark:hover:bg-purple-900/30 rounded-lg transition-colors">
                    <i class="fas fa-tachometer-alt text-purple-600 mr-3"></i>
                    <span class="text-purple-700 dark:text-purple-300">Tableau de bord</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection