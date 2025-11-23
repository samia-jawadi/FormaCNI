@extends('admin.dashboard')

@section('title', 'Profil Utilisateur - FormaCNI')
@section('page-title', 'Profil Utilisateur')

@section('content')
<!-- Header Section -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.users.index') }}" 
               class="text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                <i class="fas fa-arrow-left text-xl"></i>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $user->nom }}</h1>
                <p class="text-gray-600 dark:text-gray-400">{{ ucfirst($user->role) }} • Membre depuis {{ $user->created_at->format('M Y') }}</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-3">
            @if($user->est_actif)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                    <div class="w-2 h-2 bg-green-400 rounded-full mr-2"></div>
                    En ligne
                </span>
            @elseif($user->deactivated_at)
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                    <i class="fas fa-user-times mr-2"></i>
                    Supprimé
                </span>
            @else
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                    <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                    Inactif
                </span>
            @endif
            
            <a href="{{ route('admin.users.edit', $user) }}" 
               class="btn-primary px-4 py-2 rounded-lg inline-flex items-center">
                <i class="fas fa-edit mr-2"></i>
                Modifier
            </a>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
    <!-- Profile Column -->
    <div class="xl:col-span-1">
        <!-- Profile Card -->
        <div class="card overflow-hidden">
            <div class="relative">
                <!-- Background gradient -->
                <div class="h-24 bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"></div>
                
                <!-- Profile photo -->
                <div class="absolute -bottom-12 left-6">
                    @if($user->photo)
                        <img src="{{ Storage::url($user->photo) }}" 
                             alt="{{ $user->nom }}"
                             class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover cursor-pointer"
                             onclick="showPhotoModal('{{ Storage::url($user->photo) }}', '{{ $user->nom }}')">  
                    @else
                        <div class="w-24 h-24 rounded-full border-4 border-white shadow-lg bg-gradient-to-br from-gray-400 to-gray-600 flex items-center justify-center">
                            <span class="text-white font-bold text-2xl">{{ substr($user->nom, 0, 1) }}</span>
                        </div>
                    @endif
                </div>
            </div>
            
            <div class="pt-16 pb-6 px-6">
                <div class="mb-4">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->nom }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm">{{ $user->email }}</p>
                </div>
                
                <!-- Role badge -->
                <div class="mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $user->role_badge }}">
                        @if($user->role === 'admin')
                            <i class="fas fa-crown mr-2"></i>
                            Administrateur
                        @elseif($user->role === 'formateur')
                            <i class="fas fa-graduation-cap mr-2"></i>
                            Formateur
                        @else
                            <i class="fas fa-user-graduate mr-2"></i>
                            Participant
                        @endif
                    </span>
                </div>
                
                <!-- Quick actions -->
                <div class="space-y-3">
                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}">
                        @csrf
                        @if($user->deactivated_at)
                            <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white py-2.5 px-4 rounded-lg font-medium transition-colors">
                                <i class="fas fa-undo mr-2"></i>
                                Réactiver le compte
                            </button>
                        @else
                            <button type="submit" class="w-full {{ $user->est_actif ? 'bg-orange-500 hover:bg-orange-600' : 'bg-green-500 hover:bg-green-600' }} text-white py-2.5 px-4 rounded-lg font-medium transition-colors">
                                <i class="fas fa-{{ $user->est_actif ? 'pause' : 'play' }} mr-2"></i>
                                {{ $user->est_actif ? 'Désactiver' : 'Activer' }}
                            </button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Quick Stats -->
        <div class="card mt-6">
            <div class="p-6">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-4">Activité</h4>
                <div class="space-y-4">
                    @if($user->isParticipant())
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400 text-sm">Inscriptions</span>
                        <span class="font-semibold text-blue-600">{{ $user->inscriptions_count }}</span>
                    </div>
                    @endif
                    
                    @if($user->isFormateur())
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400 text-sm">Formations</span>
                        <span class="font-semibold text-purple-600">{{ $user->formations_count }}</span>
                    </div>
                    @endif
                    
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400 text-sm">Inscrit le</span>
                        <span class="font-semibold text-gray-900 dark:text-white text-sm">{{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                    
                    @if($user->deactivated_at)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600 dark:text-gray-400 text-sm">Désactivé le</span>
                        <span class="font-semibold text-red-600 text-sm">{{ $user->deactivated_at->format('d/m/Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Details Column -->
    <div class="xl:col-span-3 space-y-6">
        <!-- Personal Information -->
        <div class="card">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-id-card mr-3 text-blue-500"></i>
                    Informations Personnelles
                </h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nom complet</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">{{ $user->nom }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Adresse email</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->email }}</dd>
                    </div>
                    @if($user->adresse)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Adresse</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->adresse }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
        
        <!-- Role-specific Information -->
        @if($user->isParticipant())
        <div class="card">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-user-graduate mr-3 text-green-500"></i>
                    Profil Participant
                </h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($user->pronoms)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pronoms</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->pronoms }}</dd>
                    </div>
                    @endif
                    
                    @if($user->niveau)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Niveau</dt>
                        <dd class="mt-1">
                            @php
                                $niveauColors = [
                                    'debutant' => 'bg-blue-100 text-blue-800 border-blue-200',
                                    'intermediaire' => 'bg-amber-100 text-amber-800 border-amber-200',
                                    'avance' => 'bg-green-100 text-green-800 border-green-200'
                                ];
                                $color = $niveauColors[$user->niveau] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                            @endphp
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium border {{ $color }}">
                                {{ ucfirst($user->niveau) }}
                            </span>
                        </dd>
                    </div>
                    @endif
                    
                    @if($user->preferences)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Préférences d'apprentissage</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ is_array($user->preferences) ? json_encode($user->preferences) : $user->preferences }}</dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
        @endif
        
        @if($user->isFormateur())
        <div class="card">
            <div class="border-b border-gray-200 dark:border-gray-700 px-6 py-4">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center">
                    <i class="fas fa-chalkboard-teacher mr-3 text-purple-500"></i>
                    Profil Formateur
                </h3>
            </div>
            <div class="p-6">
                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($user->specialite)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Domaine de spécialité</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">{{ $user->specialite }}</dd>
                    </div>
                    @endif
                    
                    @if($user->experience)
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Expérience professionnelle</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $user->formatted_experience }}</dd>
                    </div>
                    @endif
                    
                    @if($user->cv_path)
                    <div class="md:col-span-2">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Curriculum Vitae</dt>
                        <dd class="mt-1">
                            <a href="{{ Storage::url($user->cv_path) }}" target="_blank" 
                               class="inline-flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 border border-blue-200 rounded-lg hover:bg-blue-100 transition-colors">
                                <i class="fas fa-file-pdf mr-2"></i>
                                Consulter le CV
                            </a>
                        </dd>
                    </div>
                    @endif
                </dl>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Photo Modal -->
<div id="photoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 id="photoModalTitle" class="text-lg font-medium text-gray-900 dark:text-white">Photo de profil</h3>
                <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <div class="flex justify-center mb-4">
                <img id="photoModalImage" src="" alt="Photo" class="max-w-full h-auto rounded-lg">
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function showPhotoModal(photoUrl, userName) {
    document.getElementById('photoModalImage').src = photoUrl;
    document.getElementById('photoModalTitle').textContent = 'Photo de ' + userName;
    document.getElementById('photoModal').classList.remove('hidden');
}

function closePhotoModal() {
    document.getElementById('photoModal').classList.add('hidden');
}

// Close modal when clicking outside
document.addEventListener('click', function(event) {
    if (event.target.classList.contains('fixed') && event.target.id === 'photoModal') {
        closePhotoModal();
    }
});
</script>
@endsection