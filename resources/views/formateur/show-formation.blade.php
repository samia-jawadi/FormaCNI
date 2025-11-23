@extends('layouts.formateur')

@section('title', 'Détails Formation')
@section('page-title', 'Détails de la formation')

@section('content')
<div class="space-y-6">
  <div class="card p-6">
    <div class="flex items-start justify-between">
      <div>
        <h2 class="text-2xl font-bold text-gray-900">{{ $formation->titre }}</h2>
        <p class="text-gray-600 mt-1">Par {{ optional($formation->formateur)->nom }} • {{ $formation->date_formatee }}</p>
      </div>
      <span class="px-3 py-1 rounded-full text-sm font-medium {{ $formation->terminee ? 'bg-purple-100 text-purple-800' : ($formation->statut==='ACTIVE' ? 'bg-green-100 text-green-800':'bg-yellow-100 text-yellow-800') }}">
        {{ $formation->terminee ? 'Terminée' : $formation->statut_libelle }}
      </span>
    </div>
    <div class="mt-4 text-gray-800 leading-relaxed">{{ $formation->description }}</div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6 text-sm text-gray-700">
      <div class="flex items-center"><i class="fas fa-clock mr-2 text-gray-400"></i>Durée: {{ $formation->duree_formatee }}</div>
      <div class="flex items-center"><i class="fas fa-users mr-2 text-gray-400"></i>Inscriptions: {{ $formation->getNombreInscriptions() }}/{{ $formation->capacite_max }}</div>
      <div class="flex items-center"><i class="fas fa-stopwatch mr-2 text-gray-400"></i>Heure: {{ $formation->heure_debut_formattee }}</div>
    </div>
    <div class="mt-6 flex items-center space-x-3">
      <a href="{{ route('formateur.formations.index') }}" class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-800">Retour</a>
      @if(!$formation->terminee)
      <a href="{{ route('formateur.formations.edit', $formation) }}" class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">Modifier</a>
      @endif
    </div>
  </div>

  <div class="card p-6">
    <h3 class="text-lg font-semibold mb-4">Participants ({{ $formation->participants()->count() }})</h3>
    @if($formation->participants()->count()===0)
      <p class="text-gray-500">Aucun participant.</p>
    @else
      <div class="space-y-2">
        @foreach($formation->participants as $p)
          <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div class="flex items-center space-x-3">
              <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white text-sm font-bold">{{ strtoupper(substr($p->nom,0,1)) }}</div>
              <div>
                <p class="font-medium text-gray-800">{{ $p->nom }}</p>
                <p class="text-xs text-gray-600">{{ $p->email }}</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
</div>
@endsection
