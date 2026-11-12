<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Ingrediente - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
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

<body class="bg-body-tertiary d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 position-relative mb-5 shadow">
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

    <!-- Container centralizado ocupando o espaço restante -->
    <div class="container flex-grow-1 d-flex justify-content-center align-items-center py-5">
        
        <div class="card shadow-sm border-0" style="max-width: 500px; width: 100%;">
            
            <div class="card-header bg-success text-white text-center py-3 border-0">
                <h5 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Estoque</h5>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <form action="/ingredient/update/{{$ingredient->id}}" method="POST">
                    @csrf
                    
                    <!-- Nome -->
                    <div class="mb-3">
                        <label for="ingredient_name" class="form-label fw-semibold text-secondary small text-uppercase">Nome do Ingrediente</label>
                        <input type="text" class="form-control" id="ingredient_name" name="ingredient_name" value="{{$ingredient->ingredient_name}}" required>
                    </div>
                    
                    <div class="row">
                        <!-- Quantidade -->
                        <div class="col-md-6 mb-3">
                            <label for="ingredient_quantity" class="form-label fw-semibold text-secondary small text-uppercase">Quantidade</label>
                            <!-- Adicionado min="1" -->
                            <input type="number" class="form-control" id="ingredient_quantity" name="ingredient_quantity" value="{{$ingredient->ingredient_quantity}}" placeholder="Ex: 5" required min="1">
                        </div>

                        <!-- Valor Unitário -->
                        <div class="col-md-6 mb-3">
                            <label for="ingredient_price" class="form-label fw-semibold text-secondary small text-uppercase">Valor Unit. (R$)</label>
                            <!-- Alterado min para 0.5 -->
                            <input type="number" step="0.01" min="0.5" class="form-control" id="ingredient_price" name="ingredient_price" value="{{$ingredient->ingredient_price}}" placeholder="Ex: 10.50" required>
                        </div>
                    </div>
                    
                    <!-- Data de Vencimento -->
                    <div class="mb-3">
                        <label for="ingredient_due_date" class="form-label fw-semibold text-secondary small text-uppercase">Data de Vencimento</label>
                        <!-- value traz a data do banco e min bloqueia datas anteriores a hoje -->
                        <input type="date" class="form-control" id="ingredient_due_date" name="ingredient_due_date" value="{{$ingredient->ingredient_due_date}}" min="{{ date('Y-m-d') }}" required>
                    </div>

                    <!-- Categoria -->
                    <div class="mb-4">
                        <label for="category_id" class="form-label fw-semibold text-secondary small text-uppercase">Categoria</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            @foreach($categorys as $category)
                                {{-- Esconde a categoria com ID 1 (comida) --}}
                                @if($category->id != 1)
                                    <option value="{{ $category->id }}" {{ $ingredient->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Botões -->
                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-success fw-bold shadow-sm py-2">
                            <i class="bi bi-save me-1"></i> Editar Estoque
                        </button>
                        <a href="/ingredient" class="btn btn-outline-secondary py-2">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0 small text-white-50">© 2026 Raízes do Brasil - Qualidade e Sustentabilidade em cada pedido.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement;

            if (themeToggle) {
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
            }
        });
    </script>
</body>
</html>