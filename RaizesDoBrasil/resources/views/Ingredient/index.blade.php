<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingredientes - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
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
        /* Badge personalizada para a categoria */
        .badge-category {
            background-color: #e9ecef;
            color: #198754;
            font-weight: 600;
        }
        [data-bs-theme="dark"] .badge-category {
            background-color: #2c3034;
            color: #75b798;
        }
    </style>
</head>

<body class="bg-body-tertiary d-flex flex-column min-vh-100">

    <!-- Navbar -->
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

    <!-- Conteúdo Principal -->
    <div class="container flex-grow-1 pb-5">
        
        <!-- Cabeçalho com Título, Busca e Botão -->
        <div class="row align-items-center mb-4 g-3">
            <div class="col-md-4">
                <h2 class="fw-bold m-0">Lista de Estoque</h2>
            </div>
            
            <!-- Barra de Busca -->
            <div class="col-md-5">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-body border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Buscar ingrediente por nome...">
                </div>
            </div>

            <div class="col-md-3 text-md-end">
                <a href="/ingredient/create" class="btn btn-success shadow-sm w-100">
                    <i class="bi bi-plus-lg me-1"></i> Novo Item
                </a>
            </div>
        </div>

        <!-- Tabela -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="ps-4">ID</th>
                                <th scope="col">Ingrediente</th>
                                <th scope="col">Categoria</th>
                                <th scope="col" class="text-end">Valor Unit.</th>
                                <th scope="col" class="text-center">Qtd.</th>
                                <th scope="col">Vencimento</th>
                                <th scope="col" class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="ingredientsTableBody">
                            @foreach($ingredients as $ingredient)
                            @php
                                // Cálculo de Vencimento
                                $dueDate = \Carbon\Carbon::parse($ingredient->ingredient_due_date)->startOfDay();
                                $today = \Carbon\Carbon::now()->startOfDay();
                                $daysToDue = $today->diffInDays($dueDate, false); // false permite valores negativos se já passou da data
                                $isExpiring = $daysToDue <= 7;
                                
                                // Lógica de Estoque
                                $qty = $ingredient->ingredient_quantity;
                                $isOutOfStock = $qty <= 0;
                                $isLowStock = $qty >= 1 && $qty <= 10;
                                
                                // A linha fica vermelha se o estoque estiver baixo (1 a 10), sem estoque (0) ou perto de vencer
                                $rowClass = ($isOutOfStock || $isLowStock || $isExpiring) ? 'table-danger' : '';
                            @endphp

                            <tr class="{{ $rowClass }}">
                                <td class="ps-4 fw-bold">
                                    <a href="/ingredient/show/{{$ingredient->id}}" class="link-success text-decoration-none">
                                        #{{$ingredient->id}}
                                    </a>
                                </td>
                                <td class="fw-medium ingredient-name">
                                    {{$ingredient->ingredient_name}}
                                </td>
                                <td>
                                    <span class="badge badge-category px-2 py-1">
                                        {{$ingredient->category->category_name}}
                                    </span>
                                </td>
                                <td class="text-end text-muted fw-medium">
                                    R$ {{ number_format($ingredient->ingredient_price, 2, ',', '.') }}
                                </td>
                                <td class="text-center">
                                    <!-- Alerta visual na quantidade -->
                                    @if($isOutOfStock)
                                        <span class="badge bg-danger rounded-pill px-3 py-2" title="Sem Estoque!">
                                            <i class="bi bi-x-circle-fill me-1"></i> {{$qty}} (Sem Estoque)
                                        </span>
                                    @elseif($isLowStock)
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2" title="Estoque Baixo!">
                                            <i class="bi bi-exclamation-triangle-fill me-1"></i> {{$qty}} (Estoque Baixo)
                                        </span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill px-3 py-2">{{$qty}}</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="fw-bold @if($isExpiring || $isOutOfStock || $isLowStock) text-danger @else text-secondary @endif">
                                        {{ date('d/m/Y', strtotime($ingredient->ingredient_due_date)) }}
                                    </small>
                                    
                                    <!-- Alerta visual de vencimento -->
                                    @if($isExpiring)
                                        @if($daysToDue < 0)
                                            <span class="badge bg-danger ms-1 py-1" style="font-size: 0.65rem;">VENCIDO</span>
                                        @elseif($daysToDue == 0)
                                            <span class="badge bg-danger ms-1 py-1" style="font-size: 0.65rem;">VENCE HOJE</span>
                                        @else
                                            <i class="bi bi-clock-history ms-1 text-danger" title="Vence em {{ $daysToDue }} dia(s)"></i>
                                        @endif
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <!-- Botão de Estoque que leva aos Detalhes -->
                                        <a href="/ingredient/show/{{$ingredient->id}}" class="btn btn-sm btn-outline-primary" title="Ver Detalhes do Estoque">
                                            <i class="bi bi-box-seam"></i> Estoque
                                        </a>
                                        <a href="/ingredient/edit/{{$ingredient->id}}" class="btn btn-sm btn-outline-success">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        @can('deletar-registros')
                                        <a href="/ingredient/delete/{{$ingredient->id}}" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i> Deletar
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            @if($ingredients->isEmpty())
                            <tr class="empty-row">
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Nenhum ingrediente encontrado no estoque.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
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
        // Lógica de Troca de Tema
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

        // Lógica de Busca Dinâmica
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#ingredientsTableBody tr:not(.empty-row)');

        searchInput.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");

            tableRows.forEach(row => {
                const nameCell = row.querySelector('.ingredient-name');
                if (nameCell) {
                    const nameText = nameCell.textContent.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");
                    if (nameText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
        });
    </script>
</body>
</html>