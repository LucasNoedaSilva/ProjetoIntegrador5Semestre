<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorias - Raízes do Brasil</title>
    <!-- CSS do Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        /* Centralização absoluta da marca na navbar */
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
    <!-- Navbar com tema escuro -->
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

    <!-- Container Principal -->
    <div class="container min-vh-100">
        
        <!-- Cabeçalho da Página e Call-to-Action -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold m-0">Gestão de Categorias</h2>
            <a href="/category/create" class="btn btn-success shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Nova Categoria
            </a>
        </div>

        <!-- Data Table encapsulada em Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle m-0">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="ps-4">ID</th>
                                <th scope="col">Nome</th>
                                <th scope="col">Descrição</th>
                                <th scope="col" class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <td class="ps-4">
                                    <a href="/category/show/{{$category->id}}" class="text-decoration-none fw-bold text-success">
                                        #{{$category->id}}
                                    </a>
                                </td>
                                <td class="fw-medium">{{$category->category_name}}</td>
                                <td class="text-muted">{{$category->category_describe}}</td>
                                
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group" aria-label="Ações da Categoria">
                                         <a href="/category/show/{{$category->id}}" class="btn btn-sm btn-outline-secondary" title="Editar">
                                            <i class="bi bi-eye"></i> Ver categoria
                                        </a>
                                        <a href="/category/edit/{{$category->id}}" class="btn btn-sm btn-outline-success" title="Editar">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        @can('deletar-registros')
                                        <a href="/category/delete/{{$category->id}}" class="btn btn-sm btn-outline-danger" title="Excluir">
                                            <i class="bi bi-trash"></i> Excluir
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            <!-- Fallback caso não haja dados (opcional, recomendado em Laravel) -->
                            @if($categories->isEmpty())
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    Nenhuma categoria cadastrada no sistema.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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