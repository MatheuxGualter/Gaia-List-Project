<!-- includes/header.php -->
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

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-gaia sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.html">
                <i class="bi bi-check2-square"></i> Gaia List
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Alternar navegação">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?php echo (isset($paginaAtiva) && $paginaAtiva === 'home') ? 'active' : ''; ?>" 
                           href="index.html">
                            <i class="bi bi-house-door"></i> Início
                        </a>
                    </li>
                </ul>

                <div class="d-flex gap-2">
                    <a href="login.php" class="nav-link btn-nav-login <?php echo (isset($paginaAtiva) && $paginaAtiva === 'login') ? 'active' : ''; ?>">
                        <i class="bi bi-box-arrow-in-right"></i> Entrar
                    </a>
                    <a href="cadastro.php" class="nav-link btn-nav-cadastro <?php echo (isset($paginaAtiva) && $paginaAtiva === 'cadastro') ? 'active' : ''; ?>">
                        <i class="bi bi-person-plus"></i> Cadastrar
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <main>
