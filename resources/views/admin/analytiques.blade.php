@extends('admin.dashboard')

@section('title', 'Tableau de Bord Analytique - FormaCNI')
@section('page-title', 'Tableau de Bord Analytique')

@section('content')
<!-- Header Section -->
<div class="relative mb-8">
    <div class="flex items-center justify-between mb-6">
        <div class="flex items-center space-x-4">
            <a href="{{ route('admin.dashboard') }}" 
               class="group flex items-center space-x-2 text-blue-600 hover:text-blue-700 transition-all duration-300 transform hover:translate-x-1">
                <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                    <i class="fas fa-arrow-left text-sm"></i>
                </div>
                <span class="font-medium">Retour au tableau de bord</span>
            </a>
            <div class="h-8 w-px bg-gradient-to-b from-transparent via-gray-300 to-transparent"></div>
            <div>
                <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-800 to-gray-600 bg-clip-text text-transparent mb-2">
                    📊 Tableau de Bord Analytique
                </h1>
                <p class="text-gray-600 font-medium">Surveillez et optimisez les performances de votre plateforme</p>
            </div>
        </div>
        <div class="flex space-x-3">
            <button onclick="refreshStats()" 
                    class="group flex items-center space-x-2 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white hover:shadow-xl transform hover:scale-105 transition-all duration-300 py-3 px-6 rounded-xl font-semibold">
                <i class="fas fa-sync-alt group-hover:animate-spin"></i>
                <span>Actualiser</span>
            </button>
        </div>
    </div>
</div>

<!-- Performance Overview Cards -->
<div class="mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-4 flex items-center">
        <i class="fas fa-chart-line text-blue-500 mr-3"></i>
        Vue d'Ensemble des Performances
    </h2>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Formations Actives -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-green-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -mr-6 -mt-6"></div>
            <div class="p-6 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-play-circle text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-green-600 bg-green-50 px-3 py-1 rounded-full">
                        @if(isset($formationStats['growth']))
                            {{ $formationStats['growth'] > 0 ? '+' . $formationStats['growth'] . '% ↗' : ($formationStats['growth'] < 0 ? $formationStats['growth'] . '% ↘' : 'Stable →') }}
                        @else
                            Stable →
                        @endif
                    </span>
                </div>
                <h3 class="text-green-600 text-sm font-semibold mb-2">FORMATIONS ACTIVES</h3>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $formationStats['active'] }}</p>
                <p class="text-green-500 text-sm font-medium flex items-center">
                    <i class="fas fa-trending-up mr-1"></i>
                    Croissance ce mois
                </p>
            </div>
        </div>

        <!-- Taux de Participation -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-blue-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-full -mr-6 -mt-6"></div>
            <div class="p-6 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-users text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">
                        @if(isset($platformPerformance['participation_trend']))
                            {{ $platformPerformance['participation_trend'] > 0 ? '+' . $platformPerformance['participation_trend'] . '% ↗' : ($platformPerformance['participation_trend'] < 0 ? $platformPerformance['participation_trend'] . '% ↘' : 'Stable →') }}
                        @else
                            Stable →
                        @endif
                    </span>
                </div>
                <h3 class="text-blue-600 text-sm font-semibold mb-2">TAUX DE PARTICIPATION</h3>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $platformPerformance['participation_rate'] }}%</p>
                <p class="text-blue-500 text-sm font-medium flex items-center">
                    <i class="fas fa-chart-pie mr-1"></i>
                    Engagement moyen
                </p>
            </div>
        </div>

        <!-- Comptes Désactivés -->
        <div class="group relative bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-500 transform hover:-translate-y-2 border border-red-100 overflow-hidden">
            <div class="absolute top-0 right-0 w-20 h-20 bg-red-50 rounded-full -mr-6 -mt-6"></div>
            <div class="p-6 relative">
                <div class="flex items-center justify-between mb-4">
                    <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                        <i class="fas fa-user-slash text-white text-lg"></i>
                    </div>
                    <span class="text-sm font-semibold text-red-600 bg-red-50 px-3 py-1 rounded-full">
                        @if(isset($userStats['inactive_trend']))
                            {{ $userStats['inactive_trend'] > 0 ? '+' . $userStats['inactive_trend'] . '% ↗' : ($userStats['inactive_trend'] < 0 ? $userStats['inactive_trend'] . '% ↘' : 'Stable →') }}
                        @else
                            -5% ↘
                        @endif
                    </span>
                </div>
                <h3 class="text-red-600 text-sm font-semibold mb-2">COMPTES DÉSACTIVÉS</h3>
                <p class="text-3xl font-bold text-gray-800 mb-2">{{ $userStats['inactive'] }}</p>
                <p class="text-red-500 text-sm font-medium flex items-center">
                    <i class="fas fa-exclamation-circle mr-1"></i>
                    Nécessite attention
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Detailed Analytics Grid -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <!-- Quick Stats -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-chart-bar text-blue-500 mr-3"></i>
                Statistiques Rapides
            </h3>
        </div>
        <div class="p-6 space-y-5">
            @php
                $stats = [
                    ['label' => 'Total Utilisateurs', 'value' => number_format($userStats['total']), 'icon' => 'fas fa-users', 'color' => 'blue'],
                    ['label' => 'Participants Actifs', 'value' => number_format($userStats['active_participants']), 'icon' => 'fas fa-user-check', 'color' => 'green'],
                    ['label' => 'Formateurs Certifiés', 'value' => number_format($userStats['certified_formateurs']), 'icon' => 'fas fa-chalkboard-teacher', 'color' => 'purple'],
                    ['label' => 'Administrateurs', 'value' => number_format($userStats['admins']), 'icon' => 'fas fa-user-shield', 'color' => 'red'],
                    ['label' => 'Inscriptions Actives', 'value' => number_format($inscriptionStats['active']), 'icon' => 'fas fa-clipboard-list', 'color' => 'orange'],
                    ['label' => 'Formations Total', 'value' => number_format($formationStats['total']), 'icon' => 'fas fa-graduation-cap', 'color' => 'indigo']
                ];
            @endphp
            
            @foreach($stats as $stat)
            <div class="flex items-center justify-between group hover:bg-gray-50 p-3 rounded-xl transition-colors">
                <div class="flex items-center space-x-4">
                    <div class="w-10 h-10 bg-{{ $stat['color'] }}-100 rounded-lg flex items-center justify-center">
                        <i class="{{ $stat['icon'] }} text-{{ $stat['color'] }}-600"></i>
                    </div>
                    <span class="text-sm font-medium text-gray-700">{{ $stat['label'] }}</span>
                </div>
                <span class="text-lg font-bold text-gray-900 group-hover:text-{{ $stat['color'] }}-600 transition-colors">
                    {{ $stat['value'] }}
                </span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Completion Rates by Category -->
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100">
            <h3 class="text-lg font-bold text-gray-800 flex items-center">
                <i class="fas fa-tasks text-green-500 mr-3"></i>
                Progression par Catégorie
            </h3>
        </div>
        <div class="p-6 space-y-6">
            @php
                $categories = [
                    ['name' => 'Développement Web', 'progress' => 85, 'color' => 'green'],
                    ['name' => 'Applications Mobiles', 'progress' => 72, 'color' => 'blue'],
                    ['name' => 'Design & UX', 'progress' => 68, 'color' => 'purple'],
                    ['name' => 'Data Science', 'progress' => 91, 'color' => 'teal']
                ];
            @endphp
            
            @foreach($categories as $category)
            <div class="group">
                <div class="flex justify-between items-center mb-3">
                    <span class="text-sm font-semibold text-gray-700">{{ $category['name'] }}</span>
                    <div class="flex items-center space-x-2">
                        <span class="text-sm font-bold text-gray-900">{{ $category['progress'] }}%</span>
                        <div class="w-2 h-2 bg-{{ $category['color'] }}-500 rounded-full group-hover:animate-pulse"></div>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-3 overflow-hidden">
                    <div class="bg-gradient-to-r from-{{ $category['color'] }}-500 to-{{ $category['color'] }}-600 h-3 rounded-full transition-all duration-1000 ease-out group-hover:shadow-lg" 
                         style="width: {{ $category['progress'] }}%">
                    </div>
                </div>
            </div>
            @endforeach
            
            <!-- Performance Summary -->
            <div class="mt-6 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl border border-blue-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-blue-800">Performance Moyenne</p>
                        <p class="text-xs text-blue-600">Toutes catégories confondues</p>
                    </div>
                    <div class="text-2xl font-bold text-blue-700">
                        {{ round(array_sum(array_column($categories, 'progress')) / count($categories)) }}%
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- System Overview -->
<div class="mt-8 bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="bg-gradient-to-r from-gray-50 to-white px-6 py-4 border-b border-gray-100">
        <h3 class="text-lg font-bold text-gray-800 flex items-center">
            <i class="fas fa-cog text-gray-500 mr-3"></i>
            Aperçu du Système
        </h3>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Disponibilité -->
            <div class="text-center p-4 bg-green-50 rounded-xl border border-green-200">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-server text-green-600"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-1">Disponibilité</h4>
                <p class="text-2xl font-bold text-green-600">99.9%</p>
                <p class="text-sm text-green-500">Excellent</p>
            </div>

            <!-- Utilisateurs Connectés -->
            <div class="text-center p-4 bg-blue-50 rounded-xl border border-blue-200">
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-user-clock text-blue-600"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-1">Utilisateurs Actifs</h4>
                <p class="text-2xl font-bold text-blue-600">{{ $userStats['active_participants'] }}</p>
                <p class="text-sm text-blue-500">Ce mois</p>
            </div>

            <!-- Nouvelles Inscriptions -->
            <div class="text-center p-4 bg-purple-50 rounded-xl border border-purple-200">
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-user-plus text-purple-600"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-1">Nouvelles Inscriptions</h4>
                <p class="text-2xl font-bold text-purple-600">{{ $inscriptionStats['active'] }}</p>
                <p class="text-sm text-purple-500">Confirmées</p>
            </div>

            <!-- Demandes en Attente -->
            <div class="text-center p-4 bg-orange-50 rounded-xl border border-orange-200">
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <i class="fas fa-clock text-orange-600"></i>
                </div>
                <h4 class="font-semibold text-gray-800 mb-1">En Attente</h4>
                <p class="text-2xl font-bold text-orange-600">{{ $formationStats['pending'] }}</p>
                <p class="text-sm text-orange-500">Validations</p>
            </div>
        </div>
    </div>
</div>

<!-- Insights & Recommendations -->
<div class="mt-8 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl shadow-lg border border-blue-100 p-6">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-bold text-blue-800 flex items-center">
            <i class="fas fa-lightbulb text-yellow-500 mr-3"></i>
            Insights & Recommandations
        </h3>
        <span class="text-sm font-semibold text-blue-600 bg-blue-100 px-3 py-1 rounded-full">
            {{ date('d M Y') }}
        </span>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white rounded-xl p-4 border border-blue-100 shadow-sm">
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-thumbs-up text-green-600 text-sm"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-1">Performance Excellente</h4>
                    <p class="text-sm text-gray-600">Votre plateforme montre une croissance constante des utilisateurs actifs.</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-xl p-4 border border-yellow-100 shadow-sm">
            <div class="flex items-start space-x-3">
                <div class="w-8 h-8 bg-yellow-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-bullseye text-yellow-600 text-sm"></i>
                </div>
                <div>
                    <h4 class="font-semibold text-gray-800 mb-1">Opportunité d'Amélioration</h4>
                    <p class="text-sm text-gray-600">Focus sur les catégories Design & UX pour booster l'engagement.</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function refreshStats() {
    // Show loading animation
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner animate-spin mr-2"></i>Actualisation...';
    
    // Simulate API call
    setTimeout(() => {
        location.reload();
    }, 1500);
}

function showNotification(message, type = 'info') {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-xl shadow-lg border transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-50 border-green-200 text-green-800' :
        type === 'error' ? 'bg-red-50 border-red-200 text-red-800' :
        'bg-blue-50 border-blue-200 text-blue-800'
    }`;
    notification.innerHTML = `
        <div class="flex items-center space-x-3">
            <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
            <span>${message}</span>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 5000);
}

// Auto refresh every 5 minutes
setInterval(() => {
    console.log('🔄 Actualisation automatique des données analytiques...');
    // In real implementation, this would fetch new data via AJAX
}, 300000);

// Add some interactive animations
document.addEventListener('DOMContentLoaded', function() {
    // Animate cards on load
    const cards = document.querySelectorAll('.group');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s ease-out';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<style>
/* Custom animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-5px); }
}

.group:hover .floating {
    animation: float 2s ease-in-out infinite;
}

/* Smooth transitions for all interactive elements */
* {
    transition-property: color, background-color, border-color, transform, box-shadow;
    transition-duration: 300ms;
    transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
@endsection