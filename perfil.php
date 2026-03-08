<?php
$tituloPagina = 'Meu Perfil';
$paginaAtiva = 'perfil';
require_once 'includes/header_privado.php';

/* Dados simulados */
$usuario = array(
    'id' => 1,
    'nome' => isset($_SESSION['nome']) ? $_SESSION['nome'] : 'João Silva',
    'email' => isset($_SESSION['email']) ? $_SESSION['email'] : 'joao@email.com',
    'perfil' => isset($_SESSION['perfil']) ? $_SESSION['perfil'] : 'editor',
    'data_cadastro' => '01/03/2026'
);
?>

        <!-- Perfil -->
        <section class="page-section">
            <div class="container">

                <!-- Cabeçalho -->
                <div class="page-header">
                    <div>
                        <h2><i class="bi bi-person-circle"></i> Meu Perfil</h2>
                        <p class="text-muted">Visualize e edite suas informações pessoais</p>
                    </div>
                </div>

                <div class="row g-4">

                    <!-- Info do Perfil -->
                    <div class="col-lg-4">
                        <div class="perfil-card-info">
                            <div class="perfil-avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <h4><?php echo $usuario['nome']; ?></h4>
                            <p class="text-muted"><?php echo $usuario['email']; ?></p>
                            <span class="nav-perfil-badge perfil-badge-grande">
                                <?php echo $usuario['perfil']; ?>
                            </span>
                            <div class="perfil-meta mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-calendar3"></i> Membro desde <?php echo $usuario['data_cadastro']; ?>
                                </small>
                            </div>
                        </div>
                    </div>

                    <!-- Formulário Editar Perfil -->
                    <div class="col-lg-8">

                        <!-- Dados Pessoais -->
                        <div class="perfil-form-card mb-4">
                            <h5><i class="bi bi-pencil-square"></i> Editar Dados</h5>
                            <form id="formEditarPerfil" action="acoes/perfil_atualizar.php" method="POST">
                                <div class="mb-3">
                                    <label for="perfilNome" class="form-label">Nome Completo</label>
                                    <input type="text" class="form-control" id="perfilNome" name="nome"
                                           value="<?php echo $usuario['nome']; ?>" required>
                                    <div class="invalid-feedback-custom"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="perfilEmail" class="form-label">E-mail</label>
                                    <input type="email" class="form-control" id="perfilEmail" name="email"
                                           value="<?php echo $usuario['email']; ?>" required>
                                    <div class="invalid-feedback-custom"></div>
                                </div>
                                <button type="submit" class="btn btn-gaia-primary">
                                    <i class="bi bi-check-lg"></i> Salvar Alterações
                                </button>
                            </form>
                        </div>

                        <!-- Alterar Senha -->
                        <div class="perfil-form-card">
                            <h5><i class="bi bi-lock"></i> Alterar Senha</h5>
                            <form id="formAlterarSenha" action="acoes/perfil_senha.php" method="POST">
                                <div class="mb-3">
                                    <label for="senhaAtual" class="form-label">Senha Atual</label>
                                    <input type="password" class="form-control" id="senhaAtual" name="senha_atual"
                                           placeholder="Informe sua senha atual" required>
                                    <div class="invalid-feedback-custom"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="senhaNova" class="form-label">Nova Senha</label>
                                    <input type="password" class="form-control" id="senhaNova" name="senha_nova"
                                           placeholder="Mínimo 8 caracteres" required>
                                    <div class="invalid-feedback-custom"></div>
                                </div>
                                <div class="mb-3">
                                    <label for="senhaConfirmar" class="form-label">Confirmar Nova Senha</label>
                                    <input type="password" class="form-control" id="senhaConfirmar" name="senha_confirmar"
                                           placeholder="Repita a nova senha" required>
                                    <div class="invalid-feedback-custom"></div>
                                </div>
                                <button type="submit" class="btn btn-gaia-primary">
                                    <i class="bi bi-lock"></i> Alterar Senha
                                </button>
                            </form>
                        </div>

                    </div>
                </div>

            </div>
        </section>

<?php require_once 'includes/footer.php'; ?>
