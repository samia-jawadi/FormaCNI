@extends('layouts.participant')

@section('title', 'Mon Profil - FormaCNI')

@section('page-title', 'Mon Profil')

@section('content')
<div class="mb-6">
    <div class="flex items-center space-x-4">
        <div class="relative">
            @if(Auth::user()->photo)
                <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Photo de profil" 
                     class="w-16 h-16 rounded-full object-cover border-2 border-emerald-200">
            @else
                <div class="w-16 h-16 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full flex items-center justify-center">
                    <i class="fas fa-user text-white text-xl"></i>
                </div>
            @endif
            <button onclick="openPhotoModal()" class="absolute -bottom-1 -right-1 w-6 h-6 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center transition-colors">
                <i class="fas fa-camera text-xs"></i>
            </button>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white">{{ Auth::user()->nom }}</h2>
            <p class="text-gray-600 dark:text-gray-400">{{ Auth::user()->email }}</p>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800">
                <i class="fas fa-circle text-emerald-400 mr-1 text-xs"></i>
                Participant Actif
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Profile Information -->
    <div class="lg:col-span-2">
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Informations Personnelles</h3>
            </div>
            <div class="p-6">

                <form action="{{ route('profile.update') }}" method="POST" id="profile-form" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nom Complet</label>
                            <input type="text" name="nom" value="{{ Auth::user()->nom }}" disabled
                                   class="profile-input input-field w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
                            <input type="email" name="email" value="{{ Auth::user()->email }}" disabled
                                   class="profile-input input-field w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Pronoms</label>
                            <select name="pronoms" disabled class="profile-input input-field w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700">
                                <option value="">Sélectionner...</option>
                                <option value="il/lui" {{ Auth::user()->pronoms == 'il/lui' ? 'selected' : '' }}>Il/Lui</option>
                                <option value="elle/elle" {{ Auth::user()->pronoms == 'elle/elle' ? 'selected' : '' }}>Elle/Elle</option>
                                <option value="iels/elles" {{ Auth::user()->pronoms == 'iels/elles' ? 'selected' : '' }}>Iels/Elles</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Niveau</label>
                            <select name="niveau" disabled class="profile-input input-field w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700">
                                <option value="debutant" {{ Auth::user()->niveau == 'debutant' ? 'selected' : '' }}>Débutant</option>
                                <option value="intermediaire" {{ Auth::user()->niveau == 'intermediaire' ? 'selected' : '' }}>Intermédiaire</option>
                                <option value="avance" {{ Auth::user()->niveau == 'avance' ? 'selected' : '' }}>Avancé</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Adresse</label>
                        <textarea name="adresse" rows="3" disabled
                                  class="profile-input input-field w-full px-4 py-3 rounded-lg bg-gray-100 dark:bg-gray-700" 
                                  placeholder="Votre adresse complète">{{ Auth::user()->adresse }}</textarea>
                    </div>
                    
                    <div id="form-actions" class="hidden">
                        <button type="submit" class="btn-primary px-6 py-3 rounded-lg inline-flex items-center mr-3">
                            <i class="fas fa-save mr-2"></i>
                            Enregistrer
                        </button>
                        <button type="button" onclick="cancelEdit()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg inline-flex items-center">
                            <i class="fas fa-times mr-2"></i>
                            Annuler
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Account Actions -->
    <div class="space-y-6">
        <!-- Account Stats -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Mes Statistiques</h3>
            </div>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-check-circle text-emerald-600 mr-3"></i>
                        <span class="text-gray-700 dark:text-gray-300">Formations Confirmées</span>
                    </div>
                    <span class="font-bold text-emerald-600">{{ Auth::user()->inscriptions()->where('statut', 'CONFIRMEE')->count() }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-clock text-yellow-600 mr-3"></i>
                        <span class="text-gray-700 dark:text-gray-300">En Attente</span>
                    </div>
                    <span class="font-bold text-yellow-600">{{ Auth::user()->inscriptions()->where('statut', 'EN_ATTENTE')->count() }}</span>
                </div>
                
                <div class="flex items-center justify-between p-3 bg-purple-50 dark:bg-purple-900/20 rounded-lg">
                    <div class="flex items-center">
                        <i class="fas fa-star text-purple-600 mr-3"></i>
                        <span class="text-gray-700 dark:text-gray-300">Terminées</span>
                    </div>
                    <span class="font-bold text-purple-600">{{ Auth::user()->inscriptions()->whereHas('formation', function($q) { $q->where('terminee', true); })->count() }}</span>
                </div>
            </div>
        </div>
        
        
        <!-- Password Change -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 cursor-pointer" onclick="togglePasswordForm()">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Changer le mot de passe</h3>
                    <i id="password-arrow" class="fas fa-chevron-down text-gray-400 transition-transform"></i>
                </div>
            </div>
            <div id="password-form" class="hidden">
                <div class="p-6">
                    @if(session('success_password'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            <i class="fas fa-check-circle mr-2"></i>
                            {{ session('success_password') }}
                        </div>
                    @endif
                    
                    <form action="{{ route('profile.change-password') }}" method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Mot de passe actuel</label>
                                <input type="password" name="current_password" class="input-field w-full px-4 py-3 rounded-lg" required>
                                @error('current_password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nouveau mot de passe</label>
                                <input type="password" name="password" class="input-field w-full px-4 py-3 rounded-lg" required minlength="6">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Confirmer le nouveau mot de passe</label>
                                <input type="password" name="password_confirmation" class="input-field w-full px-4 py-3 rounded-lg" required>
                            </div>
                            
                            <div class="flex space-x-3">
                                <button type="submit" class="flex-1 bg-yellow-600 hover:bg-yellow-700 text-white py-3 px-4 rounded-lg transition-colors">
                                    <i class="fas fa-key mr-2"></i>
                                    Changer le mot de passe
                                </button>
                                <button type="button" onclick="togglePasswordForm()" class="px-6 py-3 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                    Annuler
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <!-- Account Actions -->
        <div class="card">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Actions du Compte</h3>
            </div>
            <div class="p-6 space-y-3">
                <button onclick="enableEdit()" id="edit-btn" class="w-full flex items-center justify-center p-3 bg-blue-50 hover:bg-blue-100 dark:bg-blue-900/20 dark:hover:bg-blue-900/30 rounded-lg transition-colors">
                    <i class="fas fa-edit text-blue-600 mr-3"></i>
                    <span class="text-blue-700 dark:text-blue-300">Modifier</span>
                </button>
                
                <button onclick="confirmDelete()" class="w-full flex items-center justify-center p-3 bg-red-50 hover:bg-red-100 dark:bg-red-900/20 dark:hover:bg-red-900/30 rounded-lg transition-colors">
                    <i class="fas fa-trash text-red-600 mr-3"></i>
                    <span class="text-red-700 dark:text-red-300">Supprimer le Compte</span>
                </button>
                
                <a href="{{ route('participant.formations') }}" class="w-full flex items-center justify-center p-3 bg-green-50 hover:bg-green-100 dark:bg-green-900/20 dark:hover:bg-green-900/30 rounded-lg transition-colors">
                    <i class="fas fa-book text-green-600 mr-3"></i>
                    <span class="text-green-700 dark:text-green-300">Mes Formations</span>
                </a>
                
                <a href="{{ route('formations.index') }}" class="w-full flex items-center justify-center p-3 bg-purple-50 hover:bg-purple-100 dark:bg-purple-900/20 dark:hover:bg-purple-900/30 rounded-lg transition-colors">
                    <i class="fas fa-search text-purple-600 mr-3"></i>
                    <span class="text-purple-700 dark:text-purple-300">Parcourir Formations</span>
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Photo Upload Modal -->
<div id="photoModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Changer la photo de profil</h3>
                <button onclick="closePhotoModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="photo-form">
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                    <div class="flex justify-center mb-4">
                        @if(Auth::user()->photo)
                            <img src="{{ Storage::url(Auth::user()->photo) }}" alt="Photo actuelle" 
                                 class="w-24 h-24 rounded-full object-cover border-2 border-gray-200" id="current-photo">
                        @else
                            <div class="w-24 h-24 bg-gradient-to-r from-emerald-400 to-teal-500 rounded-full flex items-center justify-center" id="current-photo">
                                <i class="fas fa-user text-white text-2xl"></i>
                            </div>
                        @endif
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nouvelle photo</label>
                        <input type="file" name="photo" id="photo-input" 
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"
                               accept="image/*" onchange="previewPhoto(event)">
                        <p class="text-xs text-gray-500 mt-1">Formats acceptés: JPG, PNG, GIF (max 2MB)</p>
                        @error('photo')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <div class="flex justify-between">
                        @if(Auth::user()->photo)
                            <button type="button" onclick="removePhoto()" class="px-4 py-2 bg-red-500 hover:bg-red-600 text-white rounded-lg transition-colors">
                                <i class="fas fa-trash mr-1"></i>
                                Supprimer
                            </button>
                        @else
                            <div></div>
                        @endif
                        
                        <div class="space-x-2">
                            <button type="button" onclick="closePhotoModal()" class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                                Annuler
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded-lg transition-colors">
                                <i class="fas fa-save mr-1"></i>
                                Enregistrer
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            
            <!-- Remove Photo Form -->
            <form id="remove-photo-form" action="{{ route('profile.update') }}" method="POST" style="display: none;">
                @csrf
                @method('PUT')
                <input type="hidden" name="remove_photo" value="1">
            </form>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function enableEdit() {
        // Enable all form inputs
        document.querySelectorAll('.profile-input').forEach(input => {
            input.disabled = false;
            input.classList.remove('bg-gray-100', 'dark:bg-gray-700');
            input.classList.add('bg-white', 'dark:bg-gray-800');
        });
        
        // Show form action buttons
        document.getElementById('form-actions').classList.remove('hidden');
        
        // Hide edit button
        document.getElementById('edit-btn').classList.add('hidden');
    }
    
    function cancelEdit() {
        // Disable all form inputs
        document.querySelectorAll('.profile-input').forEach(input => {
            input.disabled = true;
            input.classList.add('bg-gray-100', 'dark:bg-gray-700');
            input.classList.remove('bg-white', 'dark:bg-gray-800');
        });
        
        // Hide form action buttons
        document.getElementById('form-actions').classList.add('hidden');
        
        // Show edit button
        document.getElementById('edit-btn').classList.remove('hidden');
        
        // Reset form to original values
        document.getElementById('profile-form').reset();
        location.reload(); // Reload to restore original values
    }
    
    function togglePasswordForm() {
        const passwordForm = document.getElementById('password-form');
        const arrow = document.getElementById('password-arrow');
        
        if (passwordForm.classList.contains('hidden')) {
            passwordForm.classList.remove('hidden');
            arrow.classList.remove('fa-chevron-down');
            arrow.classList.add('fa-chevron-up');
        } else {
            passwordForm.classList.add('hidden');
            arrow.classList.remove('fa-chevron-up');
            arrow.classList.add('fa-chevron-down');
            // Clear form when hiding
            passwordForm.querySelector('form').reset();
        }
    }
    
    // Auto-show password form if there are password-related errors or success
    document.addEventListener('DOMContentLoaded', function() {
        @if($errors->has('current_password') || $errors->has('password') || session('success_password'))
            togglePasswordForm();
        @endif
    });
    
    function confirmDelete() {
        if (confirm('Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible.')) {
            if (confirm('Dernière confirmation : Voulez-vous vraiment supprimer définitivement votre compte ?')) {
                // Create a form for account deletion
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("profile.delete") }}';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);
                
                document.body.appendChild(form);
                form.submit();
            }
        }
    }
    
    // Photo Modal Functions
    function openPhotoModal() {
        document.getElementById('photoModal').classList.remove('hidden');
    }
    
    function closePhotoModal() {
        document.getElementById('photoModal').classList.add('hidden');
        document.getElementById('photo-input').value = '';
        // Reset preview to current photo
        @if(Auth::user()->photo)
            document.getElementById('current-photo').innerHTML = '<img src="{{ Storage::url(Auth::user()->photo) }}" alt="Photo actuelle" class="w-24 h-24 rounded-full object-cover border-2 border-gray-200">';
        @else
            document.getElementById('current-photo').innerHTML = '<i class="fas fa-user text-white text-2xl"></i>';
        @endif
    }
    
    function previewPhoto(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('current-photo').innerHTML = 
                    '<img src="' + e.target.result + '" alt="Aperçu" class="w-24 h-24 rounded-full object-cover border-2 border-gray-200">';
            };
            reader.readAsDataURL(file);
        }
    }
    
    function removePhoto() {
        if (confirm('Êtes-vous sûr de vouloir supprimer votre photo de profil ?')) {
            document.getElementById('remove-photo-form').submit();
        }
    }
</script>
@endsection
