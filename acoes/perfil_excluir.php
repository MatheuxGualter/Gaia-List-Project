<?php
/*
   GAIA LIST - Excluir Própria Conta
   Permite que o usuario exclua sua própria conta.
   As listas, tarefas e comentarios são removidos via ON DELETE CASCADE.
*/

session_start();

/* Verificar se esta logado */
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login.php');
    exit;
}

/* Verificar metodo POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../perfil.php');
    exit;
}

require_once '../includes/conexao.php';

$usuarioId = $_SESSION['usuario_id'];

/* Excluir usuario (CASCADE remove listas, tarefas e comentarios) */
$sql = "DELETE FROM usuarios WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $usuarioId);
$stmt->execute();

/* Destruir sessao e redirecionar para login */
session_destroy();

header('Location: ../login.php');
exit;
?>
