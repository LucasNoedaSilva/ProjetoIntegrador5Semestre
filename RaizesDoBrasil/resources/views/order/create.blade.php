<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Pedido - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center { position: absolute; left: 50%; transform: translateX(-50%); }
        @media (max-width: 991.98px) { .navbar-brand-center { position: static; transform: none; } }
        .total-card { background-color: #198754; color: white; border-radius: 12px; transition: all 0.3s ease; }
        .table-active-success { background-color: rgba(25, 135, 84, 0.1) !important; }
        /* Classe para o mouse virar mãozinha na lista suspensa */
        .cursor-pointer { cursor: pointer; }
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
        <form action="/order/store" method="POST" id="orderForm">
            @csrf
            
            <div class="row g-4">
                <!-- Coluna da Esquerda (Informações do Cliente) -->
                <div class="col-lg-5">
                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-header bg-transparent py-3 border-bottom">
                            <h5 class="mb-0 fw-bold text-success"><i class="bi bi-person-badge me-2"></i>Informações do Cliente</h5>
                        </div>
                        <div class="card-body">
                            
                            <!-- BARRA DE BUSCA DE CLIENTES -->
                            <div class="mb-4 position-relative">
                                <label class="form-label fw-bold text-success"><i class="bi bi-search me-1"></i>Buscar Cliente Cadastrado</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success-subtle border-success text-success"><i class="bi bi-telephone"></i></span>
                                    <input type="text" id="searchCustomer" class="form-control border-success border-start-0" placeholder="Digite o telefone ou nome...">
                                </div>
                                <ul id="customerDropdown" class="list-group position-absolute w-100 shadow" style="z-index: 1050; display: none; max-height: 250px; overflow-y: auto; top: 100%;">
                                </ul>
                            </div>

                            <hr class="my-4 text-secondary border-dashed">

                            <!-- NOME E TELEFONE -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Nome do Cliente <span class="text-danger">*</span></label>
                                <input type="text" id="customer_name" name="customer_name" class="form-control" placeholder="Digite o nome completo" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Telefone/WhatsApp <span class="text-danger">*</span></label>
                                <input type="text" id="customer_phone" name="customer_phone" class="form-control" placeholder="(00) 00000-0000" maxlength="15" required>
                            </div>

                            <hr class="my-4 text-secondary">
                            <h6 class="fw-bold mb-3">Endereço de Entrega</h6>

                            <!-- CEP E BUSCA -->
                            <div class="mb-3">
                                <label class="form-label fw-semibold">CEP <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <input type="text" id="cep" name="customer_cep" class="form-control" placeholder="00000-000" maxlength="9" required>
                                    <button type="button" class="btn btn-outline-success" id="btnBuscaCep">
                                        <i class="bi bi-search"></i> Buscar
                                    </button>
                                </div>
                                <div id="cepFeedback" class="form-text text-danger" style="display: none;">CEP não encontrado.</div>
                            </div>

                            <!-- CAMPOS PREENCHIDOS PELA API OU BUSCA -->
                            <div class="row">
                                <div class="col-8 mb-3">
                                    <label class="form-label fw-semibold">Rua/Logradouro <span class="text-danger">*</span></label>
                                    <input type="text" id="logradouro" name="customer_street" class="form-control" required>
                                </div>
                                <div class="col-4 mb-3">
                                    <label class="form-label fw-semibold">Número <span class="text-danger">*</span></label>
                                    <input type="text" id="numero" name="customer_number" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-semibold">Complemento <span class="text-muted fw-normal">(Opcional)</span></label>
                                <input type="text" id="complemento" name="customer_complement" class="form-control" placeholder="Apto, Bloco, Casa 2...">
                            </div>
                            <div class="row">
                                <div class="col-md-5 mb-3">
                                    <label class="form-label fw-semibold">Bairro <span class="text-danger">*</span></label>
                                    <input type="text" id="bairro" name="customer_neighborhood" class="form-control" required>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label fw-semibold">Cidade <span class="text-danger">*</span></label>
                                    <input type="text" id="cidade" name="customer_city" class="form-control" readonly required>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <label class="form-label fw-semibold">UF <span class="text-danger">*</span></label>
                                    <input type="text" id="uf" name="customer_state" class="form-control" readonly required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm border-0 mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-semibold">Status Inicial</label>
                                    <select name="order_status" class="form-select border-success" required>
                                        <option value="preparing">Em Preparo</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                <label class="form-label fw-semibold">Data do Pedido</label>
                                <!-- Campo visível para o usuário (NÃO é enviado ao form) -->
                                <input type="text" id="orderDateVisible" class="form-control" readonly>
                                
                                <!-- Campo invisível que será salvo no banco de dados -->
                                <input type="hidden" id="orderDateDb" name="order_date">
                            </div>
                            </div>
                            <label class="form-label fw-semibold">Observações do Pedido <span class="text-muted fw-normal">(Opcional)</span></label>
                            <textarea name="notes" class="form-control" rows="2" placeholder="Ex: Sem cebola, troco para 50..."></textarea>
                        </div>
                    </div>
                </div>

                <!-- Coluna da Direita (Cardápio e Finalização) -->
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 h-100">
                        <div class="card-header bg-transparent py-3 d-flex justify-content-between align-items-center border-bottom">
                            <h5 class="mb-0 fw-bold text-success"><i class="bi bi-box-seam me-2"></i>Cardápio </h5>
                            <span class="badge bg-success-subtle text-success border border-success-subtle">Selecione os itens</span>
                        </div>
                        <div class="card-body p-0">
                            @php
                                $inventory = []; $ingNames = []; $recipes = [];
                                foreach($products as $product) {
                                    $recipes[$product->id] = [];
                                    foreach($product->ingredients as $ingredient) {
                                        $recipes[$product->id][$ingredient->id] = $ingredient->pivot->amount;
                                        $inventory[$ingredient->id] = $ingredient->ingredient_quantity;
                                        $ingNames[$ingredient->id] = $ingredient->ingredient_name;
                                    }
                                }
                            @endphp
                            <div class="table-responsive" style="max-height: 450px; overflow-y: auto;">
                                <table class="table table-hover align-middle mb-0" id="orderTable">
                                    <thead class="table-success sticky-top">
                                        <tr>
                                            <th class="text-center" style="width: 60px;">Sel.</th>
                                            <th>Produto</th>
                                            <th style="width: 120px;">Preço</th>
                                            <th style="width: 100px;" class="pe-3">Qtd.</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $product)
                                            @php
                                                $isAvailable = true; $reason = '';
                                                foreach($product->ingredients as $ingredient) {
                                                    if ($ingredient->ingredient_quantity < $ingredient->pivot->amount) {
                                                        $isAvailable = false; $reason = 'Ingredientes Insuficientes'; break;
                                                    }
                                                    if (\Carbon\Carbon::parse($ingredient->ingredient_due_date)->startOfDay()->lt(\Carbon\Carbon::now()->startOfDay())) {
                                                        $isAvailable = false; $reason = 'Ingredientes Vencidos'; break;
                                                    }
                                                }
                                            @endphp
                                        <tr class="product-row {{ !$isAvailable ? 'bg-light' : '' }}">
                                            <td class="text-center">
                                                <input class="form-check-input border-success product-check" type="checkbox" name="products[{{ $product->id }}][selected]" value="{{ $product->id }}" data-price="{{ $product->product_price }}" {{ !$isAvailable ? 'disabled' : '' }}>
                                            </td>
                                            <td>
                                                <div class="fw-bold {{ !$isAvailable ? 'text-muted opacity-75' : '' }}">
                                                    {{ $product->product_name }}
                                                    @if(!$isAvailable)<span class="badge bg-danger ms-2" style="font-size: 0.65rem;">{{ $reason }}</span>@endif
                                                </div>
                                            </td>
                                            <td class="text-success fw-bold {{ !$isAvailable ? 'text-muted opacity-50' : '' }}">
                                                R$ {{ number_format($product->product_price, 2, ',', '.') }}
                                            </td>
                                            <td class="pe-3">
                                                <input type="number" name="products[{{ $product->id }}][quantity]" class="form-control form-control-sm product-qty" value="1" min="1" disabled>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent p-4 border-top">
                            <div class="total-card p-3 shadow-sm d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="text-white-50 small d-block text-uppercase fw-bold">TOTAL DO PEDIDO</span>
                                    <h2 class="mb-0 fw-bold" id="totalDisplay">R$ 0,00</h2>
                                </div>
                                <i class="bi bi-cash-stack fs-1 text-white-50"></i>
                            </div>
                            <input type="hidden" name="total_price" id="totalValue" value="0">
                            
                            <!-- Alerta de Estoque e Seleção de Prato -->
                            <div id="stockError" class="alert alert-danger mt-3 mb-0 py-2 text-center shadow-sm" style="display:none; font-size: 0.9rem;"></div>
                            <div id="productError" class="alert alert-danger mt-3 mb-0 py-2 text-center shadow-sm" style="display:none; font-size: 0.9rem;">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Selecione pelo menos um prato para realizar o pedido.
                            </div>
                            
                            <div class="d-grid gap-2 mt-4">
                                <button type="submit" id="submitOrderBtn" class="btn btn-success btn-lg fw-bold">
                                    <i class="bi bi-check-circle me-2"></i>Finalizar Pedido
                                </button>
                                <a href="/order" class="btn btn-outline-danger btn-lg fw-bold">
                                   <i class="bi bi-x-circle me-2"></i>Cancelar Pedido
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            
            // --- HORA EXATA DO COMPUTADOR (EM TEMPO REAL) ---
            // --- HORA EXATA DO COMPUTADOR (EM TEMPO REAL) ---
function updateDateTime() {
    const now = new Date();
    
    const day = String(now.getDate()).padStart(2, '0');
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const year = now.getFullYear();
    
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');
    
    // Formato Brasileiro para o usuário ver (Ex: 21/05/2026 às 14:30:00)
    const formattedDate = `${day}/${month}/${year} às ${hours}:${minutes}:${seconds}`;
    
    // Formato Americano para o Banco de Dados (Ex: 2026-05-21 14:30:00)
    const dbDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    
    const visibleField = document.getElementById('orderDateVisible');
    const dbField = document.getElementById('orderDateDb');
    
    if (visibleField && dbField) {
        visibleField.value = formattedDate;
        dbField.value = dbDate;
    }
}
updateDateTime();
setInterval(updateDateTime, 1000); // Atualiza a cada 1 segundo

            // --- 0. LÓGICA DA BUSCA DE CLIENTES EXISTENTES E MÁSCARA DE TELEFONE ---
            const searchCustomerInput = document.getElementById('searchCustomer');
            const customerDropdown = document.getElementById('customerDropdown');
            const customerPhoneInput = document.getElementById('customer_phone');
            const customersData = {!! json_encode($customers ?? []) !!};

            // Máscara de Telefone (00) 00000-0000
            function maskPhone(value) {
                if (!value) return "";
                value = value.replace(/\D/g, ''); 
                value = value.replace(/^(\d{2})(\d)/g, "($1) $2"); 
                value = value.replace(/(\d)(\d{4})$/, "$1-$2"); 
                return value;
            }

            customerPhoneInput.addEventListener('input', function(e) {
                e.target.value = maskPhone(e.target.value);
            });

            searchCustomerInput.addEventListener('input', function(e) {
                e.target.value = maskPhone(e.target.value);
                const val = e.target.value.toLowerCase().trim();
                
                customerDropdown.innerHTML = ''; 
                
                if (val.length < 2) {
                    customerDropdown.style.display = 'none';
                    return;
                }

                const filtered = customersData.filter(c => 
                    (c.phone && c.phone.toLowerCase().includes(val)) || 
                    (c.name && c.name.toLowerCase().includes(val))
                );

                if (filtered.length > 0) {
                    filtered.forEach(c => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item list-group-item-action cursor-pointer d-flex justify-content-between align-items-center';
                        li.innerHTML = `<div><i class="bi bi-person-circle me-2 text-muted"></i><strong>${c.name}</strong></div> <small class="text-success fw-medium">${c.phone}</small>`;
                        
                        li.addEventListener('click', () => {
                            document.getElementById('customer_name').value = c.name || '';
                            document.getElementById('customer_phone').value = maskPhone(c.phone || '');
                            document.getElementById('cep').value = c.cep || '';
                            document.getElementById('logradouro').value = c.street || '';
                            document.getElementById('numero').value = c.number || '';
                            document.getElementById('complemento').value = c.complement || '';
                            document.getElementById('bairro').value = c.neighborhood || '';
                            document.getElementById('cidade').value = c.city || '';
                            document.getElementById('uf').value = c.state || '';
                            
                            customerDropdown.style.display = 'none'; 
                            searchCustomerInput.value = ''; 
                        });
                        
                        customerDropdown.appendChild(li);
                    });
                    customerDropdown.style.display = 'block';
                } else {
                    customerDropdown.style.display = 'none';
                }
            });

            document.addEventListener('click', function(e) {
                if (e.target !== searchCustomerInput && e.target !== customerDropdown) {
                    customerDropdown.style.display = 'none';
                }
            });


            // --- 1. LÓGICA DA API DE CEP (VIACEP) ---
            const inputCep = document.getElementById('cep');
            const btnBuscaCep = document.getElementById('btnBuscaCep');
            const feedbackCep = document.getElementById('cepFeedback');

            function buscarCep() {
                let cepVal = inputCep.value.replace(/\D/g, ''); 
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
                                document.getElementById('numero').focus();
                            } else {
                                feedbackCep.style.display = 'block';
                                limparCamposCep();
                            }
                        })
                        .catch(error => {
                            feedbackCep.style.display = 'block';
                            feedbackCep.innerText = "Erro na API de busca.";
                        });
                }
            }

            function limparCamposCep() {
                document.getElementById('logradouro').value = '';
                document.getElementById('bairro').value = '';
                document.getElementById('cidade').value = '';
                document.getElementById('uf').value = '';
            }

            btnBuscaCep.addEventListener('click', buscarCep);
            inputCep.addEventListener('blur', buscarCep);

            inputCep.addEventListener('input', function(e) {
                let val = e.target.value.replace(/\D/g, '');
                if (val.length > 5) val = val.substring(0,5) + '-' + val.substring(5,8);
                e.target.value = val;
            });


            // --- 2. LÓGICA DO CARDÁPIO, ESTOQUE, TEMA E VALIDAÇÃO DE SUBMIT ---
            const themeToggle = document.getElementById('themeToggle');
            const html = document.documentElement;
            themeToggle.addEventListener('click', () => {
                const current = html.getAttribute('data-bs-theme');
                const next = current === 'light' ? 'dark' : 'light';
                html.setAttribute('data-bs-theme', next);
                document.getElementById('themeIcon').classList.toggle('bi-sun-fill');
            });

            const checks = document.querySelectorAll('.product-check');
            const qtys = document.querySelectorAll('.product-qty');
            const totalDisplay = document.getElementById('totalDisplay');
            const totalValueInput = document.getElementById('totalValue');
            const submitBtn = document.getElementById('submitOrderBtn');
            const stockError = document.getElementById('stockError');
            const productError = document.getElementById('productError');
            const orderForm = document.getElementById('orderForm');

            const inventory = {!! json_encode($inventory) !!};
            const recipes = {!! json_encode($recipes) !!};
            const ingNames = {!! json_encode($ingNames) !!};

            function calculateAndValidate() {
                let total = 0; let currentUsage = {}; let stockSufficient = true; let missingIngredients = new Set();
                let hasCheckedProduct = false;

                checks.forEach((check, i) => {
                    const row = check.closest('tr');
                    if (check.checked) {
                        hasCheckedProduct = true;
                        qtys[i].disabled = false;
                        row.classList.add('table-active-success');
                        const price = parseFloat(check.dataset.price);
                        const qty = parseInt(qtys[i].value) || 1;
                        total += price * qty;
                        
                        const recipe = recipes[check.value];
                        if (recipe) {
                            for (const [ingId, amountReq] of Object.entries(recipe)) {
                                currentUsage[ingId] = (currentUsage[ingId] || 0) + (amountReq * qty);
                            }
                        }
                    } else {
                        qtys[i].disabled = true;
                        row.classList.remove('table-active-success');
                    }
                });

                if (hasCheckedProduct) {
                    productError.style.display = 'none';
                }

                for (const [ingId, used] of Object.entries(currentUsage)) {
                    if (used > inventory[ingId]) {
                        stockSufficient = false; missingIngredients.add(ingNames[ingId]);
                    }
                }

                totalDisplay.innerText = total.toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
                totalValueInput.value = total.toFixed(2);

                if (!stockSufficient) {
                    submitBtn.disabled = true;
                    stockError.innerHTML = "<i class='bi bi-exclamation-triangle-fill me-1'></i> Estoque insuficiente: " + Array.from(missingIngredients).join(', ');
                    stockError.style.display = 'block';
                } else {
                    submitBtn.disabled = false;
                    stockError.style.display = 'none';
                }
            }
            
            checks.forEach(c => c.addEventListener('change', calculateAndValidate));
            qtys.forEach(q => q.addEventListener('input', calculateAndValidate));

            // VALIDAÇÃO ANTES DO ENVIO (Impede enviar sem prato)
            orderForm.addEventListener('submit', function(event) {
                let hasCheckedProduct = false;
                
                for (let i = 0; i < checks.length; i++) {
                    if (checks[i].checked) {
                        hasCheckedProduct = true;
                        break;
                    }
                }

                if (!hasCheckedProduct) {
                    event.preventDefault(); // Impede o envio
                    productError.style.display = 'block'; // Mostra o alerta
                    
                    productError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            });
        });
    </script>
</body>
</html>