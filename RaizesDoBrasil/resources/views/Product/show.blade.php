<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Produto - Raízes do Brasil</title>
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
        .detail-label {
            font-weight: 700;
            color: #198754;
            text-transform: uppercase;
            font-size: 0.75rem;
            letter-spacing: 0.5px;
        }
        .ingredient-item {
            border-left: 3px solid #198754;
            background-color: rgba(25, 135, 84, 0.05);
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

    <div class="container flex-grow-1 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                
                <div class="d-flex justify-content-between align-items-end mb-4">
                    <div>
                        <span class="badge bg-success mb-2">Detalhes do Prato</span>
                        <h2 class="fw-bold m-0">{{ $product->product_name }}</h2>
                    </div>
                    <a href="/product" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                </div>

                <div class="row g-4">
                    <!-- Coluna de Informações do Produto -->
                    <div class="col-md-5">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-body p-4">
                                <div class="mb-4">
                                    <label class="detail-label d-block">ID do Prato</label>
                                    <span class="fs-5 fw-bold text-success">#{{ $product->id }}</span>
                                </div>

                                <div class="mb-4">
                                    <label class="detail-label d-block">Preço de Venda</label>
                                    <!-- Alterado de text-dark para text-body-emphasis -->
                                    <span class="fs-3 fw-bold text-body-emphasis">R$ {{ number_format($product->product_price, 2, ',', '.') }}</span>
                                </div>

                                <div class="mb-4">
                                    <label class="detail-label d-block">Categoria</label>
                                    <!-- Alterado de text-dark para text-body -->
                                    <span class="badge border text-body fw-medium">{{ $product->category->category_name}}</span>
                                </div>

                                <div class="mb-4">
                                    <label class="detail-label d-block">Estoque Disponível</label>
                                    <span class="fs-5">{{ $product->product_amount }} unidades</span>
                                </div>

                                <hr>

                                <div>
                                    <label class="detail-label d-block mb-2">Descrição</label>
                                    <p class="text-muted small fst-italic">{{ $product->product_describe }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Coluna de Ingredientes -->
                    <div class="col-md-7">
                        <div class="card shadow-sm border-0 h-100">
                            <!-- Alterado bg-white para bg-transparent -->
                            <div class="card-header bg-transparent py-3">
                                <h5 class="card-title mb-0 fw-bold">
                                    <i class="bi bi-egg-fried text-success me-2"></i>Ingredientes Necessários
                                </h5>
                            </div>
                            <div class="card-body p-0">
                                <ul class="list-group list-group-flush">
                                    @php $totalProductionCost = 0; @endphp
                                    
                                    @foreach($product->ingredients as $ingredient)
                                    @php 
                                        $subtotal = $ingredient->ingredient_price * $ingredient->pivot->amount;
                                        $totalProductionCost += $subtotal;
                                    @endphp
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4">
                                        <div>
                                            <span class="fw-medium d-block">{{ $ingredient->ingredient_name }}</span>
                                            <small class="text-muted">R$ {{ number_format($ingredient->ingredient_price, 2, ',', '.') }} p/ unidade</small>
                                        </div>
                                        <div class="text-end">
                                            <span class="fw-bold d-block text-success">
                                                R$ {{ number_format($subtotal, 2, ',', '.') }}
                                            </span>
                                            <small class="text-muted">{{ $ingredient->pivot->amount }} unidades</small>
                                        </div>
                                    </li>
                                    @endforeach

                                    @if($product->ingredients->isEmpty())
                                    <li class="list-group-item text-center py-4 text-muted border-bottom-0">
                                        Nenhum ingrediente vinculado a este produto.
                                    </li>
                                    @else
                                    <!-- Alterado de bg-light para bg-body-tertiary -->
                                    <li class="list-group-item d-flex justify-content-between align-items-center py-3 px-4 bg-body-tertiary border-top border-2 border-bottom-0">
                                        <div class="fw-bold text-uppercase" style="letter-spacing: 1px;">
                                            Custo Total de Produção
                                        </div>
                                        <div class="text-end">
                                            <span class="fs-5 fw-bold text-danger">
                                                R$ {{ number_format($totalProductionCost, 2, ',', '.') }}
                                            </span>
                                        </div>
                                    </li>
                                    @endif
                                </ul>
                            </div>

                            <div class="p-4 bg-body-tertiary border-top">
                                <div class="alert alert-info border-0 shadow-sm m-0">
                                    <i class="bi bi-graph-up-arrow me-2"></i>
                                    <strong>Margem de Lucro:</strong> 
                                    Lucro bruto: <span class="text-success fw-bold">R$ {{ number_format($product->product_price - $totalProductionCost, 2, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Alterado de bg-light para bg-transparent -->
                            <div class="card-footer bg-transparent p-3 text-center border-top">
                                <div class="btn-group w-100">
                                    <a href="/product/edit/{{$product->id}}" class="btn btn-success">
                                        <i class="bi bi-pencil-square me-1"></i> Editar Produto
                                    </a>
                                   @can('deletar-registros')
                                    <a href="/product/delete/{{$product->id}}" class="btn btn-outline-danger">
                                        <i class="bi bi-trash"></i> Apagar Produto
                                    </a>
                                     @endcan
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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