<?php
/* ============================================================
   GAIA LIST - Logout
   Encerra a sessao e redireciona para a pagina de login
   ============================================================ */

session_start();

/* Passo 1: Limpar todas as variaveis da sessao */
$_SESSION = array();

/* Passo 2: Destruir o cookie da sessao no navegador */
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

/* Passo 3: Destruir a sessao no servidor */
session_destroy();

/* Redirecionar para a pagina de login */
header('Location: ../login.php');
exit();
?>
