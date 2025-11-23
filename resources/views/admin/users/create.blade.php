@extends('admin.dashboard')

@section('title', 'Ajouter Utilisateur - FormaCNI')
@section('page-title', 'Ajouter un Utilisateur')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="card p-6">
        @include('admin.components.page-header', [
            'backRoute' => route('admin.users.index'),
            'backText' => 'Retour à la liste',
            'pageTitle' => 'Créer un Nouvel Utilisateur'
        ])
        
        <style>
            /* Light mode colors */
            body:not(.theme-dark) {
                --text-color: #2d3748;
                --text-muted: #4a5568;
                --bg-input: #ffffff;
                --border-input: #e2e8f0;
            }
            
            /* Dark mode colors */
            body.theme-dark {
                --text-color: #e2e8f0;
                --text-muted: #a0aec0;
                --bg-input: #2d3748;
                --border-input: #4a5568;
            }
            
            .btn-primary {
                background: #667eea;
                color: white;
                padding: 12px 24px;
                border: none;
                border-radius: 8px;
                font-weight: 600;
                cursor: pointer;
                transition: all 0.3s ease;
            }
            .btn-primary:hover:not(:disabled) {
                background: #764ba2;
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
            }
            .btn-primary:disabled {
                opacity: 0.6;
                cursor: not-allowed;
                transform: none;
            }
            .btn-primary:active:not(:disabled) {
                transform: translateY(0);
                box-shadow: 0 2px 6px rgba(102, 126, 234, 0.2);
            }
            .btn-secondary {
                background: var(--bg-input);
                color: var(--text-color);
                border: 1px solid var(--border-input);
                transition: all 0.3s ease;
                text-decoration: none;
                display: inline-flex;
                align-items: center;
                font-weight: 500;
            }
            .btn-secondary:hover {
                background: var(--border-input);
                transform: translateY(-1px);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }
            .input-field {
                background: var(--bg-input);
                border: 1px solid var(--border-input);
                border-radius: 0.5rem;
                transition: all 0.3s ease;
                color: var(--text-color);
            }
            .input-field:focus {
                outline: none;
                border-color: #667eea;
                box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            }
            .form-label {
                color: var(--text-color);
                font-weight: 500;
            }
            .text-readable {
                color: var(--text-color);
            }
            .text-muted {
                color: var(--text-muted);
            }
            .form-text {
                color: var(--text-color) !important;
            }
        </style>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST" id="user-form" class="max-w-2xl mx-auto">
            @csrf
            
            <!-- Info Card -->
            <div class="bg-blue-50 dark:bg-blue-900/30 p-4 rounded-lg mb-8 border border-blue-200 dark:border-blue-700">
                <div class="flex items-start space-x-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-info-circle text-blue-600 dark:text-blue-400 text-lg"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-blue-900 dark:text-blue-200 text-sm">Création Simplifiée</h3>
                        <p class="text-blue-800 dark:text-blue-200 text-sm mt-1 leading-relaxed font-medium">
                            Créez l'utilisateur avec les informations essentielles. Les détails spécifiques au rôle pourront être ajoutés ultérieurement via "Modifier".
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="space-y-6">
                <!-- Nom Complet -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user mr-2 text-blue-500"></i>
                        Nom complet *
                    </label>
                    <input type="text" name="nom" value="{{ old('nom') }}" 
                           required class="input-field" 
                           placeholder="Entrez le nom complet de l'utilisateur">
                    @error('nom')
                        <p class="text-red-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Email -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-envelope mr-2 text-green-500"></i>
                        Adresse email *
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}" 
                           required class="input-field" 
                           placeholder="utilisateur@exemple.com">
                    @error('email')
                        <p class="text-red-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Rôle -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user-tag mr-2 text-purple-500"></i>
                        Rôle utilisateur *
                    </label>
                    <select name="role" required class="input-field" onchange="showRoleInfo(this.value)">
                        <option value="">-- Sélectionner un rôle --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                            🔑 Administrateur
                        </option>
                        <option value="formateur" {{ old('role') == 'formateur' ? 'selected' : '' }}>
                            🎓 Formateur
                        </option>
                        <option value="participant" {{ old('role') == 'participant' ? 'selected' : '' }}>
                            🎆 Participant
                        </option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                    
                    <!-- Role Info -->
                    <div id="roleInfo" class="hidden mt-3">
                        <div id="adminInfo" class="bg-purple-50 border border-purple-200 p-4 rounded-lg hidden">
                            <h4 class="font-semibold text-purple-800 mb-1 text-sm">🔑 Administrateur</h4>
                            <p class="text-purple-700 text-xs">
                                Accès complet: gestion utilisateurs, formations, validations et historiques.
                            </p>
                        </div>
                        <div id="formateurInfo" class="bg-green-50 border border-green-200 p-4 rounded-lg hidden">
                            <h4 class="font-semibold text-green-800 mb-1 text-sm">🎓 Formateur</h4>
                            <p class="text-green-700 text-xs">
                                Peut créer des formations, gérer ses participants. Détails à compléter après création.
                            </p>
                        </div>
                        <div id="participantInfo" class="bg-orange-50 border border-orange-200 p-4 rounded-lg hidden">
                            <h4 class="font-semibold text-orange-800 mb-1 text-sm">🎆 Participant</h4>
                            <p class="text-orange-700 text-xs">
                                Peut s'inscrire aux formations et gérer son profil. Préférences à définir plus tard.
                            </p>
                        </div>
                    </div>
                </div>
                
                <!-- Mot de passe -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock mr-2 text-amber-500"></i>
                        Mot de passe temporaire *
                    </label>
                    <div class="relative">
                        <input type="password" name="password" value="password123" 
                               required class="input-field pr-12" id="password-field"
                               placeholder="Mot de passe temporaire">
                        <button type="button" onclick="togglePassword()" 
                                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
                            <i id="password-icon" class="fas fa-eye text-sm"></i>
                        </button>
                    </div>
                    <div class="mt-2 bg-amber-50 border border-amber-200 p-3 rounded-lg">
                        <p class="text-amber-700 text-xs flex items-start">
                            <i class="fas fa-info-circle mr-2 mt-0.5 text-amber-500"></i>
                            L'utilisateur recevra ce mot de passe temporaire et devra le changer lors de sa première connexion.
                        </p>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-2 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>
                
                <input type="hidden" name="password_confirmation" value="password123">
                
                <!-- Statut du compte -->
                <div>
                    <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                        <i class="fas fa-toggle-on mr-2 text-indigo-500"></i>
                        Statut du compte
                    </label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <label class="flex items-center p-3 border-2 border-green-200 rounded-lg cursor-pointer hover:bg-green-50 transition-colors has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                            <input type="radio" name="est_actif" value="1" {{ old('est_actif', '1') == '1' ? 'checked' : '' }} 
                                   class="sr-only">
                            <div class="flex items-center w-full">
                                <i class="fas fa-check-circle text-green-500 text-lg mr-3"></i>
                                <div>
                                    <div class="font-semibold text-green-700 text-sm">Compte actif</div>
                                    <div class="text-green-600 text-xs">Utilisateur peut se connecter</div>
                                </div>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-3 border-2 border-red-200 rounded-lg cursor-pointer hover:bg-red-50 transition-colors has-[:checked]:border-red-500 has-[:checked]:bg-red-50">
                            <input type="radio" name="est_actif" value="0" {{ old('est_actif') == '0' ? 'checked' : '' }} 
                                   class="sr-only">
                            <div class="flex items-center w-full">
                                <i class="fas fa-times-circle text-red-500 text-lg mr-3"></i>
                                <div>
                                    <div class="font-semibold text-red-700 text-sm">Compte inactif</div>
                                    <div class="text-red-600 text-xs">Accès bloqué temporairement</div>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            
            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row justify-between items-center mt-12 pt-8 border-t border-gray-200 space-y-3 sm:space-y-0 sm:space-x-4">
                <div class="flex items-center text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-2"></i>
                    <span>Les champs marqués d'un * sont obligatoires</span>
                </div>
                
                <div class="flex space-x-3">
                    <a href="{{ route('admin.users.index') }}" 
                       class="inline-flex items-center px-6 py-3 border-2 border-gray-300 rounded-lg text-sm font-semibold text-gray-700 bg-white hover:bg-gray-50 hover:border-gray-400 transition-all duration-200 shadow-sm hover:shadow">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Annuler
                    </a>
                    <button type="submit" id="submit-btn" 
                            class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer l'utilisateur
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
    console.log('User creation form loaded');
    
    // Password toggle function
    function togglePassword() {
        const passwordField = document.getElementById('password-field');
        const passwordIcon = document.getElementById('password-icon');
        
        if (passwordField && passwordIcon) {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash text-sm';
            } else {
                passwordField.type = 'password';
                passwordIcon.className = 'fas fa-eye text-sm';
            }
        }
    }
    
    // Role info display function
    function showRoleInfo(role) {
        const roleInfo = document.getElementById('roleInfo');
        const adminInfo = document.getElementById('adminInfo');
        const formateurInfo = document.getElementById('formateurInfo');
        const participantInfo = document.getElementById('participantInfo');
        
        // Hide all first
        if (adminInfo) adminInfo.classList.add('hidden');
        if (formateurInfo) formateurInfo.classList.add('hidden');
        if (participantInfo) participantInfo.classList.add('hidden');
        
        // Show selected role info
        if (role && roleInfo) {
            roleInfo.classList.remove('hidden');
            const targetInfo = document.getElementById(role + 'Info');
            if (targetInfo) {
                targetInfo.classList.remove('hidden');
                // Add a subtle animation
                targetInfo.style.opacity = '0';
                setTimeout(() => {
                    targetInfo.style.transition = 'opacity 0.3s ease-in-out';
                    targetInfo.style.opacity = '1';
                }, 10);
            }
        } else if (roleInfo) {
            roleInfo.classList.add('hidden');
        }
    }
    
    // Form submission handling
    document.getElementById('user-form').addEventListener('submit', function(e) {
        console.log('Form submitted!');
        const submitBtn = document.getElementById('submit-btn');
        
        // Show loading state immediately
        submitBtn.disabled = true;
        submitBtn.style.transform = 'none';
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Création en cours...';
        submitBtn.className = 'inline-flex items-center px-8 py-3 bg-blue-600 text-white rounded-lg text-sm font-semibold opacity-75 cursor-not-allowed';
        
        // Basic validation
        const nom = document.querySelector('input[name="nom"]').value.trim();
        const email = document.querySelector('input[name="email"]').value.trim();
        const role = document.querySelector('select[name="role"]').value;
        
        if (!nom || !email || !role) {
            e.preventDefault();
            
            // Show validation error with better styling
            const errorMsg = document.createElement('div');
            errorMsg.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
            errorMsg.innerHTML = '<i class="fas fa-exclamation-triangle mr-2"></i>Veuillez remplir tous les champs obligatoires';
            document.body.appendChild(errorMsg);
            
            // Remove error after 3 seconds
            setTimeout(() => errorMsg.remove(), 3000);
            
            // Reset button
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Créer l\'utilisateur';
            submitBtn.className = 'inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg text-sm font-semibold hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5';
            
            return false;
        }
        
        console.log('Validation passed, submitting...');
    });
    
    // Password confirmation sync
    document.getElementById('password-field').addEventListener('input', function() {
        const confirmField = document.querySelector('input[name="password_confirmation"]');
        if (confirmField) {
            confirmField.value = this.value;
        }
    });
    
    console.log('Form ready!');
</script>
@endsection
