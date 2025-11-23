<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Create User</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
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
        }
        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }
        .input-field {
            width: 100%;
            padding: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            font-size: 16px;
        }
        .input-field:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
    </style>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-6">Test - Créer Utilisateur</h1>
        
        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul>
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

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif
        
        <form action="{{ route('admin.users.store') }}" method="POST" id="test-form">
            @csrf
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium mb-2">Nom complet *</label>
                    <input type="text" name="nom" value="{{ old('nom', 'Test User ' . time()) }}" 
                           required class="input-field" placeholder="Nom complet">
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Email *</label>
                    <input type="email" name="email" value="{{ old('email', 'test' . time() . '@example.com') }}" 
                           required class="input-field" placeholder="Email">
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Rôle *</label>
                    <select name="role" required class="input-field">
                        <option value="">Sélectionner un rôle</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrateur</option>
                        <option value="formateur" {{ old('role') == 'formateur' ? 'selected' : '' }}>Formateur</option>
                        <option value="participant" {{ old('role') == 'participant' ? 'selected' : '' }}>Participant</option>
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium mb-2">Mot de passe *</label>
                    <input type="password" name="password" value="password123" 
                           required class="input-field" placeholder="Mot de passe">
                </div>
                
                <input type="hidden" name="password_confirmation" value="password123">
                
                <div>
                    <label class="block text-sm font-medium mb-2">Statut</label>
                    <div class="space-y-2">
                        <label class="flex items-center">
                            <input type="radio" name="est_actif" value="1" checked class="mr-2">
                            <span>Compte actif</span>
                        </label>
                        <label class="flex items-center">
                            <input type="radio" name="est_actif" value="0" class="mr-2">
                            <span>Compte inactif</span>
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="flex space-x-4 mt-8">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-6 rounded-lg">
                    Retour
                </a>
                <button type="submit" id="submit-btn" class="btn-primary">
                    <i class="fas fa-user-plus mr-2"></i>
                    Créer l'utilisateur
                </button>
            </div>
        </form>
    </div>

    <script>
        console.log('Test form loaded');
        
        document.getElementById('test-form').addEventListener('submit', function(e) {
            console.log('Form submitted!');
            const submitBtn = document.getElementById('submit-btn');
            
            // Show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Création en cours...';
            
            // Basic validation
            const nom = document.querySelector('input[name="nom"]').value.trim();
            const email = document.querySelector('input[name="email"]').value.trim();
            const role = document.querySelector('select[name="role"]').value;
            
            if (!nom || !email || !role) {
                e.preventDefault();
                alert('Veuillez remplir tous les champs obligatoires');
                
                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-user-plus mr-2"></i>Créer l\'utilisateur';
                return false;
            }
            
            console.log('Validation passed, submitting...');
        });
        
        console.log('Script ready');
    </script>
</body>
</html>