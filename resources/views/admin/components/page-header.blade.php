{{-- Admin Page Header Component --}}
<div class="mb-6 flex justify-between items-center flex-wrap gap-4">
    <div class="flex items-center space-x-4">
        @if(isset($backRoute))
            <a href="{{ $backRoute }}" class="btn-secondary py-2 px-4 rounded-lg inline-flex items-center">
                <i class="fas fa-arrow-left mr-2"></i>
                {{ $backText ?? 'Retour' }}
            </a>
        @endif
        
        @if(isset($pageTitle))
            <h1 class="text-2xl font-bold form-text">{{ $pageTitle }}</h1>
        @endif
    </div>
    
    <!-- Quick Navigation -->
    <div class="flex space-x-3 items-center">
        <!-- Current User Info -->
        <div class="flex items-center space-x-2 text-sm form-text">
            <div class="w-8 h-8 bg-gradient-to-r from-purple-500 to-pink-500 rounded-full flex items-center justify-center text-white font-bold text-xs">
                {{ substr(auth()->user()->nom, 0, 1) }}
            </div>
            <span class="hidden sm:inline">{{ auth()->user()->nom }}</span>
            <span class="text-xs px-2 py-1 bg-purple-100 text-purple-800 rounded-full">
                {{ ucfirst(auth()->user()->role) }}
            </span>
        </div>
        
        <!-- Dashboard Button -->
        <a href="{{ route('admin.dashboard') }}" 
           class="btn-secondary py-2 px-3 rounded-lg inline-flex items-center text-sm"
           title="Tableau de Bord">
            <i class="fas fa-tachometer-alt mr-1 sm:mr-2"></i>
            <span class="hidden sm:inline">Tableau de Bord</span>
        </a>
        
        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" 
                    class="bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-lg inline-flex items-center transition-all duration-300 text-sm"
                    title="Déconnexion"
                    onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?')">
                <i class="fas fa-sign-out-alt mr-1 sm:mr-2"></i>
                <span class="hidden sm:inline">Déconnexion</span>
            </button>
        </form>
    </div>
</div>

<style>
    @media (max-width: 640px) {
        .flex-wrap {
            flex-direction: column;
            align-items: stretch;
        }
        .flex-wrap > div:last-child {
            justify-content: space-between;
            margin-top: 1rem;
        }
    }
</style>