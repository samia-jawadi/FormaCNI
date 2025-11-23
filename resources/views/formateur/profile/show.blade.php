@extends('layouts.formateur')

@section('title', 'Account Management')

@section('page-title', 'Account Management')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Profile Header -->
    <div class="card rounded-lg p-6 mb-6">
        <div class="flex items-center space-x-6">
            <div class="w-20 h-20 bg-gradient-to-r from-blue-500 to-purple-500 rounded-full flex items-center justify-center text-white text-2xl font-bold">
                {{ substr(auth()->user()->nom, 0, 1) }}
            </div>
            <div class="flex-1">
                <h2 class="text-2xl font-bold text-gray-800">{{ auth()->user()->nom }} {{ auth()->user()->prenom }}</h2>
                <p class="text-gray-600">{{ auth()->user()->email }}</p>
                <span class="inline-block mt-2 px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-800 capitalize">
                    Formateur
                </span>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Navigation Sidebar -->
        <div class="lg:col-span-1">
            <div class="card rounded-lg p-6">
                <nav class="space-y-2">
                    <button onclick="showSection('profile')" class="profile-nav-btn w-full text-left px-4 py-3 rounded-lg bg-blue-100 text-blue-700 font-medium">
                        <i class="fas fa-user mr-3"></i>
                        Personal Information
                    </button>
                    <button onclick="showSection('password')" class="profile-nav-btn w-full text-left px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                        <i class="fas fa-lock mr-3"></i>
                        Change Password
                    </button>
                    <button onclick="showSection('account')" class="profile-nav-btn w-full text-left px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 font-medium">
                        <i class="fas fa-cog mr-3"></i>
                        Account Settings
                    </button>
                </nav>
            </div>
        </div>

        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Personal Information Section -->
            <div id="profile-section" class="card rounded-lg p-6">
                <h3 class="text-xl font-semibold mb-6 text-gray-800">Personal Information</h3>

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="space-y-6">
                        <!-- Name Fields -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-800">
                                    First Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="prenom" value="{{ old('prenom', auth()->user()->prenom) }}" required 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="Your first name">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium mb-2 text-gray-800">
                                    Last Name <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nom" value="{{ old('nom', auth()->user()->nom) }}" required 
                                       class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                       placeholder="Your last name">
                            </div>
                        </div>
                        
                        <!-- Email (editable) -->
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">Email Address <span class="text-red-500">*</span></label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="email@example.com">
                        </div>

                        <!-- Phone -->
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">Phone Number</label>
                            <input type="tel" name="telephone" value="{{ old('telephone', auth()->user()->telephone) }}" 
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="Your phone number">
                        </div>

                        <!-- Address -->
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">Address</label>
                            <textarea name="adresse" rows="3"
                                      class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                      placeholder="Your complete address">{{ old('adresse', auth()->user()->adresse) }}</textarea>
                        </div>

                        <!-- Speciality -->
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">Specialization</label>
                            <input type="text" name="specialite" value="{{ old('specialite', auth()->user()->specialite) }}" 
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="Your area of expertise">
                        </div>

                        <!-- CV Upload (moved here from Account Settings) -->
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">CV/Resume</label>
                            @if(auth()->user()->cv_path)
                                <div class="mb-2 text-sm">
                                    <a href="{{ Storage::url(auth()->user()->cv_path) }}" target="_blank" class="text-blue-600 hover:text-blue-700 inline-flex items-center">
                                        <i class="fas fa-file-download mr-2"></i> View Current CV
                                    </a>
                                </div>
                            @endif
                            <input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full p-2 border border-gray-300 rounded-lg">
                            <p class="text-sm text-gray-600 mt-1">Upload your CV/Resume (PDF, DOC, DOCX)</p>
                        </div>

                        <!-- Bio -->
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">Bio/Description</label>
                            <textarea name="bio" rows="4"
                                      class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                      placeholder="Tell us about yourself and your experience">{{ old('bio', auth()->user()->bio) }}</textarea>
                        </div>

                        <!-- Account Information (read-only) -->
                        <div class="bg-gray-50 rounded-lg p-4 border">
                            <h4 class="font-medium text-gray-800 mb-3">Account Information</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Role:</span>
                                    <span class="font-medium text-gray-800 ml-2">Formateur</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Account Created:</span>
                                    <span class="font-medium text-gray-800 ml-2">
                                        {{ auth()->user()->created_at->format('M j, Y') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Last Updated:</span>
                                    <span class="font-medium text-gray-800 ml-2">
                                        {{ auth()->user()->updated_at->format('M j, Y') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Status:</span>
                                    <span class="font-medium {{ auth()->user()->est_actif ? 'text-green-600' : 'text-red-600' }} ml-2">
                                        {{ auth()->user()->est_actif ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex space-x-4">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                        <button type="reset" class="btn-secondary">
                            <i class="fas fa-undo mr-2"></i>
                            Reset
                        </button>
                    </div>
                </form>
            </div>

            <!-- Password Section -->
            <div id="password-section" class="card rounded-lg p-6 hidden">
                <h3 class="text-xl font-semibold mb-6 text-gray-800">Change Password</h3>

                <form action="{{ route('profile.change-password') }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">
                                Current Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="current_password" required 
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="Your current password">
                            @error('current_password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">
                                New Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" required 
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="New password (min. 8 characters)">
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-2 text-gray-800">
                                Confirm New Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" required 
                                   class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" 
                                   placeholder="Confirm new password">
                        </div>

                        <!-- Security Tips -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h4 class="font-medium text-blue-800 mb-2">
                                <i class="fas fa-info-circle mr-2"></i>
                                Security Tips
                            </h4>
                            <ul class="text-sm text-blue-700 space-y-1">
                                <li>• At least 8 characters</li>
                                <li>• Mix uppercase, lowercase, numbers, and symbols</li>
                                <li>• Avoid personal information</li>
                                <li>• Don't reuse this password elsewhere</li>
                            </ul>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-key mr-2"></i>
                            Change Password
                        </button>
                    </div>
                </form>
            </div>

            <!-- Account Settings Section -->
            <div id="account-section" class="card rounded-lg p-6 hidden">
                <h3 class="text-xl font-semibold mb-6 text-gray-800">Account Settings</h3>

                </div>

                <!-- Notification Preferences -->
                <div class="mb-8">
                    <h4 class="font-medium text-gray-800 mb-4">Notification Preferences</h4>
<form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        @csrf
                        <div class="space-y-4">
                            <label class="flex items-center">
                                <input type="checkbox" name="email_formations" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500" 
                                       {{ auth()->user()->email_formations ?? true ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">Formation status updates</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_participants" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                       {{ auth()->user()->email_participants ?? true ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">New participant enrollments</span>
                            </label>
                            <label class="flex items-center">
                                <input type="checkbox" name="email_system" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                       {{ auth()->user()->email_system ?? true ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-700">System announcements</span>
                            </label>
                        </div>
                        <button type="submit" class="mt-4 btn-secondary">
                            <i class="fas fa-save mr-2"></i>
                            Save Preferences
                        </button>
                    </form>
                </div>

                <!-- Account Deactivation -->
                <div class="border border-red-200 rounded-lg p-4 bg-red-50">
                    <h4 class="font-medium text-red-800 mb-2">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        Deactivate Account
                    </h4>
                    <p class="text-sm text-red-700 mb-4">
                        Deactivating your account will disable your access but preserve your data. 
                        Your formations and participant records will remain intact. You can request reactivation by contacting support.
                    </p>
                    <button onclick="confirmDeactivation()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm">
                        <i class="fas fa-user-slash mr-2"></i>
                        Deactivate Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Deactivation Confirmation Modal -->
<div id="deactivationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="card rounded-lg max-w-md w-full">
            <div class="p-6">
                <div class="text-center mb-4">
                    <i class="fas fa-exclamation-triangle text-red-500 text-4xl mb-3"></i>
                    <h3 class="text-lg font-semibold text-gray-800">Confirm Account Deactivation</h3>
                </div>
                <p class="text-gray-600 text-center mb-6">
                    Are you sure you want to deactivate your account? This action will disable your access but preserve your data.
                </p>
<form action="{{ route('profile.delete') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    @csrf
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2 text-gray-800">
                            Enter your password to confirm:
                        </label>
                        <input type="password" name="password" required 
                               class="w-full p-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" 
                               placeholder="Your current password">
                    </div>
                    <div class="flex space-x-4">
                        <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded-lg">
                            Deactivate
                        </button>
                        <button type="button" onclick="closeDeactivationModal()" class="flex-1 btn-secondary">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function showSection(section) {
    // Hide all sections
    document.getElementById('profile-section').classList.add('hidden');
    document.getElementById('password-section').classList.add('hidden');
    document.getElementById('account-section').classList.add('hidden');
    
    // Show selected section
    document.getElementById(section + '-section').classList.remove('hidden');
    
    // Update navigation
    const navButtons = document.querySelectorAll('.profile-nav-btn');
    navButtons.forEach(button => {
        button.classList.remove('bg-blue-100', 'text-blue-700');
        button.classList.add('text-gray-700', 'hover:bg-gray-100');
    });
    
    // Highlight active button
    event.currentTarget.classList.remove('text-gray-700', 'hover:bg-gray-100');
    event.currentTarget.classList.add('bg-blue-100', 'text-blue-700');
}


function confirmDeactivation() {
    document.getElementById('deactivationModal').classList.remove('hidden');
}

function closeDeactivationModal() {
    document.getElementById('deactivationModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('deactivationModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeDeactivationModal();
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    showSection('profile');
});
</script>
@endpush