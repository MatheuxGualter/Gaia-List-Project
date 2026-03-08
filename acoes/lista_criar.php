<?php
/* ============================================================
   GAIA LIST - Criar Lista
   Recebe dados via POST e insere nova lista no BD
   ============================================================ */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SESSION['perfil'] !== 'editor') {
    $_SESSION['mensagem'] = 'Somente editores podem criar listas.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../listas.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../listas.php');
    exit();
}

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';

if ($nome === '') {
    $_SESSION['mensagem'] = 'Informe o nome da lista.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../listas.php');
    exit();
}

require_once '../includes/conexao.php';

$sql = "INSERT INTO listas (nome, descricao, usuario_id) VALUES (?, ?, ?)";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $nome);
$stmt->bindParam(2, $descricao);
$stmt->bindParam(3, $_SESSION['usuario_id']);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Lista criada com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao criar lista.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../listas.php');
exit();
?>
