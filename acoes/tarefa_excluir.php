<?php
/* ============================================================
   GAIA LIST - Excluir Tarefa
   Recebe tarefa_id via POST e remove do BD
   ============================================================ */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SESSION['perfil'] !== 'editor') {
    $_SESSION['mensagem'] = 'Somente editores podem excluir tarefas.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefas.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../tarefas.php');
    exit();
}

$tarefa_id = isset($_POST['tarefa_id']) ? $_POST['tarefa_id'] : '';

if ($tarefa_id === '') {
    $_SESSION['mensagem'] = 'Tarefa nao encontrada.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefas.php');
    exit();
}

require_once '../includes/conexao.php';

$sql = "DELETE FROM tarefas WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $tarefa_id);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Tarefa excluida com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao excluir tarefa.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../tarefas.php');
exit();
?>
