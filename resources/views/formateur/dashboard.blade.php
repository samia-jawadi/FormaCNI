@extends('layouts.formateur')

@section('title', 'Dashboard')

@section('page-title', 'Tableau de Bord Formateur')

@section('content')

<!-- Header Section similar to admin -->
<div class="mb-6 flex justify-between items-center flex-wrap gap-4">
  <div>
    <h2 class="text-2xl font-bold">Bienvenue, {{ auth()->user()->nom }}</h2>
    <p class="text-gray-600">Gérez vos formations et suivez vos statistiques</p>
  </div>
  <div class="flex items-center space-x-3">
    <div class="flex items-center space-x-2 mr-3">
      <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 via-emerald-500 to-purple-600 animate-pulse flex items-center justify-center text-white font-bold">CNI</div>
      <div class="font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-emerald-600 to-purple-600">
        FormaCNI
      </div>
    </div>
    <a href="{{ route('formateur.formations.create') }}" class="inline-flex items-center px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
      <i class="fas fa-plus mr-2"></i> Nouvelle formation
    </a>
    <a href="{{ route('formateur.formations.index') }}" class="btn-secondary inline-flex items-center">
      <i class="fas fa-list mr-2"></i> Mes formations
    </a>
  </div>
</div>

<!-- Stat Cards (admin-like gradient) -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
  <div class="rounded-xl p-5 text-white shadow stat-card" style="background: linear-gradient(135deg,#667eea,#764ba2)">
    <div class="flex items-center justify-between">
      <div>
        <p class="opacity-90 text-sm">Formations (plateforme)</p>
        <p class="text-3xl font-bold">{{ $stats['total_formations'] ?? 0 }}</p>
      </div>
      <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
        <i class="fas fa-graduation-cap"></i>
      </div>
    </div>
  </div>
  <div class="rounded-xl p-5 text-white shadow stat-card" style="background: linear-gradient(135deg,#10b981,#059669)">
    <div class="flex items-center justify-between">
      <div>
        <p class="opacity-90 text-sm">Mes formations</p>
        <p class="text-3xl font-bold">{{ $stats['my_formations'] ?? 0 }}</p>
      </div>
      <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
        <i class="fas fa-chalkboard-teacher"></i>
      </div>
    </div>
  </div>
  <div class="rounded-xl p-5 text-white shadow stat-card" style="background: linear-gradient(135deg,#f59e0b,#d97706)">
    <div class="flex items-center justify-between">
      <div>
        <p class="opacity-90 text-sm">Participants</p>
        <p class="text-3xl font-bold">{{ $stats['total_participants'] ?? 0 }}</p>
      </div>
      <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
        <i class="fas fa-users"></i>
      </div>
    </div>
  </div>
</div>

<!-- Two Columns: Available formations (readonly) and My recent formations -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
  <!-- Available formations table (admin-like) -->
  <div class="lg:col-span-2">
    <div class="table-container card">
      <div class="flex items-center justify-between px-5 py-4 border-b bg-gray-50">
        <h3 class="font-semibold">Formations disponibles (lecture seule)</h3>
        @if($allFormations->hasPages())
          <div class="text-sm text-gray-500">Page {{ $allFormations->currentPage() }} / {{ $allFormations->lastPage() }}</div>
        @endif
      </div>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
          <thead class="table-header">
            <tr class="text-left text-gray-600">
              <th class="px-5 py-3">Titre</th>
              <th class="px-5 py-3">Formateur</th>
              <th class="px-5 py-3">Début</th>
              <th class="px-5 py-3">Durée</th>
              <th class="px-5 py-3">Participants</th>
              <th class="px-5 py-3">Statut</th>
            </tr>
          </thead>
          <tbody>
            @forelse($allFormations as $formation)
              <tr class="table-row border-t">
                <td class="px-5 py-3 font-medium text-gray-800">{{ $formation->titre }}</td>
                <td class="px-5 py-3 text-gray-700">
                  {{ optional($formation->formateur)->nom }} {{ optional($formation->formateur)->prenom }}
                </td>
                <td class="px-5 py-3 text-gray-700">{{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m/Y') }}</td>
                <td class="px-5 py-3 text-gray-700">{{ $formation->duree }} sem.</td>
                <td class="px-5 py-3 text-gray-700">{{ $formation->participants()->count() }} / {{ $formation->capacite_max }}</td>
                <td class="px-5 py-3">
                  @php($st = $formation->statut)
                  <span class="badge 
                    {{ $st === 'ACTIVE' ? 'badge-success' : '' }}
                    {{ $st === 'ATTENTE_VALIDATION' ? 'badge-warning' : '' }}
                    {{ in_array($st,['REFUSEE','TERMINEE']) ? 'badge-danger' : '' }}">
                    {{ ucfirst(strtolower($st)) }}
                  </span>
                </td>
              </tr>
            @empty
              <tr>
                <td class="px-5 py-6 text-center text-gray-500" colspan="6">Aucune formation disponible</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
      @if($allFormations->hasPages())
        <div class="px-5 py-4 border-t">
          {{ $allFormations->links() }}
        </div>
      @endif
    </div>
  </div>

  <!-- My recent formations -->
  <div>
    <div class="card rounded-xl overflow-hidden">
      <div class="px-5 py-4 border-b bg-gray-50">
        <h3 class="font-semibold">Mes formations récentes</h3>
      </div>
      <div class="p-5 space-y-4">
        @php($recent = $myFormations->take(5))
        @forelse($recent as $formation)
          <div class="flex items-center justify-between">
            <div>
              <p class="font-medium text-gray-800">{{ $formation->titre }}</p>
              <p class="text-xs text-gray-500">{{ $formation->participants()->count() }} participants • Début {{ \Carbon\Carbon::parse($formation->date_debut)->format('d/m') }}</p>
            </div>
            @php($st = $formation->terminee ? 'TERMINEE' : $formation->statut)
            <span class="badge 
              {{ $st === 'ACTIVE' ? 'badge-success' : '' }}
              {{ $st === 'ATTENTE_VALIDATION' ? 'badge-warning' : '' }}
              {{ $st === 'TERMINEE' ? 'badge-danger' : '' }}
            ">{{ $st === 'TERMINEE' ? 'Terminée' : $st }}</span>
          </div>
        @empty
          <div class="text-center text-gray-500 py-8">
            <i class="fas fa-inbox text-2xl mb-2"></i>
            <p>Aucune formation récente</p>
          </div>
        @endforelse
      </div>
      <div class="px-5 py-4 border-t bg-gray-50 text-right">
        <a href="{{ route('formateur.formations.index') }}" class="text-blue-600 hover:text-blue-700 text-sm">Voir toutes mes formations</a>
      </div>
    </div>
  </div>
</div>

@endsection
