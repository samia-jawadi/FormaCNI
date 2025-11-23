<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>FormaCNI - Connexion</title>
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
            --primary: #667eea;
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary: #f093fb;
            --accent: #4facfe;
            --success: #10b981;
            --error: #ef4444;
            
            --text-primary: #1f2937;
            --text-secondary: #6b7280;
            --text-light: #f9fafb;
            --bg-light: #f8fafc;
            --bg-dark: #0f172a;
            --card-light: #ffffff;
            --card-dark: #1e293b;
            --border-light: #e5e7eb;
            --border-dark: #374151;
        }

        .theme-dark {
            --bg-primary: var(--bg-dark);
            --bg-secondary: var(--card-dark);
            --text-primary: var(--text-light);
            --text-secondary: #d1d5db;
            --border-color: var(--border-dark);
        }

        .theme-light {
            --bg-primary: var(--bg-light);
            --bg-secondary: var(--card-light);
            --text-primary: var(--text-primary);
            --text-secondary: var(--text-secondary);
            --border-color: var(--border-light);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            min-height: 100vh;
            transition: all 0.4s ease;
        }

        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            position: relative;
            overflow: hidden;
        }

        /* Animated Background */
        .animated-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            opacity: 0.6;
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            animation: float 20s infinite ease-in-out;
        }

        .orb-1 {
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            top: 10%;
            left: 5%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 400px;
            height: 400px;
            background: linear-gradient(45deg, #f093fb, #f5576c);
            bottom: 10%;
            right: 5%;
            animation-delay: 7s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            top: 50%;
            left: 70%;
            animation-delay: 14s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) scale(1) rotate(0deg);
            }
            33% {
                transform: translate(30px, -40px) scale(1.1) rotate(120deg);
            }
            66% {
                transform: translate(-20px, 30px) scale(0.9) rotate(240deg);
            }
        }

        /* Floating Particles */
        .particles-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
            pointer-events: none;
        }

        .particle {
            position: absolute;
            background: var(--primary);
            border-radius: 50%;
            opacity: 0.3;
            animation: particleFloat 15s linear infinite;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.3;
            }
            90% {
                opacity: 0.3;
            }
            100% {
                transform: translateY(-100px) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Main Content */
        .main-content {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 440px;
        }

        /* Login Card */
        .login-card {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            box-shadow: 
                0 20px 60px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.05),
                0 8px 32px rgba(0, 0, 0, 0.05);
            backdrop-filter: blur(20px);
            transition: all 0.3s ease;
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 
                0 30px 80px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.1),
                0 12px 40px rgba(0, 0, 0, 0.1);
        }

        /* Header */
        .login-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .logo-icon {
            width: 48px;
            height: 48px;
            background: var(--primary-gradient);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }

        .logo-text {
            font-size: 1.875rem;
            font-weight: 800;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-title {
            font-size: 1.875rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .welcome-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1.25rem;
            background: var(--bg-secondary);
            border: 2px solid var(--border-color);
            border-radius: 12px;
            color: var(--text-primary);
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
            transform: translateY(-1px);
        }

        .input-with-icon {
            position: relative;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--text-secondary);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .password-toggle:hover {
            color: var(--primary);
        }

        /* Options */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            cursor: pointer;
        }

        .custom-checkbox {
            width: 18px;
            height: 18px;
            border-radius: 4px;
            border: 2px solid var(--border-color);
            background: var(--bg-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .custom-checkbox.checked {
            background: var(--primary);
            border-color: var(--primary);
        }

        .custom-checkbox.checked::after {
            content: "✓";
            color: white;
            font-size: 12px;
            font-weight: bold;
        }

        .checkbox-label {
            color: var(--text-secondary);
            font-size: 0.9rem;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--primary);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .forgot-link:hover {
            color: #5a6fd8;
            text-decoration: underline;
        }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            padding: 1.125rem;
            background: var(--primary-gradient);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 35px rgba(102, 126, 234, 0.6);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        /* Register Link */
        .register-section {
            text-align: center;
            padding-top: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        .register-text {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .register-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 600;
            margin-left: 0.5rem;
            transition: color 0.3s ease;
        }

        .register-link:hover {
            color: #5a6fd8;
            text-decoration: underline;
        }

        /* Theme Toggle */
        .theme-toggle {
            position: fixed;
            top: 2rem;
            right: 2rem;
            z-index: 100;
        }

        .theme-btn {
            width: 48px;
            height: 48px;
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .theme-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        /* Messages */
        .alert-message {
            padding: 1rem 1.25rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            animation: slideIn 0.5s ease-out;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            color: #065f46;
            border: 1px solid rgba(16, 185, 129, 0.2);
        }

        .alert-error {
            background: rgba(239, 68, 68, 0.1);
            color: #7f1d1d;
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hidden utility */
        .hidden {
            display: none !important;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .login-card {
                padding: 2rem 1.5rem;
                margin: 1rem;
            }

            .theme-toggle {
                top: 1rem;
                right: 1rem;
            }

            .form-options {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body class="theme-light">
    <!-- Animated Background -->
    <div class="animated-background">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>

    <!-- Floating Particles -->
    <div class="particles-container" id="particles-container"></div>

    <!-- Theme Toggle -->
    <div class="theme-toggle">
        <button id="theme-toggle" class="theme-btn">
            <i class="fas fa-moon text-lg"></i>
            <i class="fas fa-sun text-lg hidden"></i>
        </button>
    </div>

    <!-- Main Content -->
    <div class="login-container">
        <div class="main-content">
            <div class="login-card">
                <!-- Header -->
                <div class="login-header">
                    <div class="logo">
                        <div class="logo-icon">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <span class="logo-text">FormaCNI</span>
                    </div>
                    <h1 class="welcome-title">Content de Vous Revoir</h1>
                    <p class="welcome-subtitle">Connectez-vous pour continuer votre parcours d'apprentissage</p>
                </div>

                <!-- Messages -->
                @if($errors->any())
                    <div class="alert-message alert-error">
                        <i class="fas fa-exclamation-circle"></i>
                        <span>{{ $errors->first() }}</span>
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert-message alert-success">
                        <i class="fas fa-check-circle"></i>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <!-- Login Form -->
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Field -->
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-input" 
                            required 
                            value="{{ old('email') }}" 
                            placeholder="votre@email.com"
                        >
                    </div>

                    <!-- Password Field -->
                    <div class="form-group">
                        <label class="form-label">Mot de Passe</label>
                        <div class="input-with-icon">
                            <input 
                                type="password" 
                                name="password" 
                                id="login-password" 
                                class="form-input pr-12" 
                                required 
                                placeholder="••••••••"
                            >
                            <button type="button" onclick="togglePassword()" class="password-toggle">
                                <i class="fas fa-eye" id="password-eye"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Options -->
                    <div class="form-options">
                        <label class="checkbox-group" id="remember-checkbox-group">
                            <input type="checkbox" name="remember" class="hidden" id="remember">
                            <span class="custom-checkbox" id="custom-checkbox"></span>
                            <span class="checkbox-label">Se souvenir de moi</span>
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-sign-in-alt"></i>
                        Se Connecter
                    </button>
                </form>

                <!-- Register Link -->
                <div class="register-section">
                    <span class="register-text">Vous n'avez pas de compte?</span>
                    <a href="{{ route('register') }}" class="register-link">Inscrivez-vous ici</a>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles-container');
            const particleCount = 20;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size
                const size = Math.random() * 8 + 4;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}vw`;
                
                // Random animation delay
                particle.style.animationDelay = `${Math.random() * 15}s`;
                
                // Random color from gradient colors
                const colors = ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe', '#00f2fe'];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.background = color;
                
                container.appendChild(particle);
            }
        }

        // Toggle password visibility
        function togglePassword() {
            const passwordInput = document.getElementById('login-password');
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

        // Theme functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Create particles
            createParticles();
            
            // Load saved theme
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

            // Custom checkbox functionality - FIXED
            const customCheckbox = document.getElementById('custom-checkbox');
            const hiddenCheckbox = document.getElementById('remember');
            const checkboxGroup = document.getElementById('remember-checkbox-group');
            
            // Initialize checkbox state
            updateCheckboxVisualState();
            
            // Add click event to the entire checkbox group
            if (checkboxGroup) {
                checkboxGroup.addEventListener('click', function(e) {
                    e.preventDefault();
                    hiddenCheckbox.checked = !hiddenCheckbox.checked;
                    updateCheckboxVisualState();
                });
            }
            
            // Function to update the visual state of the checkbox
            function updateCheckboxVisualState() {
                if (hiddenCheckbox.checked) {
                    customCheckbox.classList.add('checked');
                } else {
                    customCheckbox.classList.remove('checked');
                }
            }
        });
    </script>
</body>
</html>