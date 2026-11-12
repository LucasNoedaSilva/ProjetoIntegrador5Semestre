<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sobre Nós - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center { position: absolute; left: 50%; transform: translateX(-50%); }
        @media (max-width: 991.98px) { .navbar-brand-center { position: static; transform: none; } }
        
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            color: white;
            padding: 120px 0;
            border-radius: 0 0 50px 50px;
        }

        .feature-icon-wrapper {
            width: 80px;
            height: 80px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin-bottom: 1.5rem;
        }

        .feature-icon {
            font-size: 2.2rem;
        }

        .about-img {
            object-fit: cover;
            height: 450px;
            width: 100%;
            border-radius: 30px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }

        .text-shadow {
            text-shadow: 2px 2px 10px rgba(0,0,0,0.5);
        }
        
        /* Ajuste para os cards no modo escuro */
        [data-bs-theme="dark"] .card {
            background-color: #2b3035;
        }
    </style>
</head>

<body class="bg-body-tertiary">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 position-relative shadow">
        <div class="container">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item"><a class="nav-link" href="/">Home</a></li>
                    <li class="nav-item"><a class="nav-link active" href="/aboutus">Sobre Nós</a></li>
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
                        <li><a class="dropdown-item py-2" href="{{ route('profile.edit') }}"><i class="bi bi-person me-2"></i>Perfil</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="m-0">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger py-2"><i class="bi bi-box-arrow-right me-2"></i>Sair</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section text-center mb-5 shadow-sm">
        <div class="container">
            <h1 class="display-2 fw-bold mb-3 text-shadow">Nossa História, Seu Sabor</h1>
            <p class="lead mb-0 fs-3 fw-light text-shadow">Onde a tradição e a alta gastronomia se encontram.</p>
        </div>
    </header>

    <main class="container">
        
        <!-- Bloco 1: Qualidade e Chefe -->
        <section class="row align-items-center py-5 g-5">
            <div class="col-lg-6">
                <img src="https://images.unsplash.com/photo-1583394293214-28ded15ee548?q=80&w=1978&auto=format&fit=crop" class="about-img" alt="Chefe de Cozinha">
            </div>
            <div class="col-lg-6">
                <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill mb-3 fw-bold">EXPERIÊNCIA ÚNICA</span>
                <h2 class="display-5 fw-bold mb-4 text-body">Mãos Profissionais, Sabores Reais</h2>
                <p class="text-body-secondary fs-5 lh-lg">No <strong>Raízes do Brasil</strong>, acreditamos que a boa comida começa com respeito. Cada prato é assinado por um <strong>chefe profissional</strong> dedicado a transformar ingredientes em experiências inesquecíveis.</p>
                <p class="text-body-secondary fs-5 lh-lg">Nossa cozinha opera sob os mais rigorosos padrões de higiene, garantindo que você receba uma refeição de altíssima qualidade, com o tempero autêntico que você merece.</p>
            </div>
        </section>

        <!-- Bloco 2: Cards de Diferenciais -->
        <section class="py-5">
            <div class="row g-4">
                <!-- Card: Ingredientes (Ícone de Prato alterado) -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <div class="feature-icon-wrapper bg-warning bg-opacity-10 text-warning mx-auto">
                            <!-- Ícone alterado para refeição/prato -->
                            <i class="bi bi-egg-fried feature-icon"></i>
                        </div>
                        <h4 class="fw-bold text-body">Ingredientes Selecionados</h4>
                        <p class="text-body-secondary">Insumos de alta qualidade, selecionados manualmente para garantir o frescor absoluto em cada prato servido.</p>
                    </div>
                </div>
                <!-- Card: Eco-Embalagens -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <div class="feature-icon-wrapper bg-success bg-opacity-10 text-success mx-auto">
                            <i class="bi bi-box-seam-fill feature-icon"></i>
                        </div>
                        <h4 class="fw-bold text-body">Embalagens Premium</h4>
                        <p class="text-body-secondary">Embalagens de ótima qualidade que preservam a temperatura e o sabor, pensadas sempre no respeito ao meio ambiente.</p>
                    </div>
                </div>
                <!-- Card: Entrega -->
                <div class="col-md-4">
                    <div class="card h-100 border-0 shadow-sm p-4 text-center">
                        <div class="feature-icon-wrapper bg-info bg-opacity-10 text-info mx-auto">
                            <i class="bi bi-bicycle feature-icon"></i>
                        </div>
                        <h4 class="fw-bold text-body">Chega Rápido</h4>
                        <p class="text-body-secondary">Logística inteligente para que sua comida fresquinha chegue no seu endereço com a rapidez que sua fome exige.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bloco 3: Imagem Grande com Mensagem -->
        <section class="py-5 mb-5">
            <div class="position-relative overflow-hidden rounded-5 shadow-lg">
                <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=2070&auto=format&fit=crop" class="w-100" style="height: 400px; object-fit: cover; filter: brightness(0.6);" alt="Comida Fresca">
                <div class="position-absolute top-50 start-50 translate-middle text-white text-center w-75">
                    <h2 class="display-4 fw-bold mb-3 text-shadow">Sempre Fresquinho, Sempre Pronto</h2>
                    <p class="fs-4 fw-light text-shadow">Direto do nosso fogão para a sua mesa, com todo carinho da nossa equipe.</p>
                </div>
            </div>
        </section>

    </main>

    <footer class="bg-dark text-white py-5 mt-5">
        <div class="container text-center">
            <h5 class="fw-bold mb-3">Raízes do Brasil</h5>
            <p class="mb-0 text-white-50">© 2026 Todos os direitos reservados.</p>
            <p class="small text-white-50">Qualidade e Sustentabilidade em cada pedido.</p>
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