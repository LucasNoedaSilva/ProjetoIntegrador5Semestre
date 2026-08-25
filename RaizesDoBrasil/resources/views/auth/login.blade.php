<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1547592166-23ac45744acd?q=80&w=2071&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
        }
        .login-card {
            max-width: 450px;
            width: 100%;
            border-radius: 20px;
            backdrop-filter: blur(10px);
            background-color: rgba(255, 255, 255, 0.9);
        }
        [data-bs-theme="dark"] .login-card {
            background-color: rgba(33, 37, 41, 0.9);
        }
        .btn-success {
            background-color: #198754;
            border: none;
            padding: 12px;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="container d-flex justify-content-center py-5">
        <div class="card login-card shadow-lg border-0">
            <div class="card-body p-5">
                
                <!-- Logo e Título -->
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-success mb-1">Raízes do Brasil</h2>
                    <p class="text-muted">Bem-vindo de volta! Entre na sua conta.</p>
                </div>

                <!-- Session Status (Alertas do Laravel) -->
                @if(session('status'))
                    <div class="alert alert-success border-0 shadow-sm small mb-4">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold small text-uppercase">E-mail</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-envelope text-muted"></i></span>
                            <input id="email" type="email" name="email" class="form-control bg-light border-start-0 @error('email') is-invalid @enderror" 
                                   value="{{ old('email') }}" required autofocus placeholder="seu@email.com">
                        </div>
                        @error('email')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between">
                            <label for="password" class="form-label fw-bold small text-uppercase">Senha</label>
                            @if (Route::has('password.request'))
                                <a class="small text-decoration-none text-success" href="{{ route('password.request') }}">
                                    Esqueceu a senha?
                                </a>
                            @endif
                        </div>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i class="bi bi-lock text-muted"></i></span>
                            <input id="password" type="password" name="password" class="form-control bg-light border-start-0 @error('password') is-invalid @enderror" 
                                   required placeholder="••••••••">
                        </div>
                        @error('password')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label small text-muted" for="remember_me">Lembrar de mim</label>
                    </div>

                    <!-- Login Button -->
                    <div class="d-grid mb-4">
                        <button type="submit" class="btn btn-success shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Entrar
                        </button>
                    </div>

                    <!-- Botão para Cadastro -->
                    <div class="text-center pt-3 border-top">
                        <p class="text-muted small mb-3">Não tem uma conta?</p>
                        <a href="{{ route('register') }}" class="btn btn-outline-secondary btn-sm px-4">
                            Criar Nova Conta
                        </a>
                    </div>
                </form>

                <!-- Theme Toggle (Opcional na tela de login) -->
                <div class="text-center mt-4">
                    <button class="btn btn-sm btn-link text-muted text-decoration-none" id="themeToggle">
                        <i class="bi bi-moon-stars-fill me-1" id="themeIcon"></i> Alternar Tema
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