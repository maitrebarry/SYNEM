<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - SYNEM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root {
            --synem-primary: #1a365d;
            --synem-secondary: #e53e3e;
            --synem-accent: #f6ad55;
        }
        
        body {
            background: linear-gradient(135deg, var(--synem-primary) 0%, #2d3748 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .login-container {
            animation: fadeIn 0.8s ease-in-out;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.3);
            border: none;
            overflow: hidden;
        }
        
        .login-header {
            background: var(--synem-primary);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        
        .synem-logo {
            font-weight: bold;
            font-size: 2rem;
            margin-bottom: 0.5rem;
        }
        
        .login-body {
            padding: 2.5rem;
        }
        
        .form-control {
            border-radius: 8px;
            border: 2px solid #e2e8f0;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: var(--synem-primary);
            box-shadow: 0 0 0 0.2rem rgba(26, 54, 93, 0.25);
        }
        
        .btn-synem {
            background: linear-gradient(135deg, var(--synem-primary), #2d3748);
            border: none;
            border-radius: 8px;
            padding: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-synem:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(26, 54, 93, 0.4);
        }
        
        .login-features {
            background: #f8fafc;
            border-radius: 10px;
            padding: 1.5rem;
            margin-top: 2rem;
        }
        
        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 1rem;
        }
        
        .feature-icon {
            background: var(--synem-primary);
            color: white;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 1rem;
            font-size: 0.9rem;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
        }
        
        .input-group {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="login-card">
                    <!-- En-tête -->
                    <div class="login-header">
                        <div class="synem-logo">
                            <i class="bi bi-people-fill me-2"></i>SYNEM
                        </div>
                        <p class="mb-0 opacity-75">Syndicat National des Enseignants du Mali</p>
                    </div>
                    
                    <!-- Corps du formulaire -->
                    <div class="login-body">
                        <h4 class="text-center mb-4 text-dark">Connexion à l'administration</h4>
                        
                        <!-- Messages d'erreur -->
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Erreur de connexion</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        @if(session('status'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                {{ session('status') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                            <!-- Email -->
                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope me-2"></i>Adresse email
                                </label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="{{ old('email') }}" required autofocus
                                       placeholder="votre@email.com">
                            </div>
                            
                            <!-- Mot de passe -->
                            <div class="mb-4">
                                <label for="password" class="form-label fw-semibold">
                                    <i class="bi bi-lock me-2"></i>Mot de passe
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="password" 
                                           name="password" required placeholder="Votre mot de passe">
                                    <button type="button" class="password-toggle" onclick="togglePassword()">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Se souvenir de moi -->
                            <div class="mb-4 form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">
                                    Se souvenir de moi
                                </label>
                            </div>
                            
                            <!-- Bouton de connexion -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-synem btn-lg text-white">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                                </button>
                            </div>

                            <div class="alert alert-light border small text-muted" role="alert">
                                <i class="bi bi-shield-lock me-2"></i>
                                L'accès est temporairement bloqué après 5 tentatives échouées pendant 15 minutes.
                            </div>
                            
                            <!-- Lien mot de passe oublié -->
                            @if (Route::has('password.request'))
                                <div class="text-center">
                                    <a href="{{ route('password.request') }}" class="text-decoration-none">
                                        <i class="bi bi-key me-1"></i>Mot de passe oublié ?
                                    </a>
                                </div>
                            @endif
                        </form>
                        
                        <!-- Features -->
                        <div class="login-features">
                            <h6 class="mb-3 text-center">
                                <i class="bi bi-shield-check me-2"></i>Espace sécurisé
                            </h6>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-safe"></i>
                                </div>
                                <div>
                                    <small class="fw-semibold">Accès sécurisé</small>
                                    <br>
                                    <small class="text-muted">Authentification cryptée</small>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-file-earmark-text"></i>
                                </div>
                                <div>
                                    <small class="fw-semibold">Gestion des documents</small>
                                    <br>
                                    <small class="text-muted">Documents administratifs</small>
                                </div>
                            </div>
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="bi bi-megaphone"></i>
                                </div>
                                <div>
                                    <small class="fw-semibold">Publications</small>
                                    <br>
                                    <small class="text-muted">Actualités et annonces</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Lien vers le site public -->
                <div class="text-center mt-4">
                    <a href="{{ route('accueil') }}" class="text-white text-decoration-none">
                        <i class="bi bi-arrow-left me-1"></i>Retour au site public
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Fonction pour afficher/masquer le mot de passe
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.querySelector('.password-toggle i');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }
        
        // Animation au chargement
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.form-control');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });
                input.addEventListener('blur', function() {
                    if (!this.value) {
                        this.parentElement.classList.remove('focused');
                    }
                });
            });
        });
    </script>
</body>
</html>