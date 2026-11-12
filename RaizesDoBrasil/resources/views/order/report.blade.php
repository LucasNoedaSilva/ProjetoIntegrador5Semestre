<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório Diário - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center { position: absolute; left: 50%; transform: translateX(-50%); }
        @media (max-width: 991.98px) { .navbar-brand-center { position: static; transform: none; } }
        .stat-card { border-left: 4px solid #198754; }
    </style>
</head>

<body class="bg-body-tertiary d-flex flex-column min-vh-100">

   <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 position-relative mb-5 shadow no-print">
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
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0">Relatório de Vendas Diário</h2>
                <p class="text-muted mb-0">Visão geral do desempenho do dia.</p>
            </div>
            <form action="/order/report" method="GET" class="d-flex gap-2">
                <input type="date" name="date" class="form-control" value="{{ $date }}">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </form>
        </div>

        <!-- Cards de Estatísticas -->
        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card shadow-sm border-0 stat-card h-100">
                    <div class="card-body">
                        <h6 class="text-muted mb-2"><i class="bi bi-cash-coin me-2"></i>Faturamento Total</h6>
                        <h3 class="fw-bold text-success mb-0">R$ {{ number_format($totalValue, 2, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <div class="card shadow-sm border-0 stat-card h-100" style="border-left-color: #0dcaf0;">
                    <div class="card-body">
                        <h6 class="text-muted mb-2"><i class="bi bi-star-fill text-warning me-2"></i>Prato Mais Vendido</h6>
                        @if($bestSellingDish)
                            <h4 class="fw-bold mb-0 text-body-emphasis">{{ $bestSellingDish['name'] }}</h4>
                            <small class="text-muted">{{ $bestSellingDish['quantity'] }} unidades vendidas</small>
                        @else
                            <h4 class="fw-bold mb-0 text-muted">Nenhuma venda</h4>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0 stat-card h-100" style="border-left-color: #fd7e14;">
                    <div class="card-body">
                        <h6 class="text-muted mb-2"><i class="bi bi-basket-fill me-2"></i>Volume de Ingredientes</h6>
                        <h3 class="fw-bold text-body-emphasis mb-0">{{ $totalIngredientsCount }}</h3>
                        <small class="text-muted">Unidades consumidas hoje</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabelas de Detalhes -->
        <div class="row g-4">
            <!-- Pratos Vendidos -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-transparent py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-success"><i class="bi bi-list-ul me-2"></i>Pratos Vendidos</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th class="ps-4">Prato</th>
                                    <th class="text-end pe-4">Quantidade</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    use Illuminate\Support\Facades\DB;
                                    use App\Models\Product;
                                @endphp

                                @forelse($dishesSold as $dishId => $dish)
                                    @php
                                        // Tenta carregar o produto e sua receita para calcular custo por unidade
                                        $product = Product::with('ingredients')->find($dishId);
                                        $costPerUnit = 0.0;

                                        if ($product && $product->ingredients->count()) {
                                            foreach ($product->ingredients as $ing) {
                                                // Busca o preço do ingrediente na tabela (coluna esperada: ingredient_price)
                                                $price = DB::table('ingredients')->where('id', $ing->id)->value('ingredient_price') ?? 0;
                                                $costPerUnit += ($ing->pivot->amount ?? 0) * $price;
                                            }
                                        }

                                        // Caso o controller já tenha enviado average_cost no array, priorizamos ele
                                        if (isset($dish['average_cost'])) {
                                            $displayAverage = $dish['average_cost'];
                                        } else {
                                            $displayAverage = $costPerUnit;
                                        }

                                        // Custo total gerado por esse prato (opcional)
                                        $totalCostForDish = $displayAverage * ($dish['quantity'] ?? 0);
                                    @endphp

                                    <tr>
                                        <td class="ps-4 fw-medium">{{ $dish['name'] }}</td>
                                        <td class="text-end pe-4">
                                            <div class="d-inline-block text-end">
                                                <span class="badge bg-primary rounded-pill">{{ $dish['quantity'] }}</span>
                                                <div class="small text-muted mt-1">Custo médio: <strong>R$ {{ number_format($displayAverage, 2, ',', '.') }}</strong></div>
                                                <div class="small text-muted">Custo total: <strong>R$ {{ number_format($totalCostForDish, 2, ',', '.') }}</strong></div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted">Nenhum prato vendido neste dia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Ingredientes Consumidos -->
            <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-transparent py-3 border-bottom">
                        <h5 class="mb-0 fw-bold text-success"><i class="bi bi-boxes me-2"></i>Ingredientes Consumidos</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table table-hover mb-0">
                            <thead class="table-success">
                                <tr>
                                    <th class="ps-4">Ingrediente</th>
                                    <th class="text-end pe-4">Total Descontado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totalIngredientsValue = 0.0;
                                @endphp

                                @forelse($ingredientsUsed as $ingredientId => $ingredient)
                                    @php
                                        // Busca o preço unitário do ingrediente (coluna esperada: ingredient_price)
                                        $unitPrice = DB::table('ingredients')->where('id', $ingredientId)->value('ingredient_price') ?? 0;
                                        $quantityUsed = $ingredient['quantity'] ?? 0;
                                        $cost = $unitPrice * $quantityUsed;
                                        $totalIngredientsValue += $cost;
                                    @endphp

                                    <tr>
                                        <td class="ps-4 fw-medium">{{ $ingredient['name'] }}</td>
                                        <td class="text-end pe-4">
                                            <div class="d-inline-block text-end">
                                                <span class="badge bg-secondary rounded-pill">{{ $quantityUsed }}</span>
                                                <div class="small text-muted mt-1">Valor unitário: <strong>R$ {{ number_format($unitPrice, 2, ',', '.') }}</strong></div>
                                                <div class="small text-muted">Valor total: <strong>R$ {{ number_format($cost, 2, ',', '.') }}</strong></div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="text-center py-4 text-muted">Nenhum ingrediente consumido.</td>
                                    </tr>
                                @endforelse

                                {{-- Linha de total geral dos ingredientes --}}
                                <tr class="bg-body-tertiary border-top border-2">
                                    <td class="ps-4 fw-bold text-uppercase py-3">Total gasto com ingredientes</td>
                                    <td class="text-end pe-4 py-3">
                                        <strong class="text-danger">R$- {{ number_format($totalIngredientsValue, 2, ',', '.') }}</strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

 <!-- Rodapé -->
    <footer class="bg-dark text-white py-4 mt-auto no-print">
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