<!-- includes/header_privado.php -->
<?php
session_start();

/* Proteger pagina: redirecionar se nao estiver logado */
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    session_destroy();
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($tituloPagina) ? $tituloPagina . ' - Gaia List' : 'Gaia List'; ?></title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="favicon.svg">

    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- Gaia List CSS -->
    <link href="style.css" rel="stylesheet">
</head>
<body>

    <!-- Navbar Privada -->
    <nav class="navbar navbar-expand-lg navbar-gaia sticky-top">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">
                <i class="bi bi-check2-square"></i> Gaia List
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarPrivado"
                    aria-controls="navbarPrivado" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarPrivado">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($paginaAtiva) && $paginaAtiva === 'dashboard') ? 'active' : ''; ?>"
                           href="dashboard.php">
                            <i class="bi bi-speedometer2"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($paginaAtiva) && $paginaAtiva === 'tarefas') ? 'active' : ''; ?>"
                           href="tarefas.php">
                            <i class="bi bi-list-check"></i> Tarefas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($paginaAtiva) && $paginaAtiva === 'listas') ? 'active' : ''; ?>"
                           href="listas.php">
                            <i class="bi bi-folder"></i> Listas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($paginaAtiva) && $paginaAtiva === 'perfil') ? 'active' : ''; ?>"
                           href="perfil.php">
                            <i class="bi bi-person-circle"></i> Perfil
                        </a>
                    </li>
                    <?php if (isset($_SESSION['perfil']) && $_SESSION['perfil'] === 'editor') : ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($paginaAtiva) && $paginaAtiva === 'admin') ? 'active' : ''; ?>"
                           href="admin_usuarios.php">
                            <i class="bi bi-gear"></i> Admin
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>

                <div class="d-flex align-items-center gap-3">
                    <span class="navbar-text nav-user-info">
                        <i class="bi bi-person-fill"></i>
                        <?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Usuário'; ?>
                        <span class="nav-perfil-badge">
                            <?php echo isset($_SESSION['perfil']) ? $_SESSION['perfil'] : ''; ?>
                        </span>
                    </span>
                    <a href="auth/logout.php" class="btn btn-nav-sair">
                        <i class="bi bi-box-arrow-right"></i> Sair
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main>

<?php
/* Ler mensagem flash da sessao */
$msgFlash = '';
$tipoFlash = '';
if (isset($_SESSION['mensagem'])) {
    $msgFlash = $_SESSION['mensagem'];
    $tipoFlash = isset($_SESSION['tipo_mensagem']) ? $_SESSION['tipo_mensagem'] : 'info';
    unset($_SESSION['mensagem']);
    unset($_SESSION['tipo_mensagem']);
}
?>
<?php if ($msgFlash !== '') : ?>
        <div class="container mt-3">
            <div class="alert alert-<?php echo htmlspecialchars($tipoFlash); ?> alert-dismissible" role="alert">
                <?php echo htmlspecialchars($msgFlash); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
            </div>
        </div>
<?php endif; ?>
