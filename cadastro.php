<?php
session_start();

/* Se ja estiver logado, redirecionar para o dashboard */
if (isset($_SESSION['logado']) && $_SESSION['logado'] === true) {
    header('Location: dashboard.php');
    exit();
}

$tituloPagina = 'Cadastro';
$paginaAtiva = 'cadastro';
require_once 'includes/header.php';

/* Ler mensagem flash da sessao */
$mensagem = '';
$tipoMensagem = '';
if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    $tipoMensagem = isset($_SESSION['tipo_mensagem']) ? $_SESSION['tipo_mensagem'] : 'info';
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo_mensagem']);
}
?>

        <!-- Cadastro Section -->
        <section class="auth-section">
            <div class="container">
                <div class="auth-card auth-card-wide">
                    <div class="auth-header">
                        <i class="bi bi-person-plus"></i>
                        <h2>Criar Conta</h2>
                        <p>Preencha os dados para se cadastrar no Gaia List</p>
                    </div>

                    <?php if ($mensagem !== '') : ?>
                    <div class="alert alert-<?php echo htmlspecialchars($tipoMensagem); ?> alert-dismissible" role="alert">
                        <?php echo htmlspecialchars($mensagem); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
                    </div>
                    <?php endif; ?>

                    <form id="formCadastro" action="auth/cadastrar.php" method="POST" novalidate>
                        <!-- Nome -->
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="cadastroNome" name="nome"
                                   placeholder="Seu nome completo" required>
                            <label for="cadastroNome"><i class="bi bi-person"></i> Nome Completo</label>
                            <div class="invalid-feedback-custom"></div>
                        </div>

                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="cadastroEmail" name="email"
                                   placeholder="seu@email.com" required>
                            <label for="cadastroEmail"><i class="bi bi-envelope"></i> E-mail</label>
                            <div class="invalid-feedback-custom"></div>
                        </div>

                        <!-- Senha -->
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="cadastroSenha" name="senha"
                                   placeholder="Mínimo 8 caracteres" required minlength="8">
                            <label for="cadastroSenha"><i class="bi bi-lock"></i> Senha</label>
                            <div class="invalid-feedback-custom"></div>
                        </div>

                        <!-- Confirmar Senha -->
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="cadastroConfirmarSenha" name="confirmar_senha"
                                   placeholder="Repita sua senha" required>
                            <label for="cadastroConfirmarSenha"><i class="bi bi-lock-fill"></i> Confirmar Senha</label>
                            <div class="invalid-feedback-custom"></div>
                        </div>

                        <!-- Perfil -->
                        <div class="mb-3">
                            <label for="cadastroPerfil" class="form-label text-muted">
                                <i class="bi bi-shield-lock"></i> Perfil de Acesso
                            </label>
                            <select class="form-select" id="cadastroPerfil" name="perfil" required>
                                <option value="">Selecione um perfil</option>
                                <option value="editor">Editor - Permissões completas</option>
                                <option value="comentador">Comentador - Visualizar e comentar</option>
                                <option value="visualizador">Visualizador - Somente leitura</option>
                            </select>
                            <div class="invalid-feedback-custom"></div>
                        </div>

                        <!-- Botão Submit -->
                        <button type="submit" class="btn btn-gaia mt-2">
                            <i class="bi bi-person-plus"></i> Criar Conta
                        </button>
                    </form>

                    <div class="auth-footer">
                        Já possui uma conta? <a href="login.php">Faça login aqui</a>
                    </div>
                </div>
            </div>
        </section>

<?php require_once 'includes/footer.php'; ?>
