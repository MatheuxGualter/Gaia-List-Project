<?php
/* ============================================================
   GAIA LIST - Criar Tarefa
   Recebe dados via POST e insere nova tarefa no BD
   ============================================================ */

session_start();

/* Proteger: somente usuarios logados */
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

/* Somente editores podem criar tarefas */
if ($_SESSION['perfil'] !== 'editor') {
    $_SESSION['mensagem'] = 'Somente editores podem criar tarefas.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefas.php');
    exit();
}

/* Apenas aceitar metodo POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../tarefas.php');
    exit();
}

/* Receber dados do formulario */
$titulo = isset($_POST['titulo']) ? trim($_POST['titulo']) : '';
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';
$lista_id = isset($_POST['lista_id']) ? $_POST['lista_id'] : '';
$status = isset($_POST['status']) ? $_POST['status'] : 'pendente';

/* Validacao no servidor */
if ($titulo === '' || $lista_id === '') {
    $_SESSION['mensagem'] = 'Preencha o titulo e selecione uma lista.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../tarefas.php');
    exit();
}

/* Validar status */
$statusValidos = array('pendente', 'andamento', 'concluida');
if (!in_array($status, $statusValidos)) {
    $status = 'pendente';
}

/* Inserir no banco */
require_once '../includes/conexao.php';

$sql = "INSERT INTO tarefas (titulo, descricao, status, lista_id, usuario_id) VALUES (?, ?, ?, ?, ?)";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $titulo);
$stmt->bindParam(2, $descricao);
$stmt->bindParam(3, $status);
$stmt->bindParam(4, $lista_id);
$stmt->bindParam(5, $_SESSION['usuario_id']);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Tarefa criada com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao criar tarefa.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../tarefas.php');
exit();
?>
