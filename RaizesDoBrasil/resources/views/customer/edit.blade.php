<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente - Raízes do Brasil</title>
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
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h2 class="fw-bold mb-0">Editar Cliente</h2>
                <p class="text-muted mb-0">Alterando os dados do cliente: <strong class="text-success">{{ $customer->name }}</strong></p>
            </div>
            <a href="/customer" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Voltar
            </a>
        </div>

        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        
                        <form action="/customer/update/{{ $customer->id }}" method="POST">
                            @csrf
                            
                            <h5 class="fw-bold text-success mb-3"><i class="bi bi-person-badge me-2"></i>Dados Pessoais</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-8">
                                    <label class="form-label fw-semibold">Nome Completo <span class="text-danger">*</span></label>
                                    <input type="text" name="name" class="form-control border-success" value="{{ $customer->name }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Telefone/WhatsApp <span class="text-danger">*</span></label>
                                    <input type="text" id="phone" name="phone" class="form-control border-success" value="{{ $customer->phone }}" required maxlength="15">
                                </div>
                            </div>

                            <hr class="text-muted mb-4">

                            <h5 class="fw-bold text-success mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Endereço</h5>
                            <div class="row g-3 mb-4">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">CEP <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text" id="cep" name="cep" class="form-control" value="{{ $customer->cep }}" required>
                                        <button type="button" class="btn btn-outline-success" id="btnBuscaCep"><i class="bi bi-search"></i></button>
                                    </div>
                                    <small id="cepFeedback" class="text-danger" style="display:none;">CEP não encontrado.</small>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Rua/Logradouro <span class="text-danger">*</span></label>
                                    <input type="text" id="logradouro" name="street" class="form-control" value="{{ $customer->street }}" required>
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Número <span class="text-danger">*</span></label>
                                    <input type="text" id="numero" name="number" class="form-control" value="{{ $customer->number }}" required>
                                </div>
                                
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Complemento</label>
                                    <input type="text" id="complemento" name="complement" class="form-control" value="{{ $customer->complement }}" placeholder="Apto, Casa 2...">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Bairro <span class="text-danger">*</span></label>
                                    <input type="text" id="bairro" name="neighborhood" class="form-control" value="{{ $customer->neighborhood }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label fw-semibold">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" id="cidade" name="city" class="form-control" value="{{ $customer->city }}" readonly required>
                                </div>
                                <div class="col-md-1">
                                    <label class="form-label fw-semibold">UF <span class="text-danger">*</span></label>
                                    <input type="text" id="uf" name="state" class="form-control" value="{{ $customer->state }}" readonly required>
                                </div>
                            </div>

                            <div class="d-grid gap-2 mt-4 pt-2">
                                <button type="submit" class="btn btn-success btn-lg fw-bold">
                                    <i class="bi bi-save me-2"></i> Salvar Alterações
                                </button>
                                <a href="/customer" class="btn btn-outline-danger btn-lg fw-bold">
                                    <i class="bi bi-x-circle me-2"></i> Cancelar
                                </a>
                            </div>

                        </form>

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

        // Máscara de Telefone
        document.getElementById('phone').addEventListener('input', function(e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length > 0) {
                val = val.replace(/^(\d{2})(\d)/g, "($1) $2"); 
                val = val.replace(/(\d)(\d{4})$/, "$1-$2"); 
            }
            e.target.value = val;
        });

        // Máscara de CEP
        const inputCep = document.getElementById('cep');
        inputCep.addEventListener('input', function(e) {
            let val = e.target.value.replace(/\D/g, '');
            if (val.length > 5) val = val.substring(0,5) + '-' + val.substring(5,8);
            e.target.value = val;
        });

        // Lógica da API do ViaCEP
        function buscarCep() {
            let cepVal = inputCep.value.replace(/\D/g, ''); 
            const feedbackCep = document.getElementById('cepFeedback');
            
            if (cepVal.length === 8) {
                feedbackCep.style.display = 'none';
                fetch(`https://viacep.com.br/ws/${cepVal}/json/`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.erro) {
                            document.getElementById('logradouro').value = data.logradouro;
                            document.getElementById('bairro').value = data.bairro;
                            document.getElementById('cidade').value = data.localidade;
                            document.getElementById('uf').value = data.uf;
                            document.getElementById('numero').focus(); // Joga o cursor pro número
                        } else {
                            feedbackCep.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        feedbackCep.style.display = 'block';
                        feedbackCep.innerText = "Erro ao buscar CEP.";
                    });
            }
        }

        document.getElementById('btnBuscaCep').addEventListener('click', buscarCep);
        inputCep.addEventListener('blur', buscarCep);
    </script>
</body>
</html>