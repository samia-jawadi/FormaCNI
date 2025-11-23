@extends('admin.dashboard')

@section('title', 'Mon Profil - Administrateur')
@section('page-title', 'Mon Profil')

@section('content')
<div class="max-w-6xl mx-auto space-y-6">
    <!-- En-tête du profil -->
    <div class="card animate-fade-in-up">
        <div class="flex items-center space-x-6 p-6">
            <div class="w-20 h-20 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white text-2xl font-bold shadow-lg floating-element">
                {{ substr(auth()->user()->nom, 0, 1) }}
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-readable">{{ auth()->user()->nom }}</h2>
                <p class="text-muted mt-1">{{ auth()->user()->email }}</p>
                <span class="inline-block mt-3 px-3 py-1 text-sm rounded-full bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-sm">
                    Administrateur
                </span>
            </div>
            <div class="text-right">
                <div class="text-sm text-muted">Membre depuis</div>
                <div class="font-semibold text-readable">{{ auth()->user()->created_at->format('d/m/Y') }}</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
        <!-- Navigation latérale -->
        <div class="xl:col-span-1">
            <div class="card animate-slide-in-left">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-readable mb-4">Navigation</h3>
                    <nav class="space-y-2">
                        <button onclick="showSection('profile')" 
                                class="profile-nav-btn w-full text-left px-4 py-3 rounded-xl transition-all duration-300 bg-gradient-to-r from-primary to-secondary text-white font-medium shadow-sm hover-lift">
                            <i class="fas fa-user mr-3 w-5 text-center"></i>
                            Informations personnelles
                        </button>
                        <button onclick="showSection('password')" 
                                class="profile-nav-btn w-full text-left px-4 py-3 rounded-xl transition-all duration-300 text-readable hover:bg-secondary font-medium border border-transparent hover:border-border-color">
                            <i class="fas fa-lock mr-3 w-5 text-center"></i>
                            Mot de passe
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Statut du compte -->
            <div class="card mt-6 animate-slide-in-left" style="animation-delay: 0.1s">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-readable mb-4">Statut du compte</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="text-muted">Rôle</span>
                            <span class="badge badge-success">Administrateur</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-muted">Statut</span>
                            <span class="text-success font-semibold">Actif</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-muted">Dernière connexion</span>
                            <span class="text-readable text-sm">{{ auth()->user()->updated_at->format('d/m/Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contenu principal -->
        <div class="xl:col-span-3">
            <!-- Section Informations personnelles -->
            <div id="profile-section" class="card animate-slide-in-right">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-readable">Informations personnelles</h3>
                        <div class="w-10 h-10 bg-secondary rounded-xl flex items-center justify-center">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                    </div>

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 animate-scale-in">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success') }}
                            </div>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl mb-6 animate-scale-in">
                            <div class="flex items-center mb-2">
                                <i class="fas fa-exclamation-triangle mr-2"></i>
                                <span class="font-semibold">Veuillez corriger les erreurs suivantes :</span>
                            </div>
                            <ul class="list-disc list-inside text-sm">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        
                        <!-- Nom complet -->
                        <div class="form-group">
                            <label class="block text-sm font-semibold mb-3 text-readable">
                                Nom complet <span class="text-danger">*</span>
                            </label>
                            <div class="relative">
                                <input type="text" name="nom" value="{{ old('nom', auth()->user()->nom) }}" required 
                                       class="input-field pl-11"
                                       placeholder="Votre nom complet">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted">
                                    <i class="fas fa-user"></i>
                                </div>
                            </div>
                            <p class="text-sm text-muted mt-2">Ce nom sera affiché dans l'interface d'administration</p>
                        </div>
                        
                        <!-- Email (lecture seule pour l'admin) -->
                        <div class="form-group">
                            <label class="block text-sm font-semibold mb-3 text-readable">Email</label>
                            <div class="relative">
                                <input type="email" name="email" value="{{ auth()->user()->email }}" readonly
                                       class="input-field pl-11 bg-secondary cursor-not-allowed"
                                       placeholder="email@example.com">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted">
                                    <i class="fas fa-envelope"></i>
                                </div>
                            </div>
                            <p class="text-sm text-muted mt-2">L'email ne peut pas être modifié pour les comptes administrateur</p>
                        </div>

                        <!-- Adresse -->
                        <div class="form-group">
                            <label class="block text-sm font-semibold mb-3 text-readable">Adresse</label>
                            <div class="relative">
                                <textarea name="adresse" rows="3"
                                          class="input-field pl-11 resize-none"
                                          placeholder="Votre adresse complète">{{ old('adresse', auth()->user()->adresse ?? '') }}</textarea>
                                <div class="absolute left-3 top-4 text-muted">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                            </div>
                            <p class="text-sm text-muted mt-2">Adresse administrative (optionnel)</p>
                        </div>

                        <div class="flex space-x-4 pt-4">
                            <button type="submit" class="btn btn-primary flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span>Enregistrer les modifications</span>
                            </button>
                            <button type="reset" class="btn btn-secondary flex items-center space-x-2">
                                <i class="fas fa-undo"></i>
                                <span>Annuler</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Section Mot de passe -->
            <div id="password-section" class="card animate-slide-in-right hidden">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-semibold text-readable">Changer le mot de passe</h3>
                        <div class="w-10 h-10 bg-secondary rounded-xl flex items-center justify-center">
                            <i class="fas fa-lock text-primary"></i>
                        </div>
                    </div>

                    @if(session('success_password'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 animate-scale-in">
                            <div class="flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                {{ session('success_password') }}
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('profile.change-password') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <!-- Mot de passe actuel -->
                        <div class="form-group">
                            <label class="block text-sm font-semibold mb-3 text-readable">
                                Mot de passe actuel <span class="text-danger">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="current_password" required 
                                       class="input-field pl-11 pr-11"
                                       placeholder="Votre mot de passe actuel"
                                       id="current-password">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted">
                                    <i class="fas fa-lock"></i>
                                </div>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-muted hover:text-readable"
                                        onclick="togglePassword('current-password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('current_password')
                                <p class="text-danger text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Nouveau mot de passe -->
                        <div class="form-group">
                            <label class="block text-sm font-semibold mb-3 text-readable">
                                Nouveau mot de passe <span class="text-danger">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password" required 
                                       class="input-field pl-11 pr-11"
                                       placeholder="Nouveau mot de passe (min. 8 caractères)"
                                       id="new-password">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted">
                                    <i class="fas fa-key"></i>
                                </div>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-muted hover:text-readable"
                                        onclick="togglePassword('new-password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-danger text-sm mt-2 flex items-center">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Confirmation mot de passe -->
                        <div class="form-group">
                            <label class="block text-sm font-semibold mb-3 text-readable">
                                Confirmer le nouveau mot de passe <span class="text-danger">*</span>
                            </label>
                            <div class="relative">
                                <input type="password" name="password_confirmation" required 
                                       class="input-field pl-11 pr-11"
                                       placeholder="Confirmer le nouveau mot de passe"
                                       id="confirm-password">
                                <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-muted">
                                    <i class="fas fa-key"></i>
                                </div>
                                <button type="button" 
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-muted hover:text-readable"
                                        onclick="togglePassword('confirm-password', this)">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Conseils de sécurité -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/10 dark:to-indigo-900/10 border border-blue-200 dark:border-blue-800 rounded-xl p-4">
                            <h4 class="font-semibold text-readable mb-3 flex items-center">
                                <i class="fas fa-shield-alt mr-2 text-info"></i>
                                Conseils pour un mot de passe sécurisé
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-sm text-muted">
                                <div class="flex items-center">
                                    <i class="fas fa-check text-success mr-2 text-xs"></i>
                                    <span>Au moins 8 caractères</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-success mr-2 text-xs"></i>
                                    <span>Majuscules, minuscules, chiffres</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-success mr-2 text-xs"></i>
                                    <span>Symboles spéciaux</span>
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-check text-success mr-2 text-xs"></i>
                                    <span>Évitez les informations personnelles</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="btn btn-primary flex items-center space-x-2">
                                <i class="fas fa-key"></i>
                                <span>Changer le mot de passe</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-group {
    position: relative;
}

.input-field {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.input-field:focus {
    transform: translateY(-1px);
    box-shadow: var(--shadow);
}

.floating-element {
    animation: float 6s ease-in-out infinite;
}

.badge {
    display: inline-flex;
    align-items: center;
    padding: 0.25rem 0.75rem;
    border-radius: 9999px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.badge-success {
    background: linear-gradient(135deg, #10b981, #059669);
    color: white;
}
</style>
@endsection

@section('scripts')
<script>
function showSection(section) {
    // Cacher toutes les sections
    document.getElementById('profile-section').classList.add('hidden');
    document.getElementById('password-section').classList.add('hidden');
    
    // Afficher la section sélectionnée avec animation
    const targetSection = document.getElementById(section + '-section');
    targetSection.classList.remove('hidden');
    targetSection.classList.add('animate-slide-in-right');
    
    // Mettre à jour la navigation
    const navButtons = document.querySelectorAll('.profile-nav-btn');
    navButtons.forEach(button => {
        button.classList.remove(
            'bg-gradient-to-r', 'from-primary', 'to-secondary', 
            'text-white', 'shadow-sm', 'hover-lift'
        );
        button.classList.add(
            'text-readable', 'hover:bg-secondary', 
            'border', 'border-transparent', 'hover:border-border-color'
        );
    });
    
    // Mettre en surbrillance le bouton actif
    event.currentTarget.classList.remove(
        'text-readable', 'hover:bg-secondary', 
        'border', 'border-transparent', 'hover:border-border-color'
    );
    event.currentTarget.classList.add(
        'bg-gradient-to-r', 'from-primary', 'to-secondary', 
        'text-white', 'shadow-sm', 'hover-lift'
    );
}

function togglePassword(inputId, button) {
    const input = document.getElementById(inputId);
    const icon = button.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

// Initialiser au chargement
document.addEventListener('DOMContentLoaded', function() {
    showSection('profile');
    
    // Ajouter des animations aux éléments
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection