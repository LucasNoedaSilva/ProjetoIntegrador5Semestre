<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
        }
        @media (max-width: 991.98px) {
            .navbar-brand-center { position: static; transform: none; }
        }
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
</head>

<body class="bg-body-tertiary d-flex flex-column min-vh-100">

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

    <!-- Container centralizado -->
    <div class="container flex-grow-1 d-flex justify-content-center align-items-center py-5">
        
        <div class="card shadow-sm border-0" style="max-width: 800px; width: 100%;">
            
            <div class="card-header bg-success text-white text-center py-3 border-0">
                <h4 class="mb-0 fw-bold"><i class="bi bi-pencil-square me-2"></i>Editar Prato: {{ $product->product_name }}</h4>
            </div>
            
            <div class="card-body p-4 p-md-5">
                <!-- Adicionado ID productForm -->
                <form action="/product/update/{{$product->id}}" method="POST" id="productForm">
                    @csrf
                    
                    <div class="row">
                        <!-- Nome -->
                        <div class="col-md-6 mb-3">
                            <label for="product_name" class="form-label fw-semibold text-secondary small text-uppercase">Nome do Produto</label>
                            <input type="text" class="form-control" id="product_name" name="product_name" value="{{ $product->product_name }}" required>
                        </div>

                        <!-- Categoria -->
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label fw-semibold text-secondary small text-uppercase">Categoria</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                @foreach($categorys as $category)
                                    {{-- Exibe APENAS a categoria com ID igual a 1 (Comida) --}}
                                    @if($category->id == 1)
                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->category_name }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Descrição -->
                    <div class="mb-3">
                        <label for="product_describe" class="form-label fw-semibold text-secondary small text-uppercase">Descrição do Produto</label>
                        <textarea class="form-control" id="product_describe" name="product_describe" rows="3" required>{{ $product->product_describe }}</textarea>
                    </div>

                    <!-- Tabela de Ingredientes -->
                    <div class="mb-4 mt-4">
                        <label class="form-label fw-semibold text-secondary small text-uppercase">Ingredientes e Quantidades</label>
                        <div class="card border-secondary-subtle">
                            <div class="table-responsive" style="max-height: 300px; overflow-y: auto;">
                                <table class="table table-sm table-hover align-middle mb-0">
                                    <thead class="table-success sticky-top">
                                        <tr>
                                            <th class="ps-3" style="width: 50px;">Sel.</th>
                                            <th>Ingrediente</th>
                                            <th style="width: 150px;" class="pe-3 text-center">Qtd. Usada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($ingredients as $ingredient)
                                            {{-- Filtra para mostrar apenas se a categoria contiver a palavra "ingrediente" --}}
                                            @if(str_contains(strtolower($ingredient->category->category_name ?? ''), 'ingrediente'))
                                                @php
                                                    // Verifica se o ingrediente atual está na lista do prato
                                                    $productIngredient = $product->ingredients->find($ingredient->id);
                                                    $isSelected = !is_null($productIngredient);
                                                    $amount = $isSelected ? intval($productIngredient->pivot->amount) : '';
                                                    
                                                    // Lógicas de estoque
                                                    $qty = $ingredient->ingredient_quantity;
                                                    $isOutOfStock = $qty <= 0;
                                                    $isLowStock = $qty >= 1 && $qty <= 10;
                                                    
                                                    // Verifica se está vencido comparando com a data de hoje
                                                    $dueDate = \Carbon\Carbon::parse($ingredient->ingredient_due_date)->startOfDay();
                                                    $today = \Carbon\Carbon::now()->startOfDay();
                                                    $isExpired = $dueDate->lt($today);
                                                    
                                                    // Bloqueia apenas se NÃO estiver selecionado E (o estoque for 0 OU estiver vencido)
                                                    $isDisabled = !$isSelected && ($isOutOfStock || $isExpired);
                                                @endphp
                                            <tr>
                                                <td class="ps-3">
                                                    <div class="form-check">
                                                        <!-- Adicionado classe 'ingredient-checkbox' e lógica de ocultar erro no onchange -->
                                                        <input class="form-check-input border-success ingredient-checkbox" type="checkbox" 
                                                               name="ingredients[{{ $ingredient->id }}][selected]" 
                                                               id="ing_{{ $ingredient->id }}"
                                                               {{ $isSelected ? 'checked' : '' }}
                                                               {{ $isDisabled ? 'disabled' : '' }}
                                                               onchange="document.getElementById('amount_{{ $ingredient->id }}').required = this.checked; document.getElementById('ingredientError').style.display = 'none';">
                                                    </div>
                                                </td>
                                                <td>
                                                    <label class="form-check-label d-block cursor-pointer fw-medium {{ $isDisabled ? 'text-muted' : '' }}" for="ing_{{ $ingredient->id }}">
                                                        {{ $ingredient->ingredient_name }}
                                                        
                                                        {{-- Exibição dinâmica das badges --}}
                                                        @if($isExpired)
                                                            <span class="badge bg-danger ms-2" style="font-size: 0.65rem;">Vencido</span>
                                                        @elseif($isOutOfStock) 
                                                            <span class="badge bg-danger ms-2" style="font-size: 0.65rem;">Sem Estoque</span> 
                                                        @elseif($isLowStock)
                                                            <span class="badge bg-warning text-dark ms-2" style="font-size: 0.65rem;">Estoque Baixo</span>
                                                        @endif
                                                    </label>
                                                </td>
                                                <td class="pe-3">
                                                    <input type="number" step="1" min="1" max="{{ $qty }}" class="form-control form-control-sm" 
                                                           name="ingredients[{{ $ingredient->id }}][amount]" 
                                                           id="amount_{{ $ingredient->id }}"
                                                           value="{{ $amount }}"
                                                           placeholder="Máx: {{ $qty }}"
                                                           {{ $isDisabled ? 'disabled' : '' }}
                                                           {{ $isSelected ? 'required' : '' }}>
                                                    <div class="text-center mt-1" style="font-size: 0.7rem; color: {{ ($isLowStock && !$isDisabled) ? 'var(--bs-warning)' : 'var(--bs-secondary)' }};">
                                                        Estoque: {{ $qty }}
                                                    </div>
                                                </td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Mensagem de Erro JS (Invisível por padrão) -->
                        <div id="ingredientError" class="alert alert-danger mt-2 py-2" style="display: none; font-size: 0.85rem;">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i> Você precisa manter pelo menos um ingrediente selecionado para salvar o prato.
                        </div>

                        <div class="form-text mt-2">Marque o ingrediente e digite a quantidade (em números inteiros) necessária para a receita.</div>
                    </div>

                    <!-- Preço -->
                    <div class="mb-4">
                        <label for="product_price" class="form-label fw-semibold text-secondary small text-uppercase">Preço de Venda (R$)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-success text-white border-success">R$</span>
                            <!-- min ajustado para 0.50 -->
                            <input type="number" step="0.01" min="0.50" class="form-control border-success" id="product_price" name="product_price" value="{{ $product->product_price }}" required>
                        </div>
                    </div>
                    
                    <!-- Botões -->
                    <div class="d-grid gap-2 mt-5">
                        <button type="submit" class="btn btn-success btn-lg shadow-sm">
                            <i class="bi bi-save me-1"></i> Salvar Alterações
                        </button>
                        <a href="/product" class="btn btn-outline-secondary py-2">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white py-4 mt-auto">
        <div class="container text-center">
            <p class="mb-0 small text-white-50">© 2026 Raízes do Brasil - Qualidade e Sustentabilidade em cada pedido.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // Lógica de validação do formulário (Exigir pelo menos 1 ingrediente)
            const form = document.getElementById('productForm');
            
            form.addEventListener('submit', function (event) {
                // Pega todos os checkboxes de ingredientes
                const checkboxes = document.querySelectorAll('.ingredient-checkbox');
                let hasChecked = false;

                // Verifica se algum está marcado
                for (let i = 0; i < checkboxes.length; i++) {
                    if (checkboxes[i].checked) {
                        hasChecked = true;
                        break;
                    }
                }

                // Se não tiver nenhum marcado, bloqueia o envio e mostra o erro
                if (!hasChecked) {
                    event.preventDefault(); // Impede o formulário de ser enviado
                    const errorBox = document.getElementById('ingredientError');
                    errorBox.style.display = 'block';
                    
                    // Faz a tela rolar suavemente até a mensagem de erro
                    errorBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });

            // Tema Claro/Escuro
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement;

            if(themeToggle) {
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
            }
        });
    </script>
</body>
</html>