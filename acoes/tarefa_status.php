<?php
/*
   Acao: Alterar apenas o status de uma tarefa
   Metodo: POST
   Acesso: editor e comentador
*/
session_start();

/* Verificar autenticacao */
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

/* Verificar perfil (editor ou comentador) */
$perfil = isset($_SESSION['perfil']) ? $_SESSION['perfil'] : 'visualizador';
if ($perfil !== 'editor' && $perfil !== 'comentador') {
    $_SESSION['mensagem'] = 'Voce nao tem permissao para alterar o status.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefas.php');
    exit();
}

/* Verificar metodo POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../tarefas.php');
    exit();
}

/* Receber dados */
$tarefa_id = isset($_POST['tarefa_id']) ? $_POST['tarefa_id'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : '';

/* Validar */
$statusValidos = array('pendente', 'andamento', 'concluida');
if ($tarefa_id === '' || $status === '' || !in_array($status, $statusValidos)) {
    $_SESSION['mensagem'] = 'Dados invalidos para alterar status.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefa_detalhes.php?id=' . $tarefa_id);
    exit();
}

/* Atualizar no banco */
require_once '../includes/conexao.php';

$stmt = $PDO->prepare("UPDATE tarefas SET status = ? WHERE id = ?");
$stmt->bindParam(1, $status);
$stmt->bindParam(2, $tarefa_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $_SESSION['mensagem'] = 'Status atualizado com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Nenhuma alteracao realizada (status ja era o mesmo).';
    $_SESSION['tipo_mensagem'] = 'warning';
}

header('Location: ../tarefa_detalhes.php?id=' . $tarefa_id);
exit();
