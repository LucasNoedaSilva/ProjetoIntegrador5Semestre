<!DOCTYPE html>
<html lang="pt-BR" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meu Perfil - Raízes do Brasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .navbar-brand-center { position: absolute; left: 50%; transform: translateX(-50%); }
        @media (max-width: 991.98px) { .navbar-brand-center { position: static; transform: none; } }
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
    <div class="container flex-grow-1 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-7">
                
                <div class="mb-5 text-center">
                    <h2 class="fw-bold mb-0">Meu Perfil</h2>
                    <p class="text-muted">Gerencie as informações da sua conta e configurações de segurança.</p>
                </div>

                <!-- Formulário 1: Informações do Perfil -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold text-success"><i class="bi bi-person-vcard me-2"></i>Informações do Perfil</h4>
                            <p class="text-muted small mb-0">Atualize o nome e o endereço de e-mail da sua conta.</p>
                        </div>

                        <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                            @csrf
                        </form>

                        <form method="post" action="{{ route('profile.update') }}" class="mt-4">
                            @csrf
                            @method('patch')

                            <div class="mb-3">
                                <label for="name" class="form-label fw-semibold">Nome Completo</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name">
                                <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">Endereço de E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username">
                                <x-input-error class="text-danger small mt-1" :messages="$errors->get('email')" />
                            </div>

                            <div class="d-flex justify-content-center align-items-center gap-3 mt-5">
                                <button type="submit" class="btn btn-success px-4 py-2 fw-bold">
                                    <i class="bi bi-check2-circle me-2"></i>Salvar Alterações
                                </button>

                                @if (session('status') === 'profile-updated')
                                    <span class="text-success small fw-medium transition-fade">Salvo com sucesso.</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Formulário 2: Atualizar Senha -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body p-4 p-sm-5">
                        <div class="text-center mb-4">
                            <h4 class="fw-bold text-success"><i class="bi bi-shield-lock me-2"></i>Atualizar Senha</h4>
                            <p class="text-muted small mb-0">Certifique-se de usar uma senha longa e aleatória para se manter seguro.</p>
                        </div>

                        <form method="post" action="{{ route('password.update') }}" class="mt-4">
                            @csrf
                            @method('put')

                            <div class="mb-3">
                                <label for="update_password_current_password" class="form-label fw-semibold">Senha Atual</label>
                                <input type="password" class="form-control" id="update_password_current_password" name="current_password" autocomplete="current-password">
                                <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-danger small mt-1" />
                            </div>

                            <div class="mb-3">
                                <label for="update_password_password" class="form-label fw-semibold">Nova Senha</label>
                                <input type="password" class="form-control" id="update_password_password" name="password" autocomplete="new-password">
                                <x-input-error :messages="$errors->updatePassword->get('password')" class="text-danger small mt-1" />
                            </div>

                            <div class="mb-4">
                                <label for="update_password_password_confirmation" class="form-label fw-semibold">Confirmar Nova Senha</label>
                                <input type="password" class="form-control" id="update_password_password_confirmation" name="password_confirmation" autocomplete="new-password">
                                <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-danger small mt-1" />
                            </div>

                            <div class="d-flex justify-content-center align-items-center gap-3 mt-5">
                                <button type="submit" class="btn btn-success px-4 py-2 fw-bold">
                                    <i class="bi bi-key me-2"></i>Salvar Nova Senha
                                </button>

                                @if (session('status') === 'password-updated')
                                    <span class="text-success small fw-medium transition-fade">Senha atualizada.</span>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Formulário 3: Deletar Conta -->
                 @can('deletar-registros')
                <div class="card shadow-sm border-0 mb-4 border-top border-4 border-danger">
                    <div class="card-body p-4 p-sm-5 text-center">
                        <div class="mb-4">
                            <h4 class="fw-bold text-danger"><i class="bi bi-exclamation-triangle me-2"></i>Excluir Conta</h4>
                            <p class="text-muted small mb-0">Depois que sua conta for excluída, todos os seus dados serão excluídos permanentemente. Antes de excluir sua conta, baixe quaisquer dados ou informações que deseja reter.</p>
                        </div>

                        <button type="button" class="btn btn-outline-danger px-4 py-2 fw-bold mt-2" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                            Excluir Minha Conta Permanentemente
                        </button>
                    </div>
                </div>
                @endcan

            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
      
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content bg-body">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="modal-header border-bottom-0 pt-4 px-4">
                        <h5 class="modal-title fw-bold text-danger" id="confirmUserDeletionModalLabel">Tem certeza de que deseja excluir sua conta?</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    
                    <div class="modal-body px-4">
                        <p class="text-muted small mb-4">Depois que sua conta for excluída, todos os seus dados serão excluídos permanentemente. Digite sua senha para confirmar que deseja excluir sua conta.</p>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">Senha</label>
                            <input type="password" class="form-control border-danger" id="password" name="password" placeholder="Sua senha para confirmar" required>
                            <x-input-error :messages="$errors->userDeletion->get('password')" class="text-danger small mt-1" />
                        </div>
                    </div>
                    
                    <div class="modal-footer border-top-0 pb-4 px-4 d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-outline-secondary px-4" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger px-4">Excluir Conta</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>

    <!-- Rodapé -->
    <footer class="bg-dark text-white py-4 mt-auto">
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

            // Script para exibir o modal de exclusão automaticamente caso haja erro na senha
            @if($errors->userDeletion->get('password'))
                var deleteModal = new bootstrap.Modal(document.getElementById('confirmUserDeletionModal'));
                deleteModal.show();
            @endif
        });
    </script>
</body>
</html>