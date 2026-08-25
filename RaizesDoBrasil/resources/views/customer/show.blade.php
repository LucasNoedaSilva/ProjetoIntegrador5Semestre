<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Cliente - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center { position: absolute; left: 50%; transform: translateX(-50%); }
        @media (max-width: 991.98px) { .navbar-brand-center { position: static; transform: none; } }
        .info-label { font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
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
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0">Perfil do Cliente</h2>
                <p class="text-muted mb-0">Visualizando os dados cadastrais.</p>
            </div>
            <div>
                <a href="/customer/edit/{{ $customer->id }}" class="btn btn-primary me-2 shadow-sm">
                    <i class="bi bi-pencil-square me-1"></i> Editar Dados
                </a>
                <a href="/customer" class="btn btn-outline-secondary shadow-sm">
                    <i class="bi bi-arrow-left me-1"></i> Voltar
                </a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-success bg-gradient text-white p-4 text-center rounded-top">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white text-success rounded-circle mb-3 shadow" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-fill fs-1"></i>
                        </div>
                        <h3 class="fw-bold mb-0">{{ $customer->name }}</h3>
                        <p class="mb-0 text-white-50">Cliente #{{ $customer->id }}</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-success border-bottom pb-2 mb-4"><i class="bi bi-telephone-fill me-2"></i>Contato</h5>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <p class="text-muted info-label mb-1">Telefone / WhatsApp</p>
                                <p class="fs-5 fw-medium"><i class="bi bi-whatsapp text-success me-2"></i>{{ $customer->phone }}</p>
                            </div>
                        </div>

                        <h5 class="fw-bold text-success border-bottom pb-2 mb-4"><i class="bi bi-geo-alt-fill me-2"></i>Endereço de Entrega</h5>
                        <div class="row g-4">
                            <div class="col-md-8">
                                <p class="text-muted info-label mb-1">Logradouro</p>
                                <p class="fw-medium mb-0">{{ $customer->street }}, {{ $customer->number }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted info-label mb-1">Complemento</p>
                                <p class="fw-medium mb-0">{{ $customer->complement ?: 'Não informado' }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted info-label mb-1">Bairro</p>
                                <p class="fw-medium mb-0">{{ $customer->neighborhood }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted info-label mb-1">Cidade / UF</p>
                                <p class="fw-medium mb-0">{{ $customer->city }} / {{ $customer->state }}</p>
                            </div>
                            <div class="col-md-4">
                                <p class="text-muted info-label mb-1">CEP</p>
                                <p class="fw-medium mb-0">{{ $customer->cep }}</p>
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
    </script>
</body>
</html>