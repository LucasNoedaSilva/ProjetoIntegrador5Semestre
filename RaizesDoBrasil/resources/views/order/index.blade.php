<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center { position: absolute; left: 50%; transform: translateX(-50%); }
        @media (max-width: 991.98px) { .navbar-brand-center { position: static; transform: none; } }
        .status-badge { width: 110px; }
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
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container flex-grow-1 pb-5">
        <div class="row align-items-end mb-4 g-3">
            <div class="col-md-5">
                <h2 class="fw-bold mb-0">Gestão de Pedidos</h2>
                <p class="text-muted mb-0">Acompanhe e gerencie as solicitações dos clientes.</p>
            </div>
            
            <!-- BARRA DE BUSCA (Estilo Idêntico ao Create) -->
            <div class="col-md-4">
                <label class="form-label fw-bold text-success"><i class="bi bi-search me-1"></i>Buscar Pedido</label>
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-success-subtle border-success text-success"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control border-success border-start-0" placeholder="Digite o nome ou telefone...">
                </div>
            </div>

            <div class="col-md-3 text-md-end pb-1">
                <a href="/order/create" class="btn btn-success shadow-sm w-100">
                    <i class="bi bi-plus-lg me-1"></i> Novo Pedido
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-success">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Cliente / Contato</th>
                                <th>Pedidos</th>
                                <th>Total</th>
                                <th class="text-center">Status</th>
                                <th class="text-end pe-4">Ações</th>
                            </tr>
                        </thead>

                        <tbody id="ordersTableBody">
                            @foreach($orders as $order)
                            <tr class="order-row {{ $order->status == 'delivered' ? 'table-success' : ($order->status == 'canceled' ? 'table-danger' : '')}}">
                                <td class="ps-4 fw-bold text-success">
                                    <a href="/order/show/{{ $order->id }}" class="text-decoration-none text-success">#{{ $order->id }}</a>
                                </td>
                                <td>
                                    <!-- Informações do Cliente -->
                                    <div class="fw-bold customer-info">
                                        {{ $order->customer->name ?? $order->customer_name }}
                                    </div>
                                    <small class="text-muted d-block customer-phone">
                                        <i class="bi bi-telephone-fill me-1"></i>{{ $order->customer->phone ?? 'Sem telefone' }}
                                    </small>
                                </td>
                                <td>
                                    @foreach($order->products as $product)
                                        <span class="badge bg-body-secondary text-body border fw-normal mb-1">
                                            {{ $product->pivot->quantity }}x {{ $product->product_name }}
                                        </span>
                                    @endforeach
                                    @if($order->notes)
                                        <i class="bi bi-info-circle-fill text-primary ms-1" data-bs-toggle="tooltip" title="{{ $order->notes }}"></i>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold text-success">R$ {{ number_format($order->total_price, 2, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $statusConfig = [
                                            'pending'   => ['class' => 'bg-warning text-dark', 'label' => 'Pendente'],
                                            'preparing' => ['class' => 'bg-info text-dark',    'label' => 'Em Preparo'],
                                            'shipped'   => ['class' => 'bg-primary', 'label' => 'Enviado'],
                                            'delivered' => ['class' => 'bg-success', 'label' => 'Entregue'],
                                            'canceled'  => ['class' => 'bg-danger',  'label' => 'Cancelado'],
                                        ];
                                        $current = $statusConfig[$order->status] ?? ['class' => 'bg-secondary', 'label' => $order->status];
                                    @endphp
                                    <span class="badge {{ $current['class'] }} status-badge py-2">{{ $current['label'] }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="/order/show/{{ $order->id }}" class="btn btn-sm btn-outline-primary" title="Ver Pedido"><i class="bi bi-eye"> </i> Ver Pedido</a>
                                        <a href="/order/edit/{{ $order->id }}" class="btn btn-sm btn-outline-success" title="Editar Pedido"><i class="bi bi-pencil-square"></i> Editar Pedido</a>
                                        @can('deletar-registros')
                                        <a href="/order/delete/{{ $order->id }}" class="btn btn-sm btn-outline-danger" title="Deletar Pedido"><i class="bi bi-trash"></i> Deletar Pedido</a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            @if($orders->isEmpty())
                            <tr class="empty-row">
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i> Nenhum pedido encontrado.
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
        // Inicializa as Tooltips do Bootstrap
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        // Toggle Tema
        const themeToggle = document.getElementById('themeToggle');
        const themeIcon = document.getElementById('themeIcon');
        themeToggle.addEventListener('click', () => {
            const html = document.documentElement;
            const current = html.getAttribute('data-bs-theme');
            const next = current === 'light' ? 'dark' : 'light';
            html.setAttribute('data-bs-theme', next);
            themeIcon.classList.toggle('bi-moon-fill');
            themeIcon.classList.toggle('bi-sun-fill');
        });

        // Lógica de Busca Aprimorada (Máscara Inteligente e Filtro)
        const searchInput = document.getElementById('searchInput');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                let val = this.value;

                // MÁSCARA INTELIGENTE: Só aplica formato de telefone se o primeiro caractere for número ou '('
                if (/^[\d(]/.test(val)) {
                    let num = val.replace(/\D/g, '');
                    if (num.length > 0) {
                        num = num.replace(/^(\d{2})(\d)/g, "($1) $2"); 
                        num = num.replace(/(\d)(\d{4})$/, "$1-$2"); 
                        val = num;
                    }
                    this.value = val; // Atualiza o input com a máscara
                }

                // FILTRAGEM DA TABELA
                const searchTerm = this.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");
                const searchPhone = searchTerm.replace(/\D/g, ''); 

                const rows = document.querySelectorAll('.order-row');

                rows.forEach(row => {
                    const nameEl = row.querySelector('.customer-info');
                    const phoneEl = row.querySelector('.customer-phone');
                    
                    const name = nameEl ? nameEl.textContent.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "") : '';
                    
                    const phoneRaw = phoneEl ? phoneEl.textContent : '';
                    const phone = phoneRaw.replace(/\D/g, ''); 
                    
                    if (name.includes(searchTerm) || (searchPhone && phone.includes(searchPhone))) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    </script>
</body>
</html>