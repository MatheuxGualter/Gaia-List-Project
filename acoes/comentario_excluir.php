<?php
/*
   Acao: Excluir comentario de uma tarefa
   Metodo: POST
   Acesso: autor do comentario ou editor
*/
session_start();

/* Verificar autenticacao */
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit();
}

/* Verificar metodo POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../tarefas.php');
    exit();
}

/* Receber dados */
$comentario_id = isset($_POST['comentario_id']) ? $_POST['comentario_id'] : '';
$tarefa_id = isset($_POST['tarefa_id']) ? $_POST['tarefa_id'] : '';

if ($comentario_id === '' || $tarefa_id === '') {
    header('Location: ../tarefas.php');
    exit();
}

require_once '../includes/conexao.php';

/* Buscar o comentario para verificar autoria */
$stmt = $PDO->prepare("SELECT usuario_id FROM comentarios WHERE id = ?");
$stmt->bindParam(1, $comentario_id);
$stmt->execute();
$comentario = $stmt->fetch(PDO::FETCH_OBJ);

if (!$comentario) {
    $_SESSION['mensagem'] = 'Comentario nao encontrado.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefa_detalhes.php?id=' . $tarefa_id);
    exit();
}

/* Verificar permissao: autor do comentario ou editor */
$perfil = isset($_SESSION['perfil']) ? $_SESSION['perfil'] : 'visualizador';
$usuario_id = $_SESSION['usuario_id'];

if ($comentario->usuario_id != $usuario_id && $perfil !== 'editor') {
    $_SESSION['mensagem'] = 'Voce nao tem permissao para excluir este comentario.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefa_detalhes.php?id=' . $tarefa_id);
    exit();
}

/* Excluir */
$stmt = $PDO->prepare("DELETE FROM comentarios WHERE id = ?");
$stmt->bindParam(1, $comentario_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $_SESSION['mensagem'] = 'Comentario excluido com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao excluir comentario.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../tarefa_detalhes.php?id=' . $tarefa_id);
exit();
