<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Ingrediente - Raízes do Brasil</title>
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
            font-size: 0.85rem;
        }
    </style>
</head>

<body class="bg-body-tertiary d-flex flex-column min-vh-100">

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
                        <span class="fw-medium text-white">{{ Auth::user()->name }}</span>
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

    <div class="container flex-grow-1">
        <div class="row justify-content-center">
            <div class="col-md-8">
                
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <p class="text-muted mb-0">Detalhes do ingrediente:</p>
                        <h2 class="fw-bold">{{$ingredient->ingredient_name}}</h2>
                    </div>
                    <a href="/ingredient" class="btn btn-outline-secondary shadow-sm">
                        <i class="bi bi-arrow-left me-1"></i> Voltar
                    </a>
                </div>

                <div class="card shadow-sm border-0 overflow-hidden">
                    <div class="card-header bg-success text-white py-3">
                        <h5 class="card-title mb-0"><i class="bi bi-info-circle me-2"></i>Informações Gerais</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="row g-4">
                            <div class="col-sm-6">
                                <label class="detail-label d-block">ID do Registro</label>
                                <span class="fs-5">#{{$ingredient->id}}</span>
                            </div>

                            <div class="col-sm-6">
                                <label class="detail-label d-block">Nome do Ingrediente</label>
                                <span class="fs-5 fw-medium">{{$ingredient->ingredient_name}}</span>
                            </div>

                            <div class="col-sm-6">
                                <label class="detail-label d-block">Categoria</label>
                                <span class="badge bg-light text-success border fs-6">
                                    <i class="bi bi-tag-fill me-1"></i> {{$ingredient->category->category_name}}
                                </span>
                            </div>

                            <!-- NOVO CAMPO: VALOR UNITÁRIO -->
                            <div class="col-sm-6">
                                <label class="detail-label d-block">Valor Unitário</label>
                                <span class="fs-5 fw-bold text-success">
                                    R$ {{ number_format($ingredient->ingredient_price, 2, ',', '.') }}
                                </span>
                            </div>

                            <div class="col-sm-6">
                                <label class="detail-label d-block">Quantidade em Estoque</label>
                                <span class="fs-5">{{$ingredient->ingredient_quantity}} unidades</span>
                            </div>

                            <div class="col-sm-6">
                                <label class="detail-label d-block">Data de Vencimento</label>
                                <span class="fs-5 text-danger fw-bold">
                                    <i class="bi bi-calendar-event me-1"></i>
                                    {{ date('d/m/Y', strtotime($ingredient->ingredient_due_date)) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    

                    <div class="card-footer bg-light p-3 d-flex justify-content-end gap-2">
                        <a href="/ingredient/edit/{{$ingredient->id}}" class="btn btn-success">
                            <i class="bi bi-pencil-square me-1"></i> Editar
                        </a>
                        @can('deletar-registros')
                        <a href="/ingredient/delete/{{$ingredient->id}}" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-1"></i> Excluir Registro
                        </a>
                        @endcan
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <footer class="bg-dark text-white py-4 mt-5">
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