<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - FormaCNI</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: #667eea;
            --secondary: #764ba2;
            --elegant-primary: #3a7bd5;
            --admin: #a333ea;
            --text-primary: #2d3748;
            --bg-primary: #ffffff;
            --bg-secondary: #f7fafc;
            --border-color: #e2e8f0;
        }

        .theme-dark {
            --text-primary: #e2e8f0;
            --bg-primary: #1a202c;
            --bg-secondary: #2d3748;
            --border-color: #4a5568;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .animated-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.6;
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            animation: float 20s infinite ease-in-out;
        }

        .orb-1 {
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, #f093fb, #f5576c);
            bottom: 20%;
            right: 10%;
            animation-delay: 7s;
        }

        .orb-3 {
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            top: 60%;
            left: 50%;
            animation-delay: 14s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }
            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        .form-container {
            max-width: 450px;
            margin: 0 auto;
        }

        .card-enhanced {
            background: var(--bg-primary);
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(10px);
        }

        .field-group {
            margin-bottom: 1.5rem;
        }

        .field-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            display: block;
        }

        .input-enhanced {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .input-enhanced:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .role-btn {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid var(--border-color);
            background: var(--bg-secondary);
        }

        .role-btn.selected {
            background: var(--primary);
            border-color: transparent;
            color: white;
            transform: scale(1.05);
        }

        .role-btn:hover:not(.selected) {
            transform: scale(1.02);
            border-color: #667eea;
        }

        .btn-gradient {
            background: linear-gradient(45deg, var(--primary), var(--secondary));
            transition: all 0.3s ease;
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            margin: 1rem 0;
        }

        .custom-checkbox {
            width: 20px;
            height: 20px;
            margin-right: 12px;
            accent-color: var(--elegant-primary);
        }

        .link-text {
            color: var(--elegant-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .link-text:hover {
            color: #3a7bd5;
            text-decoration: underline;
        }

        .photo-preview {
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .photo-preview:hover {
            transform: scale(1.1);
            border-color: #667eea;
        }

        .toggle-btn {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .formateur-highlight {
            border-left: 4px solid;
            border-image: var(--secondary) 1;
            background: linear-gradient(90deg, rgba(240, 147, 251, 0.1), transparent);
        }

        .message {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
        }

        .message.error {
            background: rgba(239, 68, 68, 0.1);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #dc2626;
        }

        .message i {
            margin-right: 8px;
        }
    </style>
</head>
<body class="theme-light">
<div class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Animated Background -->
    <div class="animated-background">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>

    <!-- Header Controls -->
    <div class="absolute top-6 right-6 flex gap-3 z-50">
        <button id="theme-toggle" class="toggle-btn p-3 rounded-full">
            <i class="fas fa-moon text-lg"></i>
            <i class="fas fa-sun text-lg hidden"></i>
        </button>
    </div>

    <!-- Main Content Container -->
    <div class="form-container w-full z-10">
        <!-- Registration Form -->
        <div class="card-enhanced p-8 rounded-2xl overflow-y-auto max-h-[90vh]">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold mb-2">Créer Votre Compte</h2>
                <p class="text-sm opacity-75">Rejoignez notre communauté d'apprenants et d'éducateurs</p>
            </div>

            @if($errors->any())
            <div class="message error">
                <i class="fas fa-times-circle"></i>
                <div>
                    @foreach($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            </div>
            @endif

            <div id="error-message" class="message error hidden">
                <i class="fas fa-times-circle"></i>
                <span>Veuillez corriger les erreurs ci-dessous</span>
            </div>

            <form id="registration-form" method="POST" action="{{ route('register.submit') }}" enctype="multipart/form-data">
                @csrf
                <!-- Role Selection -->
                <div class="field-group">
                    <label class="field-label">Choisissez Votre Rôle</label>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <button type="button" onclick="selectRole('participant')" id="participant-btn" class="role-btn p-4 rounded-xl text-center selected">
                            <div class="text-2xl mb-2">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <div class="font-semibold">Participant</div>
                            <div class="text-xs opacity-75">Apprendre et grandir</div>
                        </button>
                        <button type="button" onclick="selectRole('formateur')" id="formateur-btn" class="role-btn p-4 rounded-xl text-center">
                            <div class="text-2xl mb-2">
                                <i class="fas fa-chalkboard-teacher"></i>
                            </div>
                            <div class="font-semibold">Formateur</div>
                            <div class="text-xs opacity-75">Enseigner et inspirer</div>
                        </button>
                    </div>
                    <input type="hidden" name="role" id="role-input" value="participant">
                    <span id="role-error" class="text-red-500 text-sm hidden"></span>
                </div>

                <!-- Common Fields -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="field-group">
                        <label class="field-label">Nom Complet</label>
                        <input type="text" name="nom" class="w-full p-4 rounded-xl input-enhanced" required 
                               placeholder="Samia Jawadi" autocomplete="off">
                        <span id="nom-error" class="text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Email</label>
                        <input type="email" name="email" class="w-full p-4 rounded-xl input-enhanced" required 
                               placeholder="samia@example.com" autocomplete="off">
                        <span id="email-error" class="text-red-500 text-sm hidden"></span>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="field-group">
                        <label class="field-label">Mot de Passe</label>
                        <div class="relative">
                            <input type="password" name="password" id="password-input" 
                                   class="w-full p-4 rounded-xl input-enhanced pr-12" required 
                                   placeholder="••••••••" autocomplete="new-password">
                            <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-500">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                        <span id="password-error" class="text-red-500 text-sm hidden"></span>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Confirmer le Mot de Passe</label>
                        <input type="password" name="password_confirmation" class="w-full p-4 rounded-xl input-enhanced" required 
                               placeholder="••••••••" autocomplete="new-password">
                        <span id="password-confirmation-error" class="text-red-500 text-sm hidden"></span>
                    </div>
                </div>

                <!-- Participant Fields -->
                <div id="participant-fields">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="field-group">
                            <label class="field-label">Pronoms</label>
                            <select name="pronoms" class="w-full p-4 rounded-xl input-enhanced">
                                <option value="">Sélectionner...</option>
                                <option value="il/lui">Il/Lui</option>
                                <option value="elle/elle">Elle/Elle</option>
                                <option value="iels/elles">Iels/Elles</option>
                            </select>
                        </div>

                        <div class="field-group">
                            <label class="field-label">Niveau</label>
                            <select name="niveau" class="w-full p-4 rounded-xl input-enhanced">
                                <option value="debutant">Débutant</option>
                                <option value="intermediaire">Intermédiaire</option>
                                <option value="avance">Avancé</option>
                            </select>
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Photo de Profil</label>
                        <div class="flex items-center gap-4">
                            <input type="file" name="photo" accept="image/*" class="hidden" id="photo-input">
                            <label for="photo-input" class="cursor-pointer p-4 rounded-xl input-enhanced flex items-center justify-center text-center flex-1">
                                <i class="fas fa-camera mr-2"></i>
                                <span>Choisir Photo</span>
                            </label>
                            <img id="photo-preview" src="#" alt="Preview" class="hidden w-16 h-16 photo-preview">
                        </div>
                    </div>

                    <div class="field-group">
                        <label class="field-label">Préférences d'Apprentissage</label>
                        <div class="grid grid-cols-2 gap-2">
                            <label class="flex items-center p-3 rounded-lg hover:bg-opacity-50 transition-colors">
                                <input type="checkbox" name="preferences[]" value="visual" class="custom-checkbox">
                                <span>Visuel</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-opacity-50 transition-colors">
                                <input type="checkbox" name="preferences[]" value="audio" class="custom-checkbox">
                                <span>Audio</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-opacity-50 transition-colors">
                                <input type="checkbox" name="preferences[]" value="practical" class="custom-checkbox">
                                <span>Pratique</span>
                            </label>
                            <label class="flex items-center p-3 rounded-lg hover:bg-opacity-50 transition-colors">
                                <input type="checkbox" name="preferences[]" value="theory" class="custom-checkbox">
                                <span>Théorie</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Formateur Fields -->
                <div id="formateur-fields" class="hidden formateur-highlight pl-4 ml-4 rounded-r-xl">
                    <div class="field-group">
                        <label class="field-label">Spécialisation</label>
                        <input type="text" name="specialite" class="w-full p-4 rounded-xl input-enhanced" 
                               placeholder="ex: Développement Web, Data Science">
                    </div>

                    <div class="field-group">
                        <label class="field-label">Années d'Expérience</label>
                        <input type="number" name="experience" min="0" max="50" class="w-full p-4 rounded-xl input-enhanced" 
                               placeholder="5">
                    </div>

                    <div class="field-group">
                        <label class="field-label">CV (PDF)</label>
                        <div class="flex items-center gap-4">
                            <input type="file" name="cvPdf" accept=".pdf" class="hidden" id="cv-input">
                            <label for="cv-input" class="cursor-pointer p-4 rounded-xl input-enhanced flex items-center justify-center text-center flex-1">
                                <i class="fas fa-file-pdf mr-2"></i>
                                <span>Télécharger CV</span>
                            </label>
                            <div id="cv-status" class="hidden text-green-500">
                                <i class="fas fa-check-circle"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Account Status -->
                <div class="checkbox-container">
                    <input type="checkbox" name="est_actif" id="actif" class="custom-checkbox" checked>
                    <label for="actif">Activer le compte immédiatement</label>
                </div>

                <button type="submit" class="w-full py-4 btn-gradient text-white rounded-xl font-semibold text-lg mb-4">
                    <i class="fas fa-rocket mr-2"></i>
                    Créer le Compte
                </button>

                <div class="text-center">
                    <span class="text-sm opacity-75">Vous avez déjà un compte? </span>
                    <a href="{{ route('login') }}" class="link-text">Connectez-vous ici</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function selectRole(role) {
        // Remove 'selected' class from all role buttons
        document.querySelectorAll('.role-btn').forEach(btn => {
            btn.classList.remove('selected');
        });

        // Add 'selected' class to the clicked role button
        document.getElementById(`${role}-btn`).classList.add('selected');

        // Set the value of the hidden role input field
        document.getElementById('role-input').value = role;

        // Hide all role-specific fields
        document.getElementById('participant-fields').classList.add('hidden');
        document.getElementById('formateur-fields').classList.add('hidden');

        // Show the fields relevant to the selected role
        if (role === 'participant') {
            document.getElementById('participant-fields').classList.remove('hidden');
        } else if (role === 'formateur') {
            document.getElementById('formateur-fields').classList.remove('hidden');
        }
    }

    function togglePassword() {
        const passwordInput = document.getElementById('password-input');
        const passwordEye = document.getElementById('password-eye');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            passwordEye.classList.remove('fa-eye');
            passwordEye.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            passwordEye.classList.remove('fa-eye-slash');
            passwordEye.classList.add('fa-eye');
        }
    }

    // Photo preview functionality
    document.getElementById('photo-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const preview = document.getElementById('photo-preview');

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            preview.src = '#';
            preview.classList.add('hidden');
        }
    });

    // CV upload status for formateur fields
    document.getElementById('cv-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const cvStatus = document.getElementById('cv-status');
        if (file) {
            cvStatus.classList.remove('hidden');
        } else {
            cvStatus.classList.add('hidden');
        }
    });

    // Form submission
    document.getElementById('registration-form').addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Reset error messages
        document.querySelectorAll('.text-red-500').forEach(el => {
            el.classList.add('hidden');
        });
        document.getElementById('error-message').classList.add('hidden');
        
        // Basic validation
        let hasErrors = false;
        
        const nom = document.querySelector('input[name="nom"]').value;
        if (!nom) {
            document.getElementById('nom-error').textContent = 'Le nom est requis';
            document.getElementById('nom-error').classList.remove('hidden');
            hasErrors = true;
        }
        
        const email = document.querySelector('input[name="email"]').value;
        if (!email) {
            document.getElementById('email-error').textContent = 'L\'email est requis';
            document.getElementById('email-error').classList.remove('hidden');
            hasErrors = true;
        } else if (!/\S+@\S+\.\S+/.test(email)) {
            document.getElementById('email-error').textContent = 'L\'email n\'est pas valide';
            document.getElementById('email-error').classList.remove('hidden');
            hasErrors = true;
        }
        
        const password = document.getElementById('password-input').value;
        if (!password) {
            document.getElementById('password-error').textContent = 'Le mot de passe est requis';
            document.getElementById('password-error').classList.remove('hidden');
            hasErrors = true;
        } else if (password.length < 8) {
            document.getElementById('password-error').textContent = 'Le mot de passe doit contenir au moins 8 caractères';
            document.getElementById('password-error').classList.remove('hidden');
            hasErrors = true;
        }
        
        const passwordConfirmation = document.querySelector('input[name="password_confirmation"]').value;
        if (password !== passwordConfirmation) {
            document.getElementById('password-confirmation-error').textContent = 'Les mots de passe ne correspondent pas';
            document.getElementById('password-confirmation-error').classList.remove('hidden');
            hasErrors = true;
        }
        
        if (hasErrors) {
            document.getElementById('error-message').classList.remove('hidden');
            return;
        }
        
        // If validation passes, submit the form
        this.submit();
    });

    // Initialize role selection
    document.addEventListener('DOMContentLoaded', function() {
        selectRole('participant');
    });

    // Theme functionality for register page
    document.addEventListener('DOMContentLoaded', function() {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.classList.remove('theme-light');
            document.body.classList.add('theme-dark');
            document.querySelector('#theme-toggle .fa-moon').classList.add('hidden');
            document.querySelector('#theme-toggle .fa-sun').classList.remove('hidden');
        }

        const themeToggle = document.getElementById('theme-toggle');
        if (themeToggle) {
            themeToggle.addEventListener('click', function() {
                document.body.classList.toggle('theme-dark');
                document.body.classList.toggle('theme-light');
                
                const moonIcon = this.querySelector('.fa-moon');
                const sunIcon = this.querySelector('.fa-sun');
                moonIcon.classList.toggle('hidden');
                sunIcon.classList.toggle('hidden');
                
                localStorage.setItem('theme', 
                    document.body.classList.contains('theme-dark') ? 'dark' : 'light'
                );
            });
        }
    });
</script>
</body>
</html>