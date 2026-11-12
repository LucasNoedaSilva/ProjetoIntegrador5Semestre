<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center { position: absolute; left: 50%; transform: translateX(-50%); }
        @media (max-width: 991.98px) { .navbar-brand-center { position: static; transform: none; } }
        
        /* Efeito de hover nos cards do menu */
        .module-card {
            transition: all 0.3s ease;
            cursor: pointer;
            border: none !important; /* Removendo borda padrão para um visual mais limpo */
        }
        .module-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
        }
        .icon-circle {
            width: 70px;
            height: 70px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
        }
    </style>
</head>

<body class="bg-body-tertiary">

    <!-- Navbar Mantida -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 position-relative mb-5">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
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

    <!-- Main Content: Hub de Navegação -->
    <main class="container pb-5">
        <div class="mb-5 text-center">
            <!-- Removido 'text-dark' para que a cor mude automaticamente no modo escuro -->
            <h2 class="fw-bold">Bem-vindo(a) ao Raízes do Brasil</h2>
            <p class="text-secondary">Selecione um módulo abaixo para começar a gerenciar o restaurante.</p>
        </div>

        <div class="row g-4 justify-content-center">
            
            <!-- Botão: Categorias -->
            <div class="col-sm-6 col-lg-4">
                <a href="/category" class="text-decoration-none">
                    <div class="card h-100 shadow-sm module-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-circle bg-primary bg-opacity-10 mb-3">
                                <i class="bi bi-tags-fill fs-2 text-primary"></i>
                            </div>
                            <h5 class="fw-bold mb-2 text-body">Categorias</h5>
                            <p class="text-secondary small mb-0">Organize os grupos do seu cardápio (ex: Bebidas, Sobremesas).</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Botão: Ingredientes -->
            <div class="col-sm-6 col-lg-4">
                <a href="/ingredient" class="text-decoration-none">
                    <div class="card h-100 shadow-sm module-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-circle bg-warning bg-opacity-10 mb-3">
                                <i class="bi bi-basket2-fill fs-2 text-warning"></i>
                            </div>
                            <h5 class="fw-bold mb-2 text-body">Estoque</h5>
                            <p class="text-secondary small mb-0">Gerencie o estoque e os custos dos insumos da cozinha.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Botão: Produtos (Pratos) -->
            <div class="col-sm-6 col-lg-4">
                <a href="/product" class="text-decoration-none">
                    <div class="card h-100 shadow-sm module-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-circle bg-success bg-opacity-10 mb-3">
                                <!-- Ícone atualizado para prato/refeição -->
                                <i class="bi bi-egg-fried fs-2 text-success"></i>
                            </div>
                            <h5 class="fw-bold mb-2 text-body">Pratos</h5>
                            <p class="text-secondary small mb-0">Crie pratos, monte fichas técnicas e defina os preços de venda.</p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-sm-6 col-lg-4">
                <a href="/customer" class="text-decoration-none">
                    <div class="card h-100 shadow-sm module-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-circle bg-secondary bg-opacity-10 mb-3">
                                <i class="bi bi-people-fill fs-2 text-secondary"></i>
                            </div>
                            <h5 class="fw-bold mb-2 text-body">Clientes</h5>
                            <p class="text-secondary small mb-0">Visualize e gerencie a carteira de clientes cadastrados no sistema.</p>
                        </div>
                    </div>
                </a>
            </div>
            
            <!-- Botão: Pedidos -->
            <div class="col-sm-6 col-lg-4">
                <a href="/order" class="text-decoration-none">
                    <div class="card h-100 shadow-sm module-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-circle bg-danger bg-opacity-10 mb-3">
                                <i class="bi bi-receipt-cutoff fs-2 text-danger"></i>
                            </div>
                            <h5 class="fw-bold mb-2 text-body">Pedidos</h5>
                            <p class="text-secondary small mb-0">Registre novas vendas e acompanhe os pedidos em andamento.</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Botão: Relatórios -->
            <div class="col-sm-6 col-lg-4">
                <a href="/order/report" class="text-decoration-none">
                    <div class="card h-100 shadow-sm module-card">
                        <div class="card-body text-center p-4">
                            <div class="icon-circle bg-info bg-opacity-10 mb-3">
                                <i class="bi bi-graph-up-arrow fs-2 text-info"></i>
                            </div>
                            <h5 class="fw-bold mb-2 text-body">Relatórios</h5>
                            <p class="text-secondary small mb-0">Fechamento diário, faturamento, pratos mais vendidos e lucros.</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </main>

   <!-- Rodapé -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0 small text-white-50">© 2026 Raízes do Brasil - Qualidade e Sustentabilidade em cada pedido.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        const htmlElement = document.documentElement;

        themeToggle.addEventListener('click', () => {
            const currentTheme = htmlElement.getAttribute('data-bs-theme');
            if (currentTheme === 'light') {
                htmlElement.setAttribute('data-bs-theme', 'dark');
                themeIcon.classList.replace('bi-moon-fill', 'bi-sun-fill');
            } else {
                htmlElement.setAttribute('data-bs-theme', 'light');
                themeIcon.classList.replace('bi-sun-fill', 'bi-moon-fill');
            }
        });
    </script>
</body>
</html>