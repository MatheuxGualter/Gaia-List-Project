<?php
$tituloPagina = 'Login';
$paginaAtiva = 'login';
require_once 'includes/header.php';
?>

        <!-- Login Section -->
        <section class="auth-section">
            <div class="container">
                <div class="auth-card">
                    <div class="auth-header">
                        <i class="bi bi-box-arrow-in-right"></i>
                        <h2>Entrar</h2>
                        <p>Acesse sua conta no Gaia List</p>
                    </div>

                    <form id="formLogin" action="auth/login.php" method="POST">
                        <!-- Email -->
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="loginEmail" name="email"
                                   placeholder="seu@email.com" required>
                            <label for="loginEmail"><i class="bi bi-envelope"></i> E-mail</label>
                            <div class="invalid-feedback-custom"></div>
                        </div>

                        <!-- Senha -->
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="loginSenha" name="senha"
                                   placeholder="Sua senha" required>
                            <label for="loginSenha"><i class="bi bi-lock"></i> Senha</label>
                            <div class="invalid-feedback-custom"></div>
                        </div>

                        <!-- Botão Submit -->
                        <button type="submit" class="btn btn-gaia mt-2">
                            <i class="bi bi-box-arrow-in-right"></i> Entrar
                        </button>
                    </form>

                    <div class="auth-footer">
                        Não possui uma conta? <a href="cadastro.php">Cadastre-se aqui</a>
                    </div>
                </div>
            </div>
        </section>

<?php require_once 'includes/footer.php'; ?>
