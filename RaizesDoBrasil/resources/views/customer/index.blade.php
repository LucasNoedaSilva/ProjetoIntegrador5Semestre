<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center { position: absolute; left: 50%; transform: translateX(-50%); }
        @media (max-width: 991.98px) { .navbar-brand-center { position: static; transform: none; } }
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
                    <button class="btn btn-outline-light dropdown-toggle border-0 d-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-person-circle text-success fs-5"></i>
                        <span class="fw-medium text-white">{{ Auth::user()->name ?? 'Usuário' }}</span>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div class="container flex-grow-1 pb-5">
       <div class="row align-items-end mb-4 g-3">
            <div class="col-md-5">
                <h2 class="fw-bold mb-0">Clientes Cadastrados</h2>
                <p class="text-muted mb-0">Listagem de todos os clientes.</p>
            </div>
            
            <div class="col-md-4">
                <label class="form-label fw-bold text-success"><i class="bi bi-search me-1"></i>Buscar Cliente</label>
                <div class="input-group shadow-sm">
                    <span class="input-group-text bg-success-subtle border-success text-success"><i class="bi bi-search"></i></span>
                    <input type="text" id="searchInput" class="form-control border-success border-start-0" placeholder="Digite o nome ou telefone...">
                </div>
            </div>

            <div class="col-md-3 text-md-end pb-1">
                <a href="/customer/create" class="btn btn-success shadow-sm w-100">
                    <i class="bi bi-plus-lg me-1"></i> Novo Cliente
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle mb-0">
                        <thead class="table-success">
                            <tr>
                                <th class="ps-4">Nome</th>
                                <th>Telefone</th>
                                <th>Endereço Completo</th>
                                <th>Cidade / UF</th>
                                <th class="text-end pe-4">Ações</th> </tr>
                        </thead>
                        <tbody>
                            @foreach($customers as $customer)
                            <tr class="customer-row">
                                <td class="ps-4 fw-bold text-body">
                                    <i class="bi bi-person-fill me-2 text-muted"></i>
                                    <span class="text-muted fw-normal me-1">#{{ $customer->id }}</span> 
                                    <span class="customer-name">{{ $customer->name }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success-subtle text-success border border-success-subtle" style="font-size: 0.9rem;">
                                        <i class="bi bi-whatsapp me-1"></i> 
                                        <span class="customer-phone">{{ $customer->phone }}</span>
                                    </span>
                                </td>
                                <td class="text-muted small">
                                    {{ $customer->street }}, {{ $customer->number }} 
                                    {{ $customer->complement ? '- ' . $customer->complement : '' }} <br>
                                    Bairro: {{ $customer->neighborhood }} (CEP: {{ $customer->cep }})
                                </td>
                                <td>
                                    <span class="fw-medium">{{ $customer->city }}</span> / {{ $customer->state }}
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group">
                                        <a href="/customer/show/{{ $customer->id }}" class="btn btn-sm btn-outline-primary" title="Ver Cliente"><i class="bi bi-eye"> </i> Ver Cliente</a>
                                        <a href="/customer/edit/{{ $customer->id }}" class="btn btn-sm btn-outline-success" title="Editar Cliente"><i class="bi bi-pencil-square"></i> Editar Cliente</a>
                                       @can('deletar-registros')
                                        <a href="/customer/delete/{{ $customer->id }}" 
                                        class="btn btn-sm btn-outline-danger" 
                                        title="Deletar Cliente"
                                        onclick="return confirm('Tem certeza que deseja remover o cliente {{ $customer->name }}? Esta ação não pode ser desfeita.');">
                                            <i class="bi bi-trash"></i> Deletar Cliente
                                        </a>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            @if($customers->isEmpty())
                            <tr class="empty-row">
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-2"></i> Nenhum cliente cadastrado ainda.
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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

        // Lógica de Busca Aprimorada e Segura
        const searchInput = document.getElementById('searchInput');
        
        if (searchInput) {
            searchInput.addEventListener('input', function() {
                let val = this.value;

                // MÁSCARA: Aplica formato apenas se começar digitando números
                if (/^[\d(]/.test(val)) {
                    let num = val.replace(/\D/g, ''); 
                    if (num.length > 0) {
                        num = num.replace(/^(\d{2})(\d)/g, "($1) $2"); 
                        num = num.replace(/(\d)(\d{4})$/, "$1-$2"); 
                        val = num;
                    }
                    this.value = val;
                }

                // Prepara os dados digitados para pesquisa
                const searchTerm = this.value.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "");
                const searchPhone = this.value.replace(/\D/g, ''); 

                const rows = document.querySelectorAll('.customer-row');

                rows.forEach(row => {
                    const nameEl = row.querySelector('.customer-name');
                    const phoneEl = row.querySelector('.customer-phone');
                    
                    const name = nameEl ? nameEl.textContent.toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, "") : '';
                    const phone = phoneEl ? phoneEl.textContent.replace(/\D/g, '') : '';
                    
                    let matchName = name.includes(searchTerm);
                    let matchPhone = searchPhone.length > 0 && phone.includes(searchPhone);
                    
                    if (matchName || matchPhone) {
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