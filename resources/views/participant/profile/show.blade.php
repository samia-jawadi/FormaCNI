@extends('layouts.app')

@section('title', 'Mon Profil - FormaCNI')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900 py-8">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Mon Profil</h1>
            <p class="text-gray-600 dark:text-gray-400 mt-2">Gérez vos informations personnelles et votre compte</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Colonne latérale -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <!-- Photo de profil -->
                    <div class="text-center mb-6">
                        @if(auth()->user()->photo)
                            <img src="{{ asset('storage/' . auth()->user()->photo) }}" 
                                 alt="Photo de profil" 
                                 class="w-32 h-32 rounded-full object-cover border-4 border-white shadow-lg mx-auto mb-4">
                        @else
                            <div class="w-32 h-32 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-4xl font-bold mx-auto mb-4">
                                {{ auth()->user()->initials }}
                            </div>
                        @endif
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ auth()->user()->nom }}</h2>
                        <p class="text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        <span class="inline-block mt-2 px-3 py-1 text-sm rounded-full {{ auth()->user()->role_badge }} capitalize">
                            {{ auth()->user()->role }}
                        </span>
                    </div>

                    <!-- Navigation -->
                    <nav class="space-y-2">
                        <button onclick="showSection('profile')" class="w-full text-left px-4 py-3 rounded-lg bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 font-medium">
                            <i class="fas fa-user mr-3"></i>
                            Informations personnelles
                        </button>
                        <button onclick="showSection('password')" class="w-full text-left px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 font-medium">
                            <i class="fas fa-lock mr-3"></i>
                            Mot de passe
                        </button>
                        @if(auth()->user()->isFormateur())
                        <button onclick="showSection('formateur')" class="w-full text-left px-4 py-3 rounded-lg text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 font-medium">
                            <i class="fas fa-chalkboard-teacher mr-3"></i>
                            Profil Formateur
                        </button>
                        @endif
                    </nav>
                </div>
            </div>

            <!-- Contenu principal -->
            <div class="lg:col-span-2">
                <!-- Section Informations personnelles -->
                <div id="profile-section" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Informations personnelles</h3>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                            <ul class="list-disc list-inside">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        @if(auth()->user()->isParticipant())
                        <div class="mb-6">
                            <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Photo de profil</label>
                            <div class="flex items-center gap-4">
                                <input type="file" name="photo" accept="image/*" class="hidden" id="photo-input">
                                <label for="photo-input" class="cursor-pointer p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center">
                                    <i class="fas fa-camera mr-2"></i>
                                    <span>Changer la photo</span>
                                </label>
                                <div id="photo-status" class="text-sm text-gray-500"></div>
                            </div>
                        </div>
                        @endif
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Nom complet *</label>
                                <input type="text" name="nom" value="{{ old('nom', auth()->user()->nom) }}" required 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="Votre nom">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Email *</label>
                                <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="email@example.com">
                            </div>

                            @if(auth()->user()->isParticipant())
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Pronoms</label>
                                <input type="text" name="pronoms" value="{{ old('pronoms', auth()->user()->pronoms) }}" 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="il/elle, ils/elles">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Niveau</label>
                                <select name="niveau" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="">Sélectionner un niveau</option>
                                    <option value="débutant" {{ old('niveau', auth()->user()->niveau) == 'débutant' ? 'selected' : '' }}>Débutant</option>
                                    <option value="intermédiaire" {{ old('niveau', auth()->user()->niveau) == 'intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                    <option value="avancé" {{ old('niveau', auth()->user()->niveau) == 'avancé' ? 'selected' : '' }}>Avancé</option>
                                </select>
                            </div>
                            @endif

                            @if(auth()->user()->isFormateur())
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Spécialisation</label>
                                <input type="text" name="specialite" value="{{ old('specialite', auth()->user()->specialite) }}" 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="Votre spécialité">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Expérience (années)</label>
                                <input type="number" name="experience" value="{{ old('experience', auth()->user()->experience) }}" 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="0" min="0">
                            </div>
                            @endif
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                                <i class="fas fa-save mr-2"></i>
                                Enregistrer les modifications
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Section Mot de passe -->
                <div id="password-section" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 hidden">
                    <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Changer le mot de passe</h3>

                    @if(session('success_password'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                            {{ session('success_password') }}
                        </div>
                    @endif

                    <form action="{{ route('profile.change-password') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Mot de passe actuel *</label>
                                <input type="password" name="current_password" required 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="Votre mot de passe actuel">
                                @error('current_password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Nouveau mot de passe *</label>
                                <input type="password" name="password" required 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="Nouveau mot de passe">
                                @error('password')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Confirmer le nouveau mot de passe *</label>
                                <input type="password" name="password_confirmation" required 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="Confirmer le nouveau mot de passe">
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                                <i class="fas fa-key mr-2"></i>
                                Changer le mot de passe
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Section Formateur -->
                @if(auth()->user()->isFormateur())
                <div id="formateur-section" class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 hidden">
                    <h3 class="text-xl font-semibold mb-6 text-gray-900 dark:text-white">Profil Formateur</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center">
                                <i class="fas fa-chalkboard-teacher text-blue-500 text-xl mr-3"></i>
                                <div>
                                    <p class="font-semibold text-blue-800 dark:text-blue-300">Formations créées</p>
                                    <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ auth()->user()->formations_count ?? 0 }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="bg-green-50 dark:bg-green-900/20 p-4 rounded-lg border border-green-200 dark:border-green-800">
                            <div class="flex items-center">
                                <i class="fas fa-users text-green-500 text-xl mr-3"></i>
                                <div>
                                    <p class="font-semibold text-green-800 dark:text-green-300">Participants total</p>
                                    <p class="text-2xl font-bold text-green-600 dark:text-green-400">
                                        {{ auth()->user()->formations->sum('inscriptions_count') ?? 0 }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">CV (lien)</label>
                                <input type="text" name="cv_path" value="{{ old('cv_path', auth()->user()->cv_path) }}" 
                                       class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="Lien vers votre CV">
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Partagez un lien vers votre CV ou portfolio</p>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-700 dark:text-gray-300">Bio / Description</label>
                                <textarea name="bio" class="w-full p-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent" rows="4" 
                                          placeholder="Décrivez votre expérience et compétences...">{{ old('bio', auth()->user()->bio) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-3 px-6 rounded-lg transition duration-200">
                                <i class="fas fa-sync-alt mr-2"></i>
                                Mettre à jour le profil formateur
                            </button>
                        </div>
                    </form>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showSection(section) {
    // Cacher toutes les sections
    document.getElementById('profile-section').classList.add('hidden');
    document.getElementById('password-section').classList.add('hidden');
    if (document.getElementById('formateur-section')) {
        document.getElementById('formateur-section').classList.add('hidden');
    }
    
    // Afficher la section sélectionnée
    document.getElementById(section + '-section').classList.remove('hidden');
    
    // Mettre à jour la navigation
    const navButtons = document.querySelectorAll('nav button');
    navButtons.forEach(button => {
        button.classList.remove('bg-blue-100', 'dark:bg-blue-900', 'text-blue-700', 'dark:text-blue-300');
        button.classList.add('text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');
    });
    
    // Mettre en surbrillance le bouton actif
    event.currentTarget.classList.remove('text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');
    event.currentTarget.classList.add('bg-blue-100', 'dark:bg-blue-900', 'text-blue-700', 'dark:text-blue-300');
}

// Photo preview functionality
if (document.getElementById('photo-input')) {
    document.getElementById('photo-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const status = document.getElementById('photo-status');
        
        if (file) {
            status.textContent = `Photo sélectionnée: ${file.name}`;
            status.classList.remove('text-gray-500');
            status.classList.add('text-green-600');
        } else {
            status.textContent = '';
            status.classList.remove('text-green-600');
            status.classList.add('text-gray-500');
        }
    });
}

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', function() {
    showSection('profile');
});
</script>
@endpush