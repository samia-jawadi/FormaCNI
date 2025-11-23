<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FormaCNI - @yield('title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script>
        // Set up CSRF token for AJAX requests
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    <style>
        :root {
            --primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --admin: linear-gradient(135deg, #a8edea 0%, #fed6e3 100%);
            --success: linear-gradient(135deg, #d299c2 0%, #fef9d7 100%);
            
            --elegant-primary: #4a90e2;
            --elegant-secondary: #50e3c2;
            --elegant-text-dark: #2c3e50;
            --elegant-text-light: #ecf0f1;
            --elegant-border: #bdc3c7;
            --elegant-bg-light: #f8f9fa;
            --elegant-card-light: #ffffff;
            --elegant-bg-dark: #212529;
            --elegant-card-dark: #343a40;
        }

        .theme-dark {
            --bg-primary: var(--elegant-bg-dark);
            --bg-secondary: var(--elegant-card-dark);
            --text-primary: var(--elegant-text-light);
            --text-secondary: #adb5bd;
            --border-color: #495057;
        }

        .theme-light {
            --bg-primary: #e2e8f0; /* soft light gray */
            --bg-secondary: #ffffff;
            --text-primary: var(--elegant-text-dark);
            --text-secondary: #6c757d;
            --border-color: var(--elegant-border);
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: "Inter", -apple-system, BlinkMacSystemFont, sans-serif;
        }

        .glass-morphism {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .gradient-bg {
            background: var(--primary);
        }

        .card-enhanced {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1),
              0 0 0 1px rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .input-enhanced {
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }

        .input-enhanced:focus {
            border-color: var(--elegant-primary);
            box-shadow: 0 0 0 3px rgba(74, 144, 226, 0.2);
            outline: none;
        }

        .btn-gradient {
            background: var(--primary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-gradient:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .message {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: fadeIn 0.5s ease-out;
        }

        .message.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-link {
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            transform: translateY(-2px);
        }
    </style>
</head>
<body class="theme-light">
    <!-- Navigation -->
    @auth
    <nav class="bg-white dark:bg-gray-800 shadow-lg border-b border-gray-200 dark:border-gray-700">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ url('/') }}" class="flex-shrink-0 flex items-center">
                        <i class="fas fa-graduation-cap text-2xl text-blue-500 mr-2"></i>
                        <span class="text-xl font-bold text-gray-900 dark:text-white">FormaCNI</span>
                    </a>
                    
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-4">
                        <a href="{{ route('formations.index') }}" 
                           class="nav-link text-gray-900 dark:text-white hover:text-blue-500 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-book mr-1"></i>
                            Formations
                        </a>
                        
                        @if(Auth::user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" 
                           class="nav-link text-gray-900 dark:text-white hover:text-blue-500 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-tachometer-alt mr-1"></i>
                            Dashboard Admin
                        </a>
                        @elseif(Auth::user()->isFormateur())
                        <a href="{{ route('formateur.dashboard') }}" 
                           class="nav-link text-gray-900 dark:text-white hover:text-blue-500 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-tachometer-alt mr-1"></i>
                            Dashboard Formateur
                        </a>
                        @elseif(Auth::user()->isParticipant())
                        <a href="{{ route('participant.dashboard') }}" 
                           class="nav-link text-gray-900 dark:text-white hover:text-blue-500 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium">
                            <i class="fas fa-tachometer-alt mr-1"></i>
                            Dashboard Participant
                        </a>
                        @endif
                    </div>
                </div>

                <div class="flex items-center space-x-4">
                    <!-- Theme Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                        <i class="fas fa-moon text-gray-600 dark:text-gray-300"></i>
                        <i class="fas fa-sun text-gray-600 dark:text-gray-300 hidden"></i>
                    </button>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button id="user-menu-button" class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            <div class="h-8 w-8 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr(Auth::user()->nom, 0, 1)) }}
                            </div>
                            <span class="ml-2 text-gray-700 dark:text-gray-300 font-medium">{{ Auth::user()->nom }}</span>
                            <i class="fas fa-chevron-down ml-1 text-gray-500"></i>
                        </button>

                        <!-- Dropdown menu -->
                        <div id="user-menu" class="hidden absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5">
                            <div class="py-1">
                                <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-user mr-2"></i>Mon Profil
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <i class="fas fa-sign-out-alt mr-2"></i>Déconnexion
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    @endauth

    <!-- Messages Flash -->
    <div class="container mx-auto px-4 mt-4">
        @if(session('success'))
            <div class="alert-success">
                <i class="fas fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle mr-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-triangle mr-2"></i>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Contenu principal -->
    <main>
        @yield('content')
    </main>

    <script>
        // Theme functionality
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            if (savedTheme === 'dark') {
                document.body.classList.remove('theme-light');
                document.body.classList.add('theme-dark');
                document.querySelector('#theme-toggle .fa-moon').classList.add('hidden');
                document.querySelector('#theme-toggle .fa-sun').classList.remove('hidden');
            }

            // Theme toggle
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

            // User menu dropdown
            const userMenuButton = document.getElementById('user-menu-button');
            const userMenu = document.getElementById('user-menu');
            
            if (userMenuButton && userMenu) {
                userMenuButton.addEventListener('click', function() {
                    userMenu.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!userMenuButton.contains(event.target) && !userMenu.contains(event.target)) {
                        userMenu.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html>