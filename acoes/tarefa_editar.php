<?php
/* ============================================================
   GAIA LIST - Editar Tarefa
   Recebe dados via POST e atualiza tarefa no BD
   ============================================================ */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SESSION['perfil'] !== 'editor') {
    $_SESSION['mensagem'] = 'Somente editores podem editar tarefas.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefas.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../tarefas.php');
    exit();
}

/* Receber dados */
$tarefa_id = isset($_POST['tarefa_id']) ? $_POST['tarefa_id'] : '';
$titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
$lista_id = isset($_POST['lista_id']) ? $_POST['lista_id'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

/* Validacao */
if ($tarefa_id === '' || $titulo === '' || $lista_id === '' || $status === '') {
    $_SESSION['mensagem'] = 'Preencha todos os campos obrigatorios.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefas.php');
    exit();
}

$statusValidos = array('pendente', 'andamento', 'concluida');
if (!in_array($status, $statusValidos)) {
    $_SESSION['mensagem'] = 'Status invalido.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefas.php');
    exit();
}

/* Atualizar no banco */
require_once '../includes/conexao.php';

$sql = "UPDATE tarefas SET titulo = ?, descricao = ?, lista_id = ?, status = ? WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $titulo);
$stmt->bindParam(2, $descricao);
$stmt->bindParam(3, $lista_id);
$stmt->bindParam(4, $status);
$stmt->bindParam(5, $tarefa_id);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Tarefa atualizada com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao atualizar tarefa.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../tarefas.php');
exit();
?>
