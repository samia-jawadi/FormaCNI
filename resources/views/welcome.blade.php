<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>FormaCNI - Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
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
            --bg-primary: var(--elegant-bg-light);
            --bg-secondary: var(--elegant-card-light);
            --text-primary: var(--elegant-text-dark);
            --text-secondary: #6c757d;
            --border-color: var(--elegant-border);
        }

        body {
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            font-family: "Inter", -apple-system, BlinkMacSystemFont, sans-serif;
            overflow-x: hidden;
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

        .gradient-secondary {
            background: var(--secondary);
        }

        .gradient-accent {
            background: var(--accent);
        }

        .animated-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            opacity: 0.6;
        }

        .floating-orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(40px);
            animation: float 20s infinite ease-in-out;
        }

        .orb-1 {
            width: 200px;
            height: 200px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            top: 20%;
            left: 10%;
            animation-delay: 0s;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: linear-gradient(45deg, #f093fb, #f5576c);
            bottom: 20%;
            right: 10%;
            animation-delay: 7s;
        }

        .orb-3 {
            width: 150px;
            height: 150px;
            background: linear-gradient(45deg, #4facfe, #00f2fe);
            top: 60%;
            left: 50%;
            animation-delay: 14s;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }
            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        .card-enhanced {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            backdrop-filter: blur(20px);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
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

        .btn-gradient:active {
            transform: translateY(0);
        }

        .entrance-animation {
            animation: entranceSlide 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes entranceSlide {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .toggle-btn {
            background: var(--bg-secondary);
            border: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .toggle-btn:hover {
            background: var(--primary);
            color: white;
            transform: scale(1.1);
        }

        .form-container {
            max-width: 450px;
            margin: 0 auto;
        }

        .welcome-title {
            background: var(--primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 3rem;
            line-height: 1.1;
            position: relative;
            display: inline-block;
        }

        .welcome-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 4px;
            background: var(--primary);
            border-radius: 2px;
            transform: scaleX(0);
            transform-origin: center;
            animation: titleUnderline 2s ease-in-out infinite;
        }

        @keyframes titleUnderline {
            0%, 100% {
                transform: scaleX(0);
            }
            50% {
                transform: scaleX(1);
            }
        }

        .subtitle {
            color: var(--text-secondary);
            font-size: 1.125rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .subtitle::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 1px;
            background: var(--border-color);
            transform: scaleX(0);
            transform-origin: left;
            animation: subtitleLine 3s ease-in-out infinite;
        }

        @keyframes subtitleLine {
            0% {
                transform: scaleX(0);
                transform-origin: left;
            }
            50% {
                transform: scaleX(1);
                transform-origin: left;
            }
            51% {
                transform-origin: right;
            }
            100% {
                transform: scaleX(0);
                transform-origin: right;
            }
        }

        .floating-element {
            animation: floating 6s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% {
                transform: translateY(0) rotate(0deg);
            }
            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        .particle {
            position: absolute;
            background: var(--elegant-primary);
            border-radius: 50%;
            opacity: 0.7;
            animation: particleFloat 15s linear infinite;
        }

        @keyframes particleFloat {
            0% {
                transform: translateY(100vh) translateX(0) rotate(0deg);
                opacity: 0;
            }
            10% {
                opacity: 0.7;
            }
            90% {
                opacity: 0.7;
            }
            100% {
                transform: translateY(-100px) translateX(100px) rotate(360deg);
                opacity: 0;
            }
        }

        .holographic-effect {
            background: linear-gradient(45deg, 
                rgba(102, 126, 234, 0.1), 
                rgba(240, 147, 251, 0.1), 
                rgba(79, 172, 254, 0.1));
            background-size: 400% 400%;
            animation: holographic 8s ease infinite;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        @keyframes holographic {
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

        .neon-glow {
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.7),
                        0 0 10px rgba(102, 126, 234, 0.5),
                        0 0 15px rgba(102, 126, 234, 0.3);
        }

        .pulse-animation {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }
            70% {
                transform: scale(1.05);
                box-shadow: 0 0 0 10px rgba(102, 126, 234, 0);
            }
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }

        .typing-effect {
            overflow: hidden;
            border-right: 2px solid var(--elegant-primary);
            white-space: nowrap;
            margin: 0 auto;
            animation: typing 3.5s steps(40, end), blink-caret 0.75s step-end infinite;
        }

        @keyframes typing {
            from { width: 0 }
            to { width: 100% }
        }

        @keyframes blink-caret {
            from, to { border-color: transparent }
            50% { border-color: var(--elegant-primary) }
        }

        .matrix-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -2;
            opacity: 0.1;
            pointer-events: none;
        }

        .matrix-char {
            position: absolute;
            color: var(--elegant-primary);
            font-family: monospace;
            font-size: 14px;
            opacity: 0;
            animation: matrixFall 10s linear infinite;
        }

        @keyframes matrixFall {
            0% {
                transform: translateY(-100px);
                opacity: 0;
            }
            5% {
                opacity: 1;
            }
            95% {
                opacity: 1;
            }
            100% {
                transform: translateY(100vh);
                opacity: 0;
            }
        }
    </style>
</head>
<body class="theme-light min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    <!-- Matrix Background -->
    <div class="matrix-bg" id="matrix-bg"></div>
    
    <!-- Animated Background -->
    <div class="animated-background">
        <div class="floating-orb orb-1"></div>
        <div class="floating-orb orb-2"></div>
        <div class="floating-orb orb-3"></div>
    </div>

    <!-- Floating Particles -->
    <div id="particles-container"></div>

    <!-- Header Controls -->
    <div class="absolute top-6 right-6 flex gap-3 z-50">
        <button id="theme-toggle" class="toggle-btn p-3 rounded-full">
            <i class="fas fa-moon text-lg"></i>
            <i class="fas fa-sun text-lg hidden"></i>
        </button>
    </div>

    <!-- Main Content Container -->
    <div class="form-container w-full z-10">
        <!-- Welcome Screen -->
        <div id="welcome-screen" class="text-center entrance-animation">
            <div class="mb-8 floating-element">
                <h1 class="welcome-title mb-4">FormaCNI</h1>
                <p class="subtitle typing-effect">
                    Transformez votre parcours d'apprentissage avec notre plateforme éducative de pointe
                </p>
            </div>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                @guest
                    {{-- Show register and login buttons when user is NOT logged in --}}
                    <a href="{{ route('register') }}" 
                       class="btn-gradient px-8 py-4 text-white rounded-xl font-semibold text-lg flex items-center justify-center pulse-animation neon-glow">
                        <i class="fas fa-user-plus mr-2"></i>
                        Rejoindre
                    </a>
                    <a href="{{ route('login') }}" 
                       class="px-8 py-4 rounded-xl font-semibold text-lg border-2 border-current opacity-80 hover:opacity-100 transition-all duration-300 flex items-center justify-center holographic-effect">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se Connecter
                    </a>
                @else
                    {{-- Show dashboard and logout buttons when user IS logged in --}}
                    <a href="{{ route('dashboard') }}" 
                       class="btn-gradient px-8 py-4 text-white rounded-xl font-semibold text-lg flex items-center justify-center pulse-animation neon-glow">
                        <i class="fas fa-tachometer-alt mr-2"></i>
                        Aller au Tableau de Bord
                    </a>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" 
                               class="px-8 py-4 rounded-xl font-semibold text-lg border-2 border-current opacity-80 hover:opacity-100 transition-all duration-300 flex items-center justify-center holographic-effect">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Se Déconnecter
                        </button>
                    </form>
                @endguest
            </div>

            <!-- Futuristic Elements -->
            <div class="mt-12 grid grid-cols-3 gap-4">
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-2 rounded-full flex items-center justify-center holographic-effect">
                        <i class="fas fa-graduation-cap text-xl"></i>
                    </div>
                    <p class="text-sm">Apprentissage Personnalisé</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-2 rounded-full flex items-center justify-center holographic-effect">
                        <i class="fas fa-chart-line text-xl"></i>
                    </div>
                    <p class="text-sm">Progression Intelligente</p>
                </div>
                <div class="text-center">
                    <div class="w-16 h-16 mx-auto mb-2 rounded-full flex items-center justify-center holographic-effect">
                        <i class="fas fa-users text-xl"></i>
                    </div>
                    <p class="text-sm">Communauté Active</p>
                </div>
            </div>
        </div>
    </div>

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

            // Create floating particles
            createParticles();
            
            // Create matrix background
            createMatrixBackground();
        });

        // Create floating particles
        function createParticles() {
            const container = document.getElementById('particles-container');
            const particleCount = 30;
            
            for (let i = 0; i < particleCount; i++) {
                const particle = document.createElement('div');
                particle.classList.add('particle');
                
                // Random size
                const size = Math.random() * 10 + 5;
                particle.style.width = `${size}px`;
                particle.style.height = `${size}px`;
                
                // Random position
                particle.style.left = `${Math.random() * 100}vw`;
                
                // Random animation delay
                particle.style.animationDelay = `${Math.random() * 15}s`;
                
                // Random color
                const colors = ['#667eea', '#764ba2', '#f093fb', '#f5576c', '#4facfe', '#00f2fe'];
                const color = colors[Math.floor(Math.random() * colors.length)];
                particle.style.background = color;
                
                container.appendChild(particle);
            }
        }

        // Create matrix background
        function createMatrixBackground() {
            const container = document.getElementById('matrix-bg');
            const chars = '01アイウエオカキクケコサシスセソタチツテトナニヌネノハヒフヘホマミムメモヤユヨラリルレロワヲン';
            const charCount = 50;
            
            for (let i = 0; i < charCount; i++) {
                const char = document.createElement('div');
                char.classList.add('matrix-char');
                char.textContent = chars.charAt(Math.floor(Math.random() * chars.length));
                
                // Random position
                char.style.left = `${Math.random() * 100}vw`;
                
                // Random animation delay
                char.style.animationDelay = `${Math.random() * 10}s`;
                
                // Random animation duration
                char.style.animationDuration = `${Math.random() * 5 + 5}s`;
                
                container.appendChild(char);
            }
        }
    </script>
</body>
</html>