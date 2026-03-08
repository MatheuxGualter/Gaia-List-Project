<?php
/* ============================================================
   GAIA LIST - Excluir Lista
   Recebe lista_id via POST e remove do BD
   (ON DELETE CASCADE remove tarefas e comentarios vinculados)
   ============================================================ */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SESSION['perfil'] !== 'editor') {
    $_SESSION['mensagem'] = 'Somente editores podem excluir listas.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../listas.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../listas.php');
    exit();
}

$lista_id = isset($_POST['lista_id']) ? $_POST['lista_id'] : '';

if ($lista_id === '') {
    $_SESSION['mensagem'] = 'Lista nao encontrada.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../listas.php');
    exit();
}

require_once '../includes/conexao.php';

$sql = "DELETE FROM listas WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $lista_id);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Lista excluida com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao excluir lista.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../listas.php');
exit();
?>
