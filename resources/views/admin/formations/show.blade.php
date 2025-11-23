@extends('admin.dashboard')

@section('title', 'Détails Formation - FormaCNI')
@section('page-title', 'Détails de la formation')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.formations.index') }}" class="btn-secondary py-2 px-4 rounded-lg inline-flex items-center">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour aux formations
        </a>
        <a href="{{ route('admin.formations.edit', $formation) }}" class="btn-primary py-2 px-4 rounded-lg inline-flex items-center">
            <i class="fas fa-edit mr-2"></i>
            Modifier
        </a>
    </div>

    <div class="card p-6">
        <div class="mb-4">
            <h2 class="text-2xl font-bold text-readable">{{ $formation->titre }}</h2>
            <p class="text-muted mt-2">{{ $formation->description }}</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-sm text-muted">Formateur</p>
                <p class="text-lg font-semibold text-readable">{{ optional($formation->formateur)->nom ?? '-' }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-sm text-muted">Statut</p>
                <p class="text-lg font-semibold text-readable">
                    {{ $formation->terminee ? 'TERMINEE' : $formation->statut }}
                </p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-sm text-muted">Durée</p>
                <p class="text-lg font-semibold text-readable">{{ $formation->duree }} h</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-sm text-muted">Heure de début</p>
                <p class="text-lg font-semibold text-readable">{{ $formation->heure_debut ?? '-' }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-sm text-muted">Date début</p>
                <p class="text-lg font-semibold text-readable">{{ optional($formation->date_debut)->format('d/m/Y') }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-sm text-muted">Date fin</p>
                <p class="text-lg font-semibold text-readable">{{ optional($formation->date_fin)->format('d/m/Y') }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-sm text-muted">Capacité maximale</p>
                <p class="text-lg font-semibold text-readable">{{ $formation->capacite_max }}</p>
            </div>
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <p class="text-sm text-muted">Inscriptions</p>
                <p class="text-lg font-semibold text-readable">{{ $formation->inscriptions_count ?? 0 }}</p>
            </div>
        </div>
    </div>

    @if(($formation->participants_count ?? 0) > 0)
    <div class="card p-6">
        <h3 class="text-lg font-semibold mb-4">Participants ({{ $formation->participants_count }})</h3>
        <div class="space-y-3">
            @foreach($formation->participants as $participant)
                <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                            {{ strtoupper(substr($participant->nom, 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-medium text-readable">{{ $participant->nom }}</p>
                            <p class="text-sm text-muted">{{ $participant->email }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
