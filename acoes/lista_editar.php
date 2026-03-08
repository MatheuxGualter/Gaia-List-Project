<?php
/* ============================================================
   GAIA LIST - Editar Lista
   Recebe dados via POST e atualiza lista no BD
   ============================================================ */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SESSION['perfil'] !== 'editor') {
    $_SESSION['mensagem'] = 'Somente editores podem editar listas.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../listas.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../listas.php');
    exit();
}

$lista_id = isset($_POST['lista_id']) ? $_POST['lista_id'] : '';
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$descricao = isset($_POST['descricao']) ? trim($_POST['descricao']) : '';

if ($lista_id === '' || $nome === '') {
    $_SESSION['mensagem'] = 'Preencha o nome da lista.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../listas.php');
    exit();
}

require_once '../includes/conexao.php';

$sql = "UPDATE listas SET nome = ?, descricao = ? WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $nome);
$stmt->bindParam(2, $descricao);
$stmt->bindParam(3, $lista_id);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Lista atualizada com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao atualizar lista.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../listas.php');
exit();
?>
