<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin - FormaCNI')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --secondary: #8b5cf6;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --info: #06b6d4;
            
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;
            
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-sidebar: #0f172a;
            --bg-card: #ffffff;
            
            --border-color: #e2e8f0;
            --sidebar-text: #f1f5f9;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .theme-dark {
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;
            
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-card: #1e293b;
            --bg-sidebar: #0b1220;
            
            --border-color: #334155;
            --sidebar-text: #f1f5f9;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.3);
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.3), 0 2px 4px -1px rgba(0, 0, 0, 0.2);
            --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.2);
            --shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.3), 0 10px 10px -5px rgba(0, 0, 0, 0.2);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            overflow-x: hidden;
        }

        /* Enhanced Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translate3d(0, 30px, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translate3d(-20px, 0, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translate3d(20px, 0, 0);
            }
            to {
                opacity: 1;
                transform: translate3d(0, 0, 0);
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.9);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -468px 0;
            }
            100% {
                background-position: 468px 0;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-6px);
            }
        }

        @keyframes gradientShift {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Background Effects */
        .theme-light body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            background-attachment: fixed;
        }

        .theme-dark body {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            background-attachment: fixed;
        }

        /* Glass Morphism Effect */
        .glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .theme-dark .glass {
            background: rgba(30, 41, 59, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Utility Classes */
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-in-left {
            animation: slideInLeft 0.5s ease-out;
        }

        .animate-slide-in-right {
            animation: slideInRight 0.5s ease-out;
        }

        .animate-scale-in {
            animation: scaleIn 0.3s ease-out;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .gradient-animated {
            background: linear-gradient(-45deg, var(--primary), var(--secondary), var(--info), var(--success));
            background-size: 400% 400%;
            animation: gradientShift 8s ease infinite;
        }

        .hover-lift {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-xl);
        }

        .hover-glow:hover {
            box-shadow: 0 0 20px rgba(99, 102, 241, 0.3);
        }

        /* Layout Components */
        .sidebar {
            background: var(--bg-sidebar);
            color: var(--sidebar-text);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .sidebar-item {
            transition: all 0.3s ease;
            border-radius: 0.75rem;
            margin: 0.25rem 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .sidebar-item::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 3px;
            background: var(--primary);
            transform: scaleY(0);
            transition: transform 0.3s ease;
        }

        .sidebar-item:hover {
            background: rgba(99, 102, 241, 0.1);
            transform: translateX(4px);
        }

        .sidebar-item:hover::before {
            transform: scaleY(1);
        }

        .sidebar-item.active {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            box-shadow: var(--shadow-lg);
        }

        .sidebar-item.active::before {
            transform: scaleY(1);
            background: white;
        }

        .header {
            background: var(--bg-card);
            border-bottom: 1px solid var(--border-color);
            backdrop-filter: blur(10px);
            position: sticky;
            top: 0;
            z-index: 40;
        }

        .theme-light .header {
            background: rgba(255, 255, 255, 0.8);
        }

        .theme-dark .header {
            background: rgba(30, 41, 59, 0.8);
        }

        .card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            box-shadow: var(--shadow);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }

        .card:hover::before {
            transform: scaleX(1);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.1), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
        }

        .stat-card:hover::after {
            left: 50%;
            top: 50%;
        }

        /* Enhanced Form Elements */
        .input-field {
            background: var(--bg-primary);
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            transform: translateY(-1px);
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            font-size: 0.875rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn:hover::before {
            left: 100%;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            color: white;
            box-shadow: var(--shadow);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--bg-primary);
            transform: translateY(-1px);
        }

        /* Enhanced Table Styles */
        .table-container {
            background: var(--bg-card);
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .table-header {
            background: var(--bg-secondary);
            border-bottom: 1px solid var(--border-color);
        }

        .table-header th {
            padding: 1rem 1.5rem;
            font-weight: 600;
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-secondary);
        }

        .table-row {
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--border-color);
        }

        .table-row:last-child {
            border-bottom: none;
        }

        .table-row:hover {
            background: var(--bg-secondary);
            transform: scale(1.01);
        }

        .table-row td {
            padding: 1rem 1.5rem;
            font-size: 0.875rem;
        }

        /* Badge Styles */
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

        .badge-warning {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #06b6d4, #0891b2);
            color: white;
        }

        /* Modal Styles */
        .modal-overlay {
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(8px);
            animation: fadeInUp 0.3s ease-out;
        }

        .modal-content {
            background: var(--bg-card);
            border-radius: 1.5rem;
            box-shadow: var(--shadow-xl);
            animation: scaleIn 0.3s ease-out;
            border: 1px solid var(--border-color);
        }

        /* Notification Styles */
        .notification-dropdown {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 1rem;
            box-shadow: var(--shadow-xl);
            animation: slideInRight 0.3s ease-out;
        }

        .notification-item {
            transition: all 0.3s ease;
            border-bottom: 1px solid var(--border-color);
        }

        .notification-item:hover {
            background: var(--bg-secondary);
            transform: translateX(4px);
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }

        /* Loading Animation */
        .loading-shimmer {
            background: linear-gradient(90deg, var(--bg-secondary) 25%, var(--bg-primary) 50%, var(--bg-secondary) 75%);
            background-size: 200% 100%;
            animation: shimmer 1.5s infinite;
        }

        /* Floating Elements */
        .floating-element {
            animation: float 6s ease-in-out infinite;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                position: fixed;
                z-index: 50;
                height: 100vh;
            }
            
            .sidebar.mobile-open {
                transform: translateX(0);
            }
            
            .mobile-menu-btn {
                display: block;
            }
        }

        /* Custom Utilities */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .border-gradient {
            border: 2px solid;
            border-image: linear-gradient(135deg, var(--primary), var(--secondary)) 1;
        }

        /* Ensure text readability */
        .text-readable {
            color: var(--text-primary);
        }

        .text-muted {
            color: var(--text-muted);
        }

        h1, h2, h3, h4, h5, h6 {
            color: var(--text-primary);
            font-weight: 700;
            line-height: 1.2;
        }

        /* Focus states for accessibility */
        button:focus, a:focus, input:focus, select:focus {
            outline: 2px solid var(--primary);
            outline-offset: 2px;
        }
    </style>
</head>
<body class="theme-light">
    <!-- Mobile Menu Button -->
    <div class="md:hidden fixed top-4 left-4 z-50">
        <button id="mobileMenuBtn" class="btn btn-primary p-3 rounded-full shadow-lg">
            <i class="fas fa-bars"></i>
        </button>
    </div>

    <!-- Main Layout -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar w-64 flex-shrink-0 md:translate-x-0 transform transition-transform duration-300">
            <div class="sidebar-content">
                <!-- Logo Section -->
                <div class="p-6 border-b border-gray-700">
                    <div class="flex items-center space-x-3 animate-slide-in-left">
                        <div class="w-12 h-12 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg floating-element">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold text-white">FormaCNI</h2>
                            <p class="text-sm text-gray-300">Admin Dashboard</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="mt-6 px-3 space-y-1">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="sidebar-item flex items-center space-x-3 p-3 transition-all duration-300 {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt w-5 text-center"></i>
                        <span class="font-medium">Tableau de Bord</span>
                    </a>
                    
                    <a href="{{ route('admin.users.index') }}" 
                       class="sidebar-item flex items-center space-x-3 p-3 transition-all duration-300 {{ Request::is('admin/users') ? 'active' : '' }}">
                        <i class="fas fa-users w-5 text-center"></i>
                        <span class="font-medium">Gestion Utilisateurs</span>
                    </a>
                    
                    <a href="{{ route('admin.participants') }}" 
                       class="sidebar-item flex items-center space-x-3 p-3 transition-all duration-300 {{ Request::is('admin/participants') ? 'active' : '' }}">
                        <i class="fas fa-user-graduate w-5 text-center"></i>
                        <span class="font-medium">Participants</span>
                    </a>
                    
                    <a href="{{ route('admin.formations.index') }}" 
                       class="sidebar-item flex items-center space-x-3 p-3 transition-all duration-300 {{ Request::is('admin/formations') ? 'active' : '' }}">
                        <i class="fas fa-book w-5 text-center"></i>
                        <span class="font-medium">Formations</span>
                    </a>
                    
                    <a href="{{ route('admin.analytics') }}" 
                       class="sidebar-item flex items-center space-x-3 p-3 transition-all duration-300 {{ Request::is('admin/analytics') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar w-5 text-center"></i>
                        <span class="font-medium">Analytiques</span>
                    </a>
                </nav>
            </div>

            <!-- User Section -->
            <div class="p-4 border-t border-gray-700">
                <div class="space-y-2">
                    <a href="{{ route('profile.show') }}" 
                       class="sidebar-item flex items-center space-x-3 p-3 transition-all duration-300">
                        <i class="fas fa-user-cog w-5 text-center"></i>
                        <span class="font-medium">Mon Compte</span>
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                class="sidebar-item w-full text-left flex items-center space-x-3 p-3 text-red-300 hover:text-white hover:bg-red-500/20 transition-all duration-300">
                            <i class="fas fa-sign-out-alt w-5 text-center"></i>
                            <span class="font-medium">Déconnexion</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="header">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <h1 class="header-title text-2xl font-bold text-gradient">@yield('page-title', 'Tableau de Bord')</h1>
                    </div>
                    
                    <div class="flex items-center space-x-3">
                        <!-- Theme Toggle -->
                        <button id="theme-toggle" 
                                class="btn btn-secondary p-3 rounded-xl transition-all duration-300 hover-lift">
                            <i class="fas fa-moon text-yellow-500"></i>
                        </button>

                        <!-- Notifications -->
                        <div class="relative">
                            <button id="notifications-toggle" 
                                    class="btn btn-secondary p-3 rounded-xl transition-all duration-300 hover-lift relative">
                                <i class="fas fa-bell"></i>
                                <span id="notification-badge" 
                                      class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full border-2 border-white"></span>
                            </button>
                            
                            <!-- Notifications Dropdown -->
                            <div id="notifications-dropdown" 
                                 class="notification-dropdown absolute right-0 mt-2 w-80 hidden z-50">
                                <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                                    <h3 class="text-lg font-semibold text-readable">Notifications</h3>
                                    <p class="text-sm text-muted">Activités récentes</p>
                                </div>
                                
                                <div id="notifications-content" class="max-h-96 overflow-y-auto">
                                    <!-- Loading State -->
                                    <div id="notifications-loading" class="p-4 text-center">
                                        <div class="loading-shimmer h-4 rounded mb-2"></div>
                                        <div class="loading-shimmer h-3 rounded w-2/3 mx-auto"></div>
                                    </div>
                                    
                                    <!-- Empty State -->
                                    <div id="no-notifications" class="p-6 text-center hidden">
                                        <i class="fas fa-bell-slash text-muted text-3xl mb-3"></i>
                                        <p class="text-sm text-muted">Aucune notification</p>
                                    </div>
                                    
                                    <!-- Notifications List -->
                                    <div id="notifications-list" class="hidden"></div>
                                </div>
                                
                                <div class="p-3 border-t border-gray-200 dark:border-gray-700">
                                    <button id="mark-all-read" class="w-full text-center text-sm text-primary hover:text-primary-dark font-medium transition-colors">
                                        Marquer tout comme lu
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- User Profile -->
                        <div class="flex items-center space-x-3 p-2 rounded-xl bg-secondary/10">
                            <div class="w-8 h-8 bg-gradient-to-r from-primary to-secondary rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-bold">A</span>
                            </div>
                            <span class="text-sm font-medium text-readable hidden md:block">Administrateur</span>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-auto p-6">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Enhanced Create Admin Modal -->
    <div id="createAdminModal" class="fixed inset-0 z-50 hidden">
        <div class="modal-overlay absolute inset-0" onclick="closeCreateAdminModal()"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="modal-content w-full max-w-md">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-xl font-bold text-gradient">Créer un Administrateur</h3>
                        <button onclick="closeCreateAdminModal()" 
                                class="text-muted hover:text-readable transition-colors p-2 rounded-lg hover:bg-secondary/10">
                            <i class="fas fa-times text-lg"></i>
                        </button>
                    </div>

                    <form id="createAdminForm" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold mb-2 text-readable">Nom Complet</label>
                            <input type="text" name="nom" 
                                   class="input-field" 
                                   placeholder="Nom complet" 
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2 text-readable">Email</label>
                            <input type="email" name="email" 
                                   class="input-field" 
                                   placeholder="email@example.com" 
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2 text-readable">Mot de Passe</label>
                            <input type="password" name="password" 
                                   class="input-field" 
                                   placeholder="••••••••" 
                                   required>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2 text-readable">Confirmation</label>
                            <input type="password" name="password_confirmation" 
                                   class="input-field" 
                                   placeholder="••••••••" 
                                   required>
                        </div>

                        <div class="flex space-x-3 pt-4">
                            <button type="button" 
                                    onclick="closeCreateAdminModal()" 
                                    class="flex-1 btn btn-secondary">
                                Annuler
                            </button>
                            <button type="submit" 
                                    class="flex-1 btn btn-primary">
                                <i class="fas fa-user-plus mr-2"></i>
                                Créer
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Enhanced Theme Toggle
        const themeBtn = document.getElementById('theme-toggle');
        if (themeBtn) {
            themeBtn.addEventListener('click', function() {
                const isDark = document.body.classList.contains('theme-dark');
                document.body.classList.toggle('theme-dark');
                document.body.classList.toggle('theme-light');
                
                const icon = this.querySelector('i');
                if (!isDark) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                    icon.classList.remove('text-yellow-500');
                    icon.classList.add('text-orange-400');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                    icon.classList.remove('text-orange-400');
                    icon.classList.add('text-yellow-500');
                }
                
                localStorage.setItem('theme', isDark ? 'light' : 'dark');
            });
        }

        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const sidebar = document.getElementById('sidebar');
        
        if (mobileMenuBtn && sidebar) {
            mobileMenuBtn.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
            });
        }

        // Enhanced Count-up Animation
        function animateCount(el) {
            const target = Number(el.dataset.count || el.dataset.target || '0');
            const duration = Number(el.dataset.duration || 1200);
            const start = 0;
            const startTime = performance.now();
            
            function frame(now) {
                const p = Math.min((now - startTime) / duration, 1);
                const eased = 1 - Math.pow(1 - p, 3);
                el.textContent = Math.round(start + (target - start) * eased).toLocaleString('fr-FR');
                if (p < 1) requestAnimationFrame(frame);
            }
            requestAnimationFrame(frame);
        }

        // Intersection Observer for Animations
        const appearObserver = new IntersectionObserver((entries) => {
            entries.forEach(e => {
                if (e.isIntersecting) {
                    e.target.classList.add('animate-fade-in-up');
                    if (e.target.dataset.count) animateCount(e.target);
                    appearObserver.unobserve(e.target);
                }
            });
        }, { threshold: 0.1 });

        // Initialize on DOM Load
        document.addEventListener('DOMContentLoaded', function() {
            // Load saved theme
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.add('theme-dark');
                document.body.classList.remove('theme-light');
                const icon = document.querySelector('#theme-toggle i');
                if (icon) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                    icon.classList.remove('text-yellow-500');
                    icon.classList.add('text-orange-400');
                }
            }

            // Initialize animations
            document.querySelectorAll('.card, .stat-card, [data-count]').forEach(el => {
                appearObserver.observe(el);
            });
            
            // Add hover effects to cards
            document.querySelectorAll('.card').forEach((card, index) => {
                card.classList.add('hover-lift');
                card.style.animationDelay = (index * 100) + 'ms';
            });

            // Initialize floating elements
            document.querySelectorAll('.floating-element').forEach((el, index) => {
                el.style.animationDelay = (index * 2) + 's';
            });

            // Load notifications on page load
            loadNotifications();
        });

        // Enhanced Notifications System
        const notificationsToggle = document.getElementById('notifications-toggle');
        const notificationsDropdown = document.getElementById('notifications-dropdown');
        const notificationsBadge = document.getElementById('notification-badge');
        const notificationsContent = document.getElementById('notifications-content');
        const notificationsLoading = document.getElementById('notifications-loading');
        const noNotifications = document.getElementById('no-notifications');
        const notificationsList = document.getElementById('notifications-list');
        const markAllReadBtn = document.getElementById('mark-all-read');
        
        let notificationsOpen = false;
        let currentNotifications = [];

        // Toggle notifications dropdown
        if (notificationsToggle && notificationsDropdown) {
            notificationsToggle.addEventListener('click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                
                if (notificationsOpen) {
                    closeNotifications();
                } else {
                    openNotifications();
                }
            });
        }

        // Mark all as read functionality
        if (markAllReadBtn) {
            markAllReadBtn.addEventListener('click', function() {
                markAllNotificationsAsRead();
            });
        }

        function openNotifications() {
            notificationsDropdown.classList.remove('hidden');
            notificationsOpen = true;
            
            // Add opening animation
            notificationsDropdown.style.transform = 'scale(0.95)';
            notificationsDropdown.style.opacity = '0';
            
            setTimeout(() => {
                notificationsDropdown.style.transform = 'scale(1)';
                notificationsDropdown.style.opacity = '1';
            }, 10);
            
            // Refresh notifications when opening
            loadNotifications();
        }

        function closeNotifications() {
            notificationsDropdown.style.transform = 'scale(0.95)';
            notificationsDropdown.style.opacity = '0';
            
            setTimeout(() => {
                notificationsDropdown.classList.add('hidden');
                notificationsOpen = false;
            }, 200);
        }

        function loadNotifications() {
            // Show loading state
            notificationsLoading.classList.remove('hidden');
            noNotifications.classList.add('hidden');
            notificationsList.classList.add('hidden');

            // Simulate API call to fetch real notifications
            setTimeout(() => {
                // Get real pending formations and demands count from your Laravel backend
                const pendingFormationsCount = 0; // Replace with actual data
                const pendingDemandsCount = 0; // Replace with actual data
                
                const mockNotifications = [
                    {
                        id: 1,
                        type: 'formation_request',
                        title: 'Nouvelles demandes de formation',
                        message: `${pendingDemandsCount} nouvelle(s) demande(s) de formation en attente de validation`,
                        time: 'À l\'instant',
                        unread: true,
                        link: '#'
                    },
                    {
                        id: 2,
                        type: 'formation_pending',
                        title: 'Formations en attente',
                        message: `${pendingFormationsCount} formation(s) nécessitent votre approbation`,
                        time: 'Il y a 5 minutes',
                        unread: true,
                        link: '#'
                    },
                    {
                        id: 3,
                        type: 'new_registration',
                        title: 'Nouveaux utilisateurs',
                        message: '3 nouveaux participants se sont inscrits cette semaine',
                        time: 'Il y a 2 heures',
                        unread: false,
                        link: '#'
                    },
                    {
                        id: 4,
                        type: 'system_update',
                        title: 'Mise à jour système',
                        message: 'Une nouvelle version de la plateforme est disponible',
                        time: 'Il y a 1 jour',
                        unread: false,
                        link: '#'
                    }
                ].filter(notification => {
                    // Filter out notifications that have 0 count
                    if (notification.type === 'formation_request' && pendingDemandsCount === 0) return false;
                    if (notification.type === 'formation_pending' && pendingFormationsCount === 0) return false;
                    return true;
                });

                currentNotifications = mockNotifications;
                displayNotifications(mockNotifications);
            }, 1000);
        }

        function displayNotifications(notifications) {
            notificationsLoading.classList.add('hidden');

            if (notifications.length === 0) {
                noNotifications.classList.remove('hidden');
                notificationsBadge.classList.add('hidden');
                return;
            }

            // Update badge with unread count
            const unreadCount = notifications.filter(n => n.unread).length;
            updateNotificationBadge(unreadCount);

            // Display notifications
            notificationsList.innerHTML = '';
            notifications.forEach(notification => {
                const notificationElement = createNotificationElement(notification);
                notificationsList.appendChild(notificationElement);
            });

            notificationsList.classList.remove('hidden');
        }

        function createNotificationElement(notification) {
            const div = document.createElement('div');
            div.className = `notification-item p-4 cursor-pointer transition-all duration-200 ${
                notification.unread ? 'bg-blue-50 dark:bg-blue-900/10 border-l-4 border-blue-500' : 'bg-white dark:bg-gray-800'
            } hover:bg-gray-50 dark:hover:bg-gray-700`;

            const iconClass = getNotificationIcon(notification.type);
            const iconColor = getNotificationIconColor(notification.type);

            div.innerHTML = `
                <div class="flex items-start space-x-3">
                    <div class="w-10 h-10 ${iconColor} rounded-xl flex items-center justify-center flex-shrink-0 mt-1">
                        <i class="${iconClass} text-white text-sm"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between mb-2">
                            <p class="text-sm font-semibold text-readable leading-tight">
                                ${notification.title}
                            </p>
                            ${notification.unread ? 
                                '<div class="w-2 h-2 bg-blue-500 rounded-full flex-shrink-0 mt-1 ml-2 animate-pulse"></div>' : 
                                ''
                            }
                        </div>
                        <p class="text-sm text-muted leading-relaxed mb-2">
                            ${notification.message}
                        </p>
                        <div class="flex items-center justify-between">
                            <span class="text-xs text-gray-500 dark:text-gray-400 flex items-center">
                                <i class="fas fa-clock mr-1"></i>
                                ${notification.time}
                            </span>
                            <button onclick="markNotificationAsRead(${notification.id})" 
                                    class="text-xs text-primary hover:text-primary-dark font-medium transition-colors">
                                ${notification.unread ? 'Marquer comme lu' : 'Lu'}
                            </button>
                        </div>
                    </div>
                </div>
            `;

            // Add click handler for the entire notification
            div.addEventListener('click', (e) => {
                if (!e.target.closest('button')) {
                    handleNotificationClick(notification);
                }
            });

            return div;
        }

        function getNotificationIcon(type) {
            const icons = {
                'formation_request': 'fas fa-file-alt',
                'formation_pending': 'fas fa-clock',
                'new_registration': 'fas fa-users',
                'system_update': 'fas fa-sync',
                'default': 'fas fa-bell'
            };
            return icons[type] || icons.default;
        }

        function getNotificationIconColor(type) {
            const colors = {
                'formation_request': 'bg-orange-500',
                'formation_pending': 'bg-yellow-500',
                'new_registration': 'bg-green-500',
                'system_update': 'bg-purple-500',
                'default': 'bg-gray-500'
            };
            return colors[type] || colors.default;
        }

        function updateNotificationBadge(unreadCount) {
            if (unreadCount > 0) {
                notificationsBadge.classList.remove('hidden');
                if (unreadCount > 9) {
                    notificationsBadge.textContent = '9+';
                    notificationsBadge.classList.add('w-4', 'h-4', 'text-xs', 'flex', 'items-center', 'justify-center');
                } else if (unreadCount > 1) {
                    notificationsBadge.textContent = unreadCount;
                    notificationsBadge.classList.add('w-4', 'h-4', 'text-xs', 'flex', 'items-center', 'justify-center');
                } else {
                    notificationsBadge.textContent = '';
                    notificationsBadge.classList.remove('w-4', 'h-4', 'text-xs');
                }
            } else {
                notificationsBadge.classList.add('hidden');
            }
        }

        function markNotificationAsRead(notificationId) {
            const notification = currentNotifications.find(n => n.id === notificationId);
            if (notification && notification.unread) {
                notification.unread = false;
                
                // Update the badge
                const unreadCount = currentNotifications.filter(n => n.unread).length;
                updateNotificationBadge(unreadCount);
                
                // Re-render notifications
                displayNotifications(currentNotifications);
                
                // Show feedback
                showToast('Notification marquée comme lue', 'success');
            }
        }

        function markAllNotificationsAsRead() {
            currentNotifications.forEach(notification => {
                notification.unread = false;
            });
            
            // Update the badge
            updateNotificationBadge(0);
            
            // Re-render notifications
            displayNotifications(currentNotifications);
            
            // Show feedback
            showToast('Toutes les notifications marquées comme lues', 'success');
        }

        function handleNotificationClick(notification) {
            if (notification.link && notification.link !== '#') {
                window.location.href = notification.link;
            }
            
            // Mark as read when clicked
            if (notification.unread) {
                markNotificationAsRead(notification.id);
            }
            
            closeNotifications();
        }

        // Close notifications when clicking outside
        document.addEventListener('click', function(e) {
            if (notificationsOpen && 
                !notificationsToggle.contains(e.target) && 
                !notificationsDropdown.contains(e.target)) {
                closeNotifications();
            }
        });

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && notificationsOpen) {
                closeNotifications();
            }
        });

        // Auto-refresh notifications every 30 seconds
        setInterval(() => {
            if (notificationsOpen) {
                loadNotifications();
            }
        }, 30000);

        // Toast Notification System
        function showToast(message, type = 'info') {
            const toast = document.createElement('div');
            toast.className = `fixed top-4 right-4 p-4 rounded-xl text-white font-medium shadow-lg transform translate-x-full transition-all duration-300 z-50 ${
                type === 'success' ? 'bg-green-500' : 
                type === 'error' ? 'bg-red-500' : 
                'bg-blue-500'
            }`;
            toast.innerHTML = `
                <div class="flex items-center space-x-3">
                    <i class="fas fa-${type === 'success' ? 'check' : type === 'error' ? 'exclamation-triangle' : 'info'}"></i>
                    <span class="text-sm">${message}</span>
                </div>
            `;
            
            document.body.appendChild(toast);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(0)';
            }, 100);
            
            setTimeout(() => {
                toast.style.transform = 'translateX(100%)';
                setTimeout(() => {
                    document.body.removeChild(toast);
                }, 300);
            }, 4000);
        }

        // Modal Functions
        function openCreateAdminModal() {
            document.getElementById('createAdminModal').classList.remove('hidden');
        }

        function closeCreateAdminModal() {
            document.getElementById('createAdminModal').classList.add('hidden');
        }

        // Enhanced Form Submission
        document.getElementById('createAdminForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const password = formData.get('password');
            const passwordConfirmation = formData.get('password_confirmation');
            
            if (password !== passwordConfirmation) {
                showToast('Les mots de passe ne correspondent pas!', 'error');
                return;
            }
            
            if (password.length < 8) {
                showToast('Le mot de passe doit contenir au moins 8 caractères!', 'error');
                return;
            }
            
            // Simulate API call
            showToast('Administrateur créé avec succès!', 'success');
            closeCreateAdminModal();
            this.reset();
        });

        // Simulate real-time notifications (for demo purposes)
        function simulateNewNotification() {
            setTimeout(() => {
                const newNotification = {
                    id: Date.now(),
                    type: 'new_registration',
                    title: 'Nouvelle inscription',
                    message: 'Un nouveau participant vient de s\'inscrire',
                    time: 'À l\'instant',
                    unread: true,
                    link: '#'
                };
                
                currentNotifications.unshift(newNotification);
                
                // Update UI if notifications are open
                if (notificationsOpen) {
                    displayNotifications(currentNotifications);
                } else {
                    // Update badge
                    const unreadCount = currentNotifications.filter(n => n.unread).length;
                    updateNotificationBadge(unreadCount);
                }
                
                // Show subtle notification
                if (!notificationsOpen) {
                    showToast('Nouvelle notification', 'info');
                }
            }, 15000); // Simulate new notification after 15 seconds
        }

        // Start simulating notifications (for demo)
        simulateNewNotification();
    </script>

    @yield('scripts')
</body>
</html>