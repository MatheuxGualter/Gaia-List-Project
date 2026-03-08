<?php
/*
   Acao: Criar novo comentario em uma tarefa
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
    $_SESSION['mensagem'] = 'Voce nao tem permissao para comentar.';
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
$texto = isset($_POST['texto']) ? $_POST['texto'] : '';

/* Validar */
if ($tarefa_id === '' || $texto === '' || strlen($texto) < 2) {
    $_SESSION['mensagem'] = 'O comentario deve ter pelo menos 2 caracteres.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefa_detalhes.php?id=' . $tarefa_id);
    exit();
}

/* Inserir no banco */
require_once '../includes/conexao.php';

$usuario_id = $_SESSION['usuario_id'];

$stmt = $PDO->prepare("INSERT INTO comentarios (texto, tarefa_id, usuario_id) VALUES (?, ?, ?)");
$stmt->bindParam(1, $texto);
$stmt->bindParam(2, $tarefa_id);
$stmt->bindParam(3, $usuario_id);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $_SESSION['mensagem'] = 'Comentario adicionado com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao adicionar comentario.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../tarefa_detalhes.php?id=' . $tarefa_id);
exit();
