<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Pedido #{{ $order->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center { position: absolute; left: 50%; transform: translateX(-50%); }
        .print-only { display: none; }
        @media print {
            .no-print { display: none !important; }
            .print-only { display: block; }
            .card { border: none !important; box-shadow: none !important; }
            .bg-body-tertiary { background-color: white !important; }
            body { padding-top: 0 !important; }
        }
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

    <!-- Conteúdo Principal -->
    <div class="container flex-grow-1 py-4">
        
        <!-- Voltar -->
        <div class="mb-3 no-print">
            <a href="/order" class="btn btn-link text-decoration-none text-secondary p-0">
                <i class="bi bi-arrow-left me-1"></i> Voltar para Lista de Pedidos
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-10">
                
                <div class="d-flex flex-wrap justify-content-between align-items-end mb-4">
                    <div>
                        <h1 class="fw-bold mb-0">Pedido #{{ $order->id }}</h1>
                        <p class="text-muted mb-0">Realizado em {{ $order->order_date->format('d/m/Y à\s H:i') }}</p>
                    </div>
                    <div class="text-end mt-3 mt-md-0">
                        @php
                            $statusConfig = [
                                'pending'   => ['class' => 'bg-warning text-dark', 'label' => 'PENDENTE'],
                                'preparing' => ['class' => 'bg-info text-dark',    'label' => 'EM PREPARO'],
                                'shipped'   => ['class' => 'bg-primary', 'label' => 'ENVIADO'],
                                'delivered' => ['class' => 'bg-success', 'label' => 'ENTREGUE'],
                                'canceled'  => ['class' => 'bg-danger',  'label' => 'CANCELADO'],
                            ];
                            $current = $statusConfig[$order->status] ?? ['class' => 'bg-secondary', 'label' => $order->status];
                        @endphp
                        <span class="badge {{ $current['class'] }} fs-6 px-3 py-2 shadow-sm">{{ $current['label'] }}</span>
                    </div>
                </div>

                <div class="row g-4">
                    <!-- Informações do Cliente -->
                    <div class="col-md-4">
                        <div class="card shadow-sm border-0 mb-4">
                            <div class="card-body">
                                <h6 class="text-success fw-bold text-uppercase mb-3"><i class="bi bi-person me-2"></i>Cliente</h6>
                                <p class="fw-bold mb-1 fs-5">{{ $order->customer->name ?? $order->customer_name ?? 'Cliente não identificado' }}</p>
                                <p class="text-muted mb-0"><i class="bi bi-telephone-fill me-2"></i>{{ $order->customer->phone ?? 'Telefone não informado' }}</p>
                                
                                <hr class="my-3 text-secondary">
                                
                                <h6 class="text-success fw-bold text-uppercase mb-3"><i class="bi bi-geo-alt me-2"></i>Endereço de Entrega</h6>
                                
                                <!-- Lógica de endereço: Verifica se tem o endereço novo estruturado, se não, usa o antigo -->
                                @if(isset($order->customer) && $order->customer->street)
                                    <p class="mb-1">{{ $order->customer->street }}, Nº {{ $order->customer->number }}</p>
                                    @if($order->customer->complement)
                                        <p class="mb-1 text-muted small"><strong>Comp:</strong> {{ $order->customer->complement }}</p>
                                    @endif
                                    <p class="mb-1">{{ $order->customer->neighborhood }} - {{ $order->customer->city }} / {{ $order->customer->state }}</p>
                                    <p class="mb-0 text-muted small"><strong>CEP:</strong> {{ $order->customer->cep }}</p>
                                @else
                                    <p class="text-muted mb-0">{{ $order->customer_address ?? 'Endereço não cadastrado' }}</p>
                                @endif
                            </div>
                        </div>

                        @if($order->notes)
                        <div class="card shadow-sm border-0 border-start border-4 border-warning mb-4">
                            <div class="card-body">
                                <h6 class="fw-bold mb-2"><i class="bi bi-exclamation-circle text-warning me-2"></i>Observações:</h6>
                                <p class="mb-0 fst-italic small text-muted">"{{ $order->notes }}"</p>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Itens do Pedido -->
                    <div class="col-md-8">
                        <div class="card shadow-sm border-0 h-100">
                            <div class="card-header bg-transparent py-3 border-bottom">
                                <h5 class="mb-0 fw-bold">Resumo dos Itens</h5>
                            </div>
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table align-middle mb-0">
                                        <thead class="table-success">
                                            <tr>
                                                <th class="ps-4">Produto</th>
                                                <th class="text-center">Qtd</th>
                                                <th class="text-end">Preço Un.</th>
                                                <th class="text-end pe-4">Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($order->products as $product)
                                            <tr>
                                                <td class="ps-4">
                                                    <span class="fw-bold">{{ $product->product_name }}</span>
                                                </td>
                                                <td class="text-center">{{ $product->pivot->quantity }}</td>
                                                <td class="text-end">R$ {{ number_format($product->pivot->price_at_purchase, 2, ',', '.') }}</td>
                                                <td class="text-end pe-4 fw-bold text-success">
                                                    R$ {{ number_format($product->pivot->quantity * $product->pivot->price_at_purchase, 2, ',', '.') }}
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="bg-body-tertiary border-top border-2">
                                            <tr>
                                                <td colspan="3" class="text-end fw-bold py-3 text-uppercase">Total do Pedido:</td>
                                                <td class="text-end pe-4 py-3">
                                                    <h4 class="text-success fw-bold mb-0">
                                                        R$ {{ number_format($order->total_price, 2, ',', '.') }}
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Botões de Ação (escondidos ao imprimir) -->
                        <div class="mt-4 d-flex flex-wrap justify-content-end gap-2 no-print">
                            <button class="btn btn-outline-secondary px-4 shadow-sm" onclick="window.print()">
                                <i class="bi bi-printer me-2"></i>Imprimir Recibo
                            </button>
                            <a href="/order/edit/{{ $order->id }}" class="btn btn-success px-4 shadow-sm">
                                <i class="bi bi-pencil-square me-2"></i>Editar Pedido
                            </a>
                        </div>
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

    <!-- Scripts -->
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