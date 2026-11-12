<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Categoria - Raízes do Brasil</title>
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
        
        /* Ajuste para os cards no modo escuro */
        [data-bs-theme="dark"] .bg-light {
            background-color: #2b3035 !important;
            border-color: #495057 !important;
        }
        [data-bs-theme="dark"] .card {
            background-color: #212529;
            border-color: #495057;
        }
    </style>
</head>

<body class="bg-body-tertiary">

    <!-- Navbar com tema escuro -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 position-relative mb-5 shadow">
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
                        <span class="fw-medium text-white">{{ Auth::user()->name ?? 'Usuário' }}</span>
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
    <div class="container d-flex justify-content-center align-items-center py-5" style="min-height: 60vh;">
        
        <!-- Card com sombra para destacar os detalhes -->
        <div class="card shadow-sm border-0" style="max-width: 600px; width: 100%;">
            
            <!-- Cabeçalho do Card (Verde) -->
            <div class="card-header bg-success text-white text-center py-3 border-0">
                <h5 class="mb-0 fw-bold"><i class="bi bi-tags me-2"></i>Detalhes da Categoria</h5>
            </div>
            
            <!-- Corpo do Card com os Dados -->
            <div class="card-body p-5 text-center">
                
                <h1 class="display-5 fw-bold text-success mb-3">{{$category->category_name}}</h1>
                
                <p class="lead text-body-secondary mb-5">{{$category->category_describe}}</p>
                
                <!-- Botões de Ação -->
                <div class="d-flex justify-content-center gap-3">
                    <a href="/category" class="btn btn-outline-secondary px-4">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                    <a href="/category/edit/{{$category->id}}" class="btn btn-success px-4 shadow-sm">
                        <i class="bi bi-pencil-square me-1"></i> Editar
                    </a>
                </div>
                
            </div>
        </div>
    </div>
    
    <footer class="bg-dark text-white py-5 mt-auto">
        <div class="container text-center">
            <h5 class="fw-bold mb-3">Raízes do Brasil</h5>
            <p class="mb-0 text-white-50">© 2026 Todos os direitos reservados.</p>
            <p class="small text-white-50">Qualidade e Sustentabilidade em cada pedido.</p>
        </div>
    </footer>

    <!-- JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script para alternar o tema Claro/Escuro -->
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