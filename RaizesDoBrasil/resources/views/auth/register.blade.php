<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            padding: 20px 0;
        }
        .register-card {
            max-width: 500px;
            width: 100%;
            border-radius: 20px;
            backdrop-filter: blur(12px);
            background-color: rgba(255, 255, 255, 0.9);
        }
        [data-bs-theme="dark"] .register-card {
            background-color: rgba(33, 37, 41, 0.9);
        }
        .btn-success {
            background-color: #198754;
            border: none;
            padding: 12px;
            font-weight: bold;
            transition: all 0.3s;
        }
        .btn-success:hover {
            background-color: #157347;
            transform: scale(1.02);
        }
        .form-label {
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center">
        <div class="card register-card shadow-lg border-0">
            <div class="card-body p-4 p-md-5">
                
                <!-- Logo e Título -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success mb-1">Raízes do Brasil</h2>
                    <p class="text-secondary small">Crie sua conta para gerenciar seu restaurante.</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold text-uppercase">Nome Completo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-person text-muted"></i></span>
                            <input id="name" type="text" name="name" class="form-control bg-light border-start-0 @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" required autofocus placeholder="Ex: João Silva">
                        </div>
                        @error('name')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-uppercase">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input id="email" type="email" name="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required placeholder="seu@email.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <!-- Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-bold text-uppercase">Senha</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                                <input id="password" type="password" name="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" 
                                       required placeholder="••••••••">
                            </div>
                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="col-md-6 mb-3">
                            <label for="password_confirmation" class="form-label fw-bold text-uppercase">Confirmar</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-shield-check text-muted"></i></span>
                                <input id="password_confirmation" type="password" name="password_confirmation" class="form-control bg-light border-start-0" 
                                       required placeholder="••••••••">
                            </div>
                        </div>
                    </div>

                    <!-- Register Button -->
                    <div class="d-grid mt-4 mb-3">
                        <button type="submit" class="btn btn-success shadow-sm">
                            <i class="bi bi-person-plus-fill me-2"></i>Finalizar Cadastro
                        </button>
                    </div>

                    <!-- Link para Login -->
                    <div class="text-center pt-3 border-top">
                        <p class="text-secondary small mb-0">Já possui uma conta? 
                            <a href="{{ route('login') }}" class="text-success fw-bold text-decoration-none">
                                Faça Login aqui
                            </a>
                        </p>
                    </div>
                </form>

                <!-- Theme Toggle -->
                <div class="text-center mt-4">
                    <button class="btn btn-sm btn-link text-secondary text-decoration-none" id="themeToggle">
                        <i class="bi bi-moon-stars-fill me-1" id="themeIcon"></i> Alternar Visual
                    </button>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Lógica de Troca de Tema
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            if (currentTheme === 'light') {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                themeIcon.classList.replace('bi-moon-stars-fill', 'bi-sun-fill');
            } else {
                htmlElement.setAttribute('data-bs-theme', 'light');
                themeIcon.classList.replace('bi-sun-fill', 'bi-moon-stars-fill');
            }
        });
    </script>
</body>
</html>