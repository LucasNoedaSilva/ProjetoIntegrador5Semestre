<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Categoria</title>
    <!-- CSS do Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons para o botão de tema -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Ajuste para garantir a centralização absoluta da marca na navbar */
        .navbar-brand-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        @media (max-width: 991.98px) {
            .navbar-brand-center {
                position: static;
                transform: none;
            }
        }
    </style>
</head>

<body class="bg-body-tertiary">

  <!-- Navbar com tema escuro (premium) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 position-relative mb-5">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="/aboutus">Sobre Nós</a></li>
                    <li class="nav-item"><a class="nav-link" href="/order/report">Relatórios</a></li>
                </ul>
            </div>
            
            <a class="navbar-brand navbar-brand-center fw-bold fs-4 m-0" href="/">Raízes do Brasil</a>
            
            <div class="d-flex ms-auto align-items-center gap-2">
                <button class="btn btn-link text-light p-2" id="themeToggle" type="button">
                    <i class="bi bi-moon-fill" id="themeIcon"></i>
                </button>

                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle text-success fs-5"></i>
                        <span class="fw-medium text-white">{{ Auth::user()->name }}</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2">
                        <li><h6 class="dropdown-header small text-uppercase">Minha Conta</h6></li>
                        <li>
                            <a class="dropdown-item py-2" href="{{ route('profile.edit') }}">
                                <i class="bi bi-person me-2 text-muted"></i>Meu Perfil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2">
                                    <i class="bi bi-box-arrow-right me-2"></i>Sair do Sistema
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Container centralizado vertical e horizontalmente -->
    <div class="container d-flex justify-content-center align-items-center min-vh-100 py-5">
        
        <!-- Card com sombra para destacar o formulário -->
        <div class="card shadow-sm" style="max-width: 500px; width: 100%;">
            
            <!-- Cabeçalho do Card (Verdeado) -->
            <div class="card-header bg-success text-white text-center py-3">
                <h4 class="mb-0">Criar Nova Categoria</h4>
            </div>
            
            <!-- Corpo do Card com o Formulário -->
            <div class="card-body p-4">
                <form method="POST" action="/category/store">
                    @csrf
                    
                    <!-- Campo Nome da Categoria -->
                    <div class="mb-3">
                        <label for="category_name" class="form-label fw-semibold">Nome da Categoria</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Ex: Pratos Principais" required>
                    </div>
                    
                    <!-- Campo Descrição -->
                    <div class="mb-4">
                        <label for="category_describe" class="form-label fw-semibold">Descrição</label>
                        <textarea class="form-control" id="category_describe" name="category_describe" rows="3" placeholder="Breve descrição da categoria..." required></textarea>
                    </div>
                    
                    <!-- Botão de Submit Ocupando Toda a Largura (Verdeado) -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success btn-lg">Criar Categoria</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container text-center">
            <h5 class="fw-bold mb-3">Raízes do Brasil</h5>
            <p class="mb-0 text-white-50">© 2026 Todos os direitos reservados.</p>
            <p class="small text-white-50">Qualidade e Sustentabilidade em cada pedido.</p>
        </div>
    </footer>

    <!-- JS do Bootstrap e Script de Tema -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement;

            themeToggle.addEventListener('click', () => {
                const currentTheme = htmlElement.getAttribute('data-bs-theme');
                if (currentTheme === 'light') {
                    htmlElement.setAttribute('data-bs-theme', 'dark');
                    themeIcon.classList.remove('bi-moon-fill');
                    themeIcon.classList.add('bi-sun-fill');
                } else {
                    htmlElement.setAttribute('data-bs-theme', 'light');
                    themeIcon.classList.remove('bi-sun-fill');
                    themeIcon.classList.add('bi-moon-fill');
                }
            });
        });
    </script>
</body>
</html>