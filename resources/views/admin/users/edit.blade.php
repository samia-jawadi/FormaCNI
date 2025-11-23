@extends('admin.dashboard')

@section('title', 'Modifier Utilisateur - FormaCNI')
@section('page-title', 'Modifier l\'Utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card p-6">
        <div class="mb-6">
            <a href="{{ route('admin.users.index') }}" class="btn-secondary py-2 px-4 rounded-lg inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                Retour à la liste
            </a>
        </div>

        <h2 class="text-2xl font-bold mb-6">Modifier l'utilisateur : {{ $user->nom }}</h2>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Informations de base -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold border-b pb-2">Informations de base</h3>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Nom complet *</label>
                        <input type="text" name="nom" value="{{ old('nom', $user->nom) }}" required 
                               class="input-field w-full p-3" placeholder="Nom de l'utilisateur">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" required 
                               class="input-field w-full p-3" placeholder="email@example.com">
                        <p class="text-xs text-gray-500 mt-1">Adresse email utilisée pour la connexion et les notifications.</p>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Rôle *</label>
                        <select name="role" required class="input-field w-full p-3" onchange="toggleRoleFields(this.value)">
                            <option value="">Sélectionner un rôle</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Administrateur</option>
                            <option value="formateur" {{ old('role', $user->role) == 'formateur' ? 'selected' : '' }}>Formateur</option>
                            <option value="participant" {{ old('role', $user->role) == 'participant' ? 'selected' : '' }}>Participant</option>
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-2">Statut du compte</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="est_actif" value="1" 
                                       {{ $user->est_actif ? 'checked' : '' }} class="mr-2">
                                <span class="text-green-600">Actif</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="est_actif" value="0" 
                                       {{ !$user->est_actif ? 'checked' : '' }} class="mr-2"
                                       @if($user->id === auth()->id() && $user->isAdmin()) disabled @endif>
                                <span class="text-red-600 @if($user->id === auth()->id() && $user->isAdmin()) opacity-50 cursor-not-allowed @endif">Inactif</span>
                            </label>
                        </div>
                        @if($user->id === auth()->id() && $user->isAdmin())
                            <p class="text-xs text-gray-500 mt-2">Un administrateur ne peut pas désactiver son propre compte.</p>
                        @endif
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-2">Statut de stagiere</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center">
                                <input type="radio" name="est_stagiere" value="1" 
                                       {{ $user->est_stagiere ? 'checked' : '' }} class="mr-2">
                                <span class="text-blue-600">Stagiere</span>
                            </label>
                            <label class="flex items-center">
                                <input type="radio" name="est_stagiere" value="0" 
                                       {{ !$user->est_stagiere ? 'checked' : '' }} class="mr-2">
                                <span class="text-gray-600">Non stagiere</span>
                            </label>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Définir l'utilisateur comme stagiere lui donne un statut spécial.</p>
                    </div>
                </div>

                <!-- Champs spécifiques au rôle -->
                <div class="space-y-4">
                    <h3 class="text-lg font-semibold border-b pb-2">Informations spécifiques</h3>
                    
                    <!-- Champs Formateur -->
                    <div id="formateurFields" class="space-y-4 {{ $user->role == 'formateur' ? '' : 'hidden' }}">
                        <div>
                            <label class="block text-sm font-medium mb-2">Spécialisation</label>
                            <input type="text" name="specialite" value="{{ old('specialite', $user->specialite) }}" 
                                   class="input-field w-full p-3" placeholder="Spécialité du formateur">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Expérience (années)</label>
                            <input type="number" name="experience" value="{{ old('experience', $user->experience) }}" 
                                   class="input-field w-full p-3" placeholder="0" min="0">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">CV (lien)</label>
                            <input type="text" name="cv_path" value="{{ old('cv_path', $user->cv_path) }}" 
                                   class="input-field w-full p-3" placeholder="Lien vers le CV">
                        </div>
                    </div>
                    
                    <!-- Champs Participant -->
                    <div id="participantFields" class="space-y-4 {{ $user->role == 'participant' ? '' : 'hidden' }}">
                        <!-- Photo Section -->
                        <div>
                            <label class="block text-sm font-medium mb-2">Photo de profil</label>
                            <div class="flex items-center space-x-4">
                                @if($user->photo)
                                    <img src="{{ Storage::url($user->photo) }}" alt="Photo de profil" 
                                         class="w-16 h-16 rounded-full object-cover border-2 border-gray-200" id="current-photo">
                                @else
                                    <div class="w-16 h-16 bg-gradient-to-r from-blue-400 to-purple-500 rounded-full flex items-center justify-center" id="current-photo">
                                        <span class="text-white font-medium">{{ substr($user->nom, 0, 1) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <input type="file" name="photo" id="photo-input" 
                                           class="input-field w-full p-2" accept="image/*" onchange="previewPhoto(event)">
                                    <p class="text-xs text-gray-500 mt-1">Formats acceptés: JPG, PNG, GIF (max 2MB)</p>
                                    @if($user->photo)
                                        <div class="mt-2">
                                            <label class="flex items-center">
                                                <input type="checkbox" name="remove_photo" value="1" class="mr-2">
                                                <span class="text-red-600 text-sm">Supprimer la photo actuelle</span>
                                            </label>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Pronoms</label>
                            <input type="text" name="pronoms" value="{{ old('pronoms', $user->pronoms) }}" 
                                   class="input-field w-full p-3" placeholder="il/elle, ils/elles">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2">Adresse</label>
                            <textarea name="adresse" class="input-field w-full p-3" rows="3" 
                                      placeholder="Adresse complète">{{ old('adresse', $user->adresse) }}</textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Niveau</label>
                            <select name="niveau" class="input-field w-full p-3">
                                <option value="">Sélectionner un niveau</option>
                                <option value="débutant" {{ old('niveau', $user->niveau) == 'débutant' ? 'selected' : '' }}>Débutant</option>
                                <option value="intermédiaire" {{ old('niveau', $user->niveau) == 'intermédiaire' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="avancé" {{ old('niveau', $user->niveau) == 'avancé' ? 'selected' : '' }}>Avancé</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-2">Préférences</label>
                            <textarea name="preferences" class="input-field w-full p-3" rows="3" 
                                      placeholder="Préférences d'apprentissage...">{{ old('preferences', is_array($user->preferences) ? json_encode($user->preferences) : $user->preferences) }}</textarea>
                            <p class="text-sm text-gray-500 mt-1">Format JSON accepté</p>
                        </div>
                    </div>

                    <!-- Champs Admin -->
                    <div id="adminFields" class="space-y-4 {{ $user->role == 'admin' ? '' : 'hidden' }}">
                        <div class="bg-blue-50 dark:bg-blue-900/20 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                <p class="text-blue-700 dark:text-blue-300 text-sm">
                                    Les administrateurs ont un accès complet au panel d'administration.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Section changement de mot de passe -->
            <div class="mt-8 pt-6 border-t">
                <h3 class="text-lg font-semibold mb-4">Changement de mot de passe</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium mb-2">Nouveau mot de passe</label>
                        <input type="password" name="password" class="input-field w-full p-3" 
                               placeholder="Laisser vide pour ne pas changer">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-2">Confirmer le mot de passe</label>
                        <input type="password" name="password_confirmation" class="input-field w-full p-3" 
                               placeholder="Confirmer le nouveau mot de passe">
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-2">
                    Le mot de passe doit contenir au moins 6 caractères. Laissez vide pour conserver le mot de passe actuel.
                </p>
            </div>

            <!-- Statistiques de l'utilisateur -->
            <div class="mt-8 pt-6 border-t">
                <h3 class="text-lg font-semibold mb-4">Statistiques de l'utilisateur</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Formations créées</p>
                        <p class="text-2xl font-bold">{{ $user->formations_count ?? 0 }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Inscriptions</p>
                        <p class="text-2xl font-bold">{{ $user->inscriptions_count ?? 0 }}</p>
                    </div>
                    <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                        <p class="text-sm text-gray-600 dark:text-gray-400">Date d'inscription</p>
                        <p class="text-lg font-semibold">{{ $user->created_at->format('d/m/Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between items-center mt-8 pt-6 border-t">
                <div>
                    @if(!$user->est_actif)
                    <span class="bg-red-100 text-red-800 text-sm px-3 py-1 rounded-full">
                        Compte désactivé
                    </span>
                    @endif
                </div>
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.index') }}" class="btn-secondary py-2 px-6 rounded-lg">
                        Annuler
                    </a>
                    <button type="submit" class="btn-primary py-2 px-6 rounded-lg">
                        <i class="fas fa-save mr-2"></i>
                        Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleRoleFields(role) {
    // Cacher tous les champs spécifiques
    document.getElementById('formateurFields').classList.add('hidden');
    document.getElementById('participantFields').classList.add('hidden');
    document.getElementById('adminFields').classList.add('hidden');
    
    // Afficher les champs correspondants au rôle sélectionné
    if (role === 'formateur') {
        document.getElementById('formateurFields').classList.remove('hidden');
    } else if (role === 'participant') {
        document.getElementById('participantFields').classList.remove('hidden');
    } else if (role === 'admin') {
        document.getElementById('adminFields').classList.remove('hidden');
    }
}

// Initialiser les champs au chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    const currentRole = '{{ $user->role }}';
    toggleRoleFields(currentRole);
});

// Photo preview function
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('current-photo').innerHTML = 
                '<img src="' + e.target.result + '" alt="Aperçu" class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">';
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush