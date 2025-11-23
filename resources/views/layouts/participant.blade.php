<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard Participant - FormaCNI')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --primary: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --accent: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --participant: #667eea;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --elegant-primary: #4a90e2;
            --elegant-secondary: #50e3c2;
            --text-primary: #111827; /* gray-900 for strong contrast */
            --text-secondary: #6b7280; /* gray-600 for muted text */
            --bg-primary: #f8fafc; /* slate-50 for clean light surface */
            --bg-secondary: #ffffff; /* card surface */
            --bg-sidebar: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --border-color: #e5e7eb; /* gray-200 for subtle borders */
        }

.theme-dark {
            --text-primary: #e5e7eb; /* slate-200 */
            --bg-primary: #0f172a; /* slate-900 */
            --bg-secondary: #111827; /* gray-900 */
            --bg-sidebar: linear-gradient(135deg, #1f2937 0%, #0f172a 100%);
            --border-color: rgba(148, 163, 184, 0.18);
        }

        body {
            background-color: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.3s ease;
            font-family: 'Inter', sans-serif;
        }

        .sidebar {
            background: var(--bg-sidebar);
            color: white;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            box-shadow: 4px 0 15px rgba(102, 126, 234, 0.1);
        }

        .sidebar-content {
            flex: 1;
            overflow-y: auto;
        }

        .sidebar-item {
            transition: all 0.3s ease;
            border-radius: 0.5rem;
        }

        .sidebar-item:hover {
            background: rgba(255, 255, 255, 0.1);
            transform: translateX(4px);
        }

        .sidebar-item.active {
            background: var(--primary);
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .user-profile-section {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1rem;
            background: var(--bg-sidebar);
        }

        .user-profile-static {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .user-actions {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            color: var(--text-primary);
        }

        .card:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--participant), #059669);
            color: white;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.6);
        }

        .table-container {
            background: var(--bg-primary);
            border-radius: 0.75rem;
            overflow: hidden;
        }

        .table-header {
            background: var(--bg-secondary);
        }

        .table-row:hover {
            background: var(--bg-secondary);
        }

        .badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .badge-success {
            background: #dcfce7;
            color: #166534;
        }

        .badge-warning {
            background: #fef3c7;
            color: #92400e;
        }

        .badge-danger {
            background: #fee2e2;
            color: #991b1b;
        }

        .badge-info { background: #dbeafe; color: #1e40af; }

        /* Improve dark mode readability */
        .theme-dark h1,.theme-dark h2,.theme-dark h3,.theme-dark h4 { color: #f9fafb; }
        .theme-dark p,.theme-dark span,.theme-dark li,.theme-dark label { color: #d1d5db; }
        .theme-dark .card { background: var(--bg-secondary); color: var(--text-primary); }
        .theme-light a { color: #2563eb; }
        .theme-dark a { color: #93c5fd; }
        
        .modal-overlay {
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .modal-content {
            background: var(--bg-primary);
            border-radius: 1rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }

        .input-field {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            color: var(--text-primary);
        }

        .input-field:focus {
            outline: none;
            border-color: var(--participant);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }
    </style>
</head>
<body class="theme-light">
    <!-- Main Layout -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar w-64 flex-shrink-0">
            <div class="sidebar-content">
                <div class="p-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gradient-to-r from-emerald-500 to-teal-500 rounded-full flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                        <div>
                            <h2 class="text-xl font-bold">FormaCNI</h2>
                            <p class="text-sm text-emerald-200">Participant</p>
                        </div>
                    </div>
                </div>

                <nav class="mt-8 px-4 space-y-2">
                    <a href="{{ route('formations.index') }}" class="sidebar-item {{ Request::is('formations') ? 'active' : '' }} flex items-center space-x-3 p-3">
                        <i class="fas fa-home w-5"></i>
                        <span>Formations Disponibles</span>
                    </a>
                    <a href="{{ route('participant.formations') }}" class="sidebar-item {{ Request::is('participant/mes-formations') ? 'active' : '' }} flex items-center space-x-3 p-3">
                        <i class="fas fa-book w-5"></i>
                        <span>Mes Formations</span>
                    </a>
                </nav>
            </div>

            <!-- Bottom Account/Exit (participant-style like formateur) -->
            <div class="p-4 mt-auto">
                <div class="space-y-2">
                    <a href="{{ route('profile.show') }}" class="sidebar-item flex items-center space-x-3 p-3">
                        <i class="fas fa-user-cog w-5"></i>
                        <span>Account</span>
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="sidebar-item w-full text-left flex items-center space-x-3 p-3 text-red-200 hover:text-white">
                            <i class="fas fa-sign-out-alt w-5"></i>
                            <span>Exit</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between px-6 py-4">
                    <div class="flex items-center space-x-4">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">@yield('page-title', 'Tableau de Bord')</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button id="theme-toggle" class="relative p-3 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 transition-all duration-300 transform hover:scale-110 shadow-lg text-xl">
                            ☀️
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <div class="flex-1 overflow-auto p-6">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Theme Toggle
        document.getElementById('theme-toggle').addEventListener('click', function() {
            document.body.classList.toggle('theme-dark');
            document.body.classList.toggle('theme-light');
            
            if (document.body.classList.contains('theme-dark')) {
                this.innerHTML = '🌙';
                this.className = 'relative p-3 rounded-full bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 transition-all duration-300 transform hover:scale-110 shadow-lg text-xl';
            } else {
                this.innerHTML = '☀️';
                this.className = 'relative p-3 rounded-full bg-gradient-to-r from-yellow-400 to-orange-500 hover:from-yellow-500 hover:to-orange-600 transition-all duration-300 transform hover:scale-110 shadow-lg text-xl';
            }
            
            localStorage.setItem('theme', document.body.classList.contains('theme-dark') ? 'dark' : 'light');
        });

        // Load saved theme
        document.addEventListener('DOMContentLoaded', function() {
            const savedTheme = localStorage.getItem('theme');
            const themeToggle = document.getElementById('theme-toggle');
            if (savedTheme === 'dark') {
                document.body.classList.add('theme-dark');
                document.body.classList.remove('theme-light');
                themeToggle.innerHTML = '🌙';
                themeToggle.className = 'relative p-3 rounded-full bg-gradient-to-r from-indigo-600 to-purple-700 hover:from-indigo-700 hover:to-purple-800 transition-all duration-300 transform hover:scale-110 shadow-lg text-xl';
            }
        });
    </script>

    @yield('scripts')
</body>
</html>