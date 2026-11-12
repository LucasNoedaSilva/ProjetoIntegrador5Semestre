<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pratos - Raízes do Brasil</title>
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

<body class="bg-body-tertiary d-flex flex-column min-vh-100">

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

    <!-- Container Principal -->
    <div class="container flex-grow-1 pb-5">
        
        <!-- Cabeçalho com Título, Busca e Botão -->
        <div class="row align-items-center mb-4 g-3">
            <div class="col-md-4">
                <h2 class="fw-bold m-0">Gestão de Pratos</h2>
            </div>
            
            <!-- Barra de Busca -->
            <div class="col-md-5">
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-body border-end-0 text-muted">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" id="searchInput" class="form-control border-start-0 ps-0" placeholder="Buscar prato por nome...">
                </div>
            </div>

            <div class="col-md-3 text-md-end">
                <a href="/product/create" class="btn btn-success shadow-sm w-100">
                    <i class="bi bi-plus-lg me-1"></i> Novo Prato
                </a>
            </div>
        </div>

        <!-- Data Table encapsulada em Card -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle m-0">
                        <thead class="table-success">
                            <tr>
                                <th scope="col" class="ps-4">ID</th>
                                <th scope="col">Nome do Prato</th>
                                <th scope="col">Descrição</th>
                                <th scope="col">Categoria</th>
                                <th scope="col">Preço</th>
                                <th scope="col" class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="productsTableBody">
                            @foreach($products as $product)
                                @php
                                    $hasIssue = false;
                                    $issueReason = '';

                                    // Lógica para checar estoque e validade
                                    foreach($product->ingredients as $ingredient) {
                                        $requiredQty = $ingredient->pivot->amount ?? 1;
                                        $currentStock = $ingredient->ingredient_quantity;
                                        
                                        // Verifica se tem estoque suficiente para fazer pelo menos 1 prato
                                        if ($currentStock < $requiredQty) {
                                            $hasIssue = true;
                                            $issueReason = 'Falta de Ingredientes';
                                            break;
                                        }

                                        // Verifica validade comparando com hoje
                                        $dueDate = \Carbon\Carbon::parse($ingredient->ingredient_due_date)->startOfDay();
                                        $today = \Carbon\Carbon::now()->startOfDay();
                                        if ($dueDate->lt($today)) {
                                            $hasIssue = true;
                                            $issueReason = 'Ingrediente Vencido';
                                            break;
                                        }
                                    }
                                @endphp

                            <!-- A classe table-danger pinta a linha de vermelho se houver problema -->
                            <tr class="{{ $hasIssue ? 'table-danger' : '' }}">
                                <td class="ps-4">
                                    <a href="/product/show/{{$product->id}}" class="text-decoration-none fw-bold {{ $hasIssue ? 'text-danger' : 'text-success' }}">
                                        #{{$product->id}}
                                    </a>
                                </td>
                                <!-- Classe 'product-name' adicionada para o JavaScript achar o nome -->
                                <td class="fw-medium product-name">
                                    {{$product->product_name}}
                                    
                                    <!-- Exibe o motivo do alerta (se houver) -->
                                    @if($hasIssue)
                                        <span class="badge bg-danger ms-2" style="font-size: 0.70rem;">
                                            <i class="bi bi-exclamation-circle me-1"></i>{{ $issueReason }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted">{{$product->product_describe}}</td>
                                <td>
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary">
                                        {{$product->category->category_name}}
                                    </span>
                                </td>
                                <td class="fw-semibold {{ $hasIssue ? 'text-danger' : 'text-success' }}">
                                    R$ {{ number_format($product->product_price, 2, ',', '.') }}
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group" aria-label="Ações do Produto">
                                        <!-- Botão 'Ver Prato' adicionado -->
                                        <a href="/product/show/{{$product->id}}" class="btn btn-sm btn-outline-primary" title="Ver Prato">
                                            <i class="bi bi-eye"></i> Ver Prato
                                        </a>
                                        <a href="/product/edit/{{$product->id}}" class="btn btn-sm btn-outline-success" title="Editar">
                                            <i class="bi bi-pencil-square"></i> Editar
                                        </a>
                                        @can('deletar-registros')
                                        <a href="/product/delete/{{$product->id}}" class="btn btn-sm btn-outline-danger" title="Excluir">
                                            <i class="bi bi-trash"></i> Excluir
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            <!-- Fallback caso não haja dados -->
                            @if($products->isEmpty())
                            <tr class="empty-row">
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                    Nenhum produto cadastrado no sistema.
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0 small text-white-50">© 2026 Raízes do Brasil - Qualidade e Sustentabilidade em cada pedido.</p>
        </div>
    </footer>

    <!-- JS do Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts Funcionais -->
    <script>
        // Lógica de Troca de Tema Claro/Escuro
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

        // Lógica de Busca Dinâmica
        const searchInput = document.getElementById('searchInput');
        const tableRows = document.querySelectorAll('#productsTableBody tr:not(.empty-row)');

        searchInput.addEventListener('input', function() {
            // Pega o texto digitado, converte pra minúsculo e remove acentos
            const searchTerm = this.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");

            tableRows.forEach(row => {
                const nameCell = row.querySelector('.product-name');
                if (nameCell) {
                    // Pega o nome do prato na tabela, converte pra minúsculo e remove acentos
                    const nameText = nameCell.textContent.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");
                    
                    // Mostra ou esconde a linha dependendo de bater com a busca
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