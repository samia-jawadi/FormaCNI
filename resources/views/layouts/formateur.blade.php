<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FormaCNI - @yield('title')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-color: #1e3a8a;
            --secondary-color: #3b82f6;
            --accent-color: #f59e0b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-bg: #f8fafc;
            --dark-bg: #1e293b;
        }
        
.theme-light {
            --bg-primary: #ffffff;
            --bg-secondary: #e2e8f0; /* soft light gray */
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --border-color: #e2e8f0;
        }
        
.theme-dark {
            --bg-primary: #0f172a; /* slate-900 */
            --bg-secondary: #111827; /* gray-900 for cards */
            --text-primary: #e5e7eb; /* slate-200 */
            --text-secondary: #94a3b8; /* slate-400 */
            --border-color: rgba(148, 163, 184, 0.18);
        }
        
        body {
            background-color: var(--bg-secondary);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }
        
        .nav-item {
            @apply flex items-center px-4 py-3 text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-200 border-l-4 border-transparent hover:border-blue-500;
        }
        
        .nav-item.active {
            @apply bg-blue-50 text-blue-700 border-blue-500;
        }
        
        .theme-dark .nav-item {
            @apply text-gray-300 hover:bg-gray-700 hover:text-white;
        }
        
        .theme-dark .nav-item.active {
            @apply bg-gray-700 text-white border-blue-400;
        }
        
        .card {
            background-color: var(--bg-secondary);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }
        
        .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors duration-200;
        }
        
        .btn-secondary {
            @apply bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg transition-colors duration-200;
        }
        
        .theme-dark .btn-secondary {
            @apply bg-gray-600 hover:bg-gray-500 text-gray-200;
        }

        /* Admin-like sidebar styles */
        .sidebar {
            background: var(--bg-sidebar, #1e293b);
            color: #fff;
        }
        .sidebar-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem 1rem;
            border-radius: 0.5rem;
            color: #e5e7eb;
            transition: all 0.2s ease;
        }
        .sidebar-item:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .sidebar-item.active { background: var(--primary, #667eea); color: #fff; }
    </style>
</head>
<body class="theme-light" x-data="{ sidebarOpen: false, notificationOpen: false }">
    <div class="min-h-screen flex">
        <!-- Sidebar -->
        <div class="sidebar w-64 fixed h-full z-40 transform transition-transform duration-300 ease-in-out lg:transform-none"
             :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'">
            
            <!-- Logo and Brand -->
            <div class="flex items-center justify-center h-16 border-b border-gray-200">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <span class="text-white font-bold text-lg">CNI</span>
                    </div>
                    <span class="text-xl font-bold text-gray-800">FormaCNI</span>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="mt-6">
                <div class="px-2">
                    <a href="{{ route('formateur.dashboard') }}" 
                       class="sidebar-item {{ request()->routeIs('formateur.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-home w-5 mr-3"></i>
                        <span>Home</span>
                    </a>
                    
                    <a href="{{ route('formateur.formations.index') }}" 
                       class="sidebar-item {{ request()->routeIs('formateur.formations.*') ? 'active' : '' }}">
                        <i class="fas fa-graduation-cap w-5 mr-3"></i>
                        <span>Mes Formations</span>
                    </a>
                    
                </div>
                
                <!-- Bottom Navigation -->
                <div class="absolute bottom-4 w-full px-2 space-y-2">
                    <a href="{{ route('formateur.profile') }}" 
                       class="sidebar-item {{ (request()->routeIs('formateur.profile') || request()->routeIs('profile.*')) ? 'active' : '' }}">
                        <i class="fas fa-user-cog w-5 mr-3"></i>
                        <span>Account</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <button type="submit" class="sidebar-item w-full text-left text-red-300 hover:bg-white/10">
                            <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                            <span>Exit</span>
                        </button>
                    </form>
                </div>
            </nav>
        </div>
        
        <!-- Main Content -->
        <div class="flex-1 lg:ml-64">
            <!-- Top Bar -->
            <header class="card h-16 flex items-center justify-between px-6 border-b">
                <div class="flex items-center">
                    <!-- Mobile menu button -->
                    <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-md text-gray-600">
                        <i class="fas fa-bars"></i>
                    </button>
                    
                    <!-- Page Title -->
                    <h1 class="text-2xl font-semibold text-gray-800 ml-4 lg:ml-0">
                        @yield('page-title', 'Dashboard')
                    </h1>
                </div>
                
                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors duration-200">
                        <i class="fas fa-sun text-yellow-500"></i>
                    </button>
                    
                    <!-- Notifications -->
                    <div class="relative">
                        <button @click="notificationOpen = !notificationOpen" 
                                class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors duration-200 relative">
                            <i class="fas fa-bell text-gray-600"></i>
                            @php
                                $unreadCount = 0;
                                if(auth()->user()->formationsCrees) {
                                    $unreadCount += auth()->user()->formationsCrees()->whereIn('statut', ['ACTIVE', 'REFUSEE'])->count();
                                }
                            @endphp
                            @if($unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-xs text-white flex items-center justify-center">
                                    {{ $unreadCount }}
                                </span>
                            @endif
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div x-show="notificationOpen" 
                             @click.away="notificationOpen = false"
                             x-transition
                             class="absolute right-0 mt-2 w-80 card rounded-lg shadow-lg z-50">
                            <div class="p-4 border-b">
                                <h3 class="font-semibold text-gray-800">Notifications</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                @php
                                    $recentFormations = auth()->user()->formationsCrees()->whereIn('statut', ['ACCEPTEE', 'REFUSEE'])->latest()->take(5)->get();
                                @endphp
                                @forelse($recentFormations as $formation)
                                    <div class="p-4 border-b hover:bg-gray-50">
                                        <div class="text-sm">
                                            <p class="font-medium">
                                                Formation {{ $formation->statut === 'ACCEPTEE' ? 'Approved' : 'Rejected' }}
                                            </p>
                                            <p class="text-gray-600">{{ $formation->titre }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ $formation->updated_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-gray-500">
                                        <i class="fas fa-bell-slash text-2xl mb-2"></i>
                                        <p>No notifications yet</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    
                    <!-- User Profile -->
                    <div class="flex items-center space-x-3">
                        <div class="text-right">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->nom }} {{ Auth::user()->prenom }}</p>
                            <p class="text-xs text-gray-600">Formateur</p>
                        </div>
                        @php($photo = Auth::user()->photo)
                        @if($photo)
                            <img src="{{ Storage::url($photo) }}" alt="Photo" class="w-8 h-8 rounded-full object-cover border">
                        @else
                            <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center">
                                <span class="text-white text-sm font-medium">{{ substr(Auth::user()->nom, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </header>
            
            <!-- Page Content -->
            <main class="p-6">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-green-800">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <span class="text-red-800">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif
                
                @if($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-3 mt-0.5"></i>
                            <div>
                                <h4 class="font-medium text-red-800 mb-2">Please fix the following errors:</h4>
                                <ul class="text-sm text-red-700 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>• {{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                @yield('content')
            </main>
        </div>
    </div>
    
    <!-- Mobile Overlay -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black opacity-50 z-30 lg:hidden"></div>
    
    <script>
        // Theme Toggle
        const ftThemeBtn = document.getElementById('theme-toggle');
        if (ftThemeBtn) {
            ftThemeBtn.addEventListener('click', function() {
                const body = document.body;
                const icon = this.querySelector('i');
                if (body.classList.contains('theme-light')) {
                    body.classList.remove('theme-light');
                    body.classList.add('theme-dark');
                    if (icon) icon.className = 'fas fa-moon text-blue-400';
                    localStorage.setItem('theme', 'dark');
                } else {
                    body.classList.remove('theme-dark');
                    body.classList.add('theme-light');
                    if (icon) icon.className = 'fas fa-sun text-yellow-500';
                    localStorage.setItem('theme', 'light');
                }
            });
        }
        
        // Load theme from localStorage
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            document.body.classList.remove('theme-light');
            document.body.classList.add('theme-dark');
            document.querySelector('#theme-toggle i').className = 'fas fa-moon text-blue-400';
        }
    </script>
    
    @stack('scripts')
</body>
</html>