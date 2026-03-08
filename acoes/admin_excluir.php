<?php
/* ============================================================
   GAIA LIST - Excluir Usuario (Admin)
   Recebe usuario_id via POST e remove do BD
   (ON DELETE CASCADE remove listas, tarefas e comentarios)
   ============================================================ */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SESSION['perfil'] !== 'editor') {
    header('Location: ../dashboard.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../admin_usuarios.php');
    exit();
}

$usuario_id = isset($_POST['usuario_id']) ? $_POST['usuario_id'] : '';

if ($usuario_id === '') {
    $_SESSION['mensagem'] = 'Usuario nao encontrado.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../admin_usuarios.php');
    exit();
}

/* Nao permitir excluir a si mesmo */
if ($usuario_id == $_SESSION['usuario_id']) {
    $_SESSION['mensagem'] = 'Voce nao pode excluir sua propria conta.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../admin_usuarios.php');
    exit();
}

require_once '../includes/conexao.php';

$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $usuario_id);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Usuario excluido com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao excluir usuario.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../admin_usuarios.php');
exit();
?>
