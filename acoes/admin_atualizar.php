<?php
/* ============================================================
   GAIA LIST - Atualizar Perfil de Usuario (Admin)
   Recebe usuario_id e perfil via POST, atualiza no BD
   ============================================================ */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

/* Somente editores podem gerenciar usuarios */
if ($_SESSION['perfil'] !== 'editor') {
    header('Location: ../dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin_usuarios.php');
    exit();
}

$usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : '';
$perfil = isset($_POST['perfil']) ? $_POST['perfil'] : '';

if ($usuario_id === '' || $perfil === '') {
    $_SESSION['mensagem'] = 'Dados incompletos.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../admin_usuarios.php');
    exit();
}

$perfis_validos = array('editor', 'comentador', 'visualizador');
if (!in_array($perfil, $perfis_validos)) {
    $_SESSION['mensagem'] = 'Perfil invalido.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../admin_usuarios.php');
    exit();
}

require_once '../includes/conexao.php';

$sql = "UPDATE usuarios SET perfil = ? WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $perfil);
$stmt->bindParam(2, $usuario_id);

if ($stmt->execute()) {
    /* Se editou o proprio perfil, atualizar sessao */
    if ($usuario_id == $_SESSION['usuario_id']) {
        $_SESSION['perfil'] = $perfil;
    }
    $_SESSION['mensagem'] = 'Perfil do usuario atualizado com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao atualizar perfil.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../admin_usuarios.php');
exit();
?>
