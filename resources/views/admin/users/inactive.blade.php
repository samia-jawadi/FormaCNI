@extends('admin.dashboard')

@section('title', 'Comptes Désactivés - FormaCNI')
@section('page-title', 'Historique des Comptes Désactivés')

@section('content')
<div class="mb-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold">Comptes Désactivés</h2>
            <p class="text-gray-600 dark:text-gray-400">Historique des utilisateurs désactivés</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn-secondary py-2 px-4 rounded-lg">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour aux utilisateurs
        </a>
    </div>
</div>

<div class="card p-6">
    <div class="table-container">
        <table class="w-full">
            <thead class="table-header">
                <tr>
                    <th class="py-3 px-4 text-left">Utilisateur</th>
                    <th class="py-3 px-4 text-left">Rôle</th>
                    <th class="py-3 px-4 text-left">Date de désactivation</th>
                    <th class="py-3 px-4 text-left">Raison</th>
                    <th class="py-3 px-4 text-left">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($users as $user)
                <tr class="table-row">
                    <td class="py-3 px-4">
                        <div class="flex items-center space-x-3">
                            @if($user->photo)
                                <img src="{{ asset('storage/' . $user->photo) }}" 
                                     alt="Photo de profil" 
                                     class="w-10 h-10 rounded-full object-cover border border-gray-300">
                            @else
                                <div class="w-10 h-10 bg-gradient-to-r from-gray-500 to-gray-700 rounded-full flex items-center justify-center text-white font-semibold">
                                    {{ $user->initials }}
                                </div>
                            @endif
                            <div>
                                <p class="font-medium">{{ $user->nom }}</p>
                                <p class="text-sm text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="py-3 px-4">
                        <span class="badge {{ $user->role_badge }} capitalize">
                            {{ $user->role }}
                        </span>
                    </td>
                    <td class="py-3 px-4">
                        {{ $user->updated_at->format('d/m/Y H:i') }}
                    </td>
                    <td class="py-3 px-4">
                        <span class="text-sm text-gray-500">Désactivé par l'administrateur</span>
                    </td>
                    <td class="py-3 px-4">
                        <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" 
                                    class="text-green-600 hover:text-green-800"
                                    title="Réactiver"
                                    onclick="return confirm('Êtes-vous sûr de vouloir réactiver cet utilisateur ?')">
                                <i class="fas fa-user-check"></i> Réactiver
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-8 text-center text-gray-500">
                        <i class="fas fa-archive text-3xl mb-2"></i>
                        <p>Aucun compte désactivé</p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection