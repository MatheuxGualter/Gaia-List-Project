<?php
/* ============================================================
   GAIA LIST - Alterar Senha
   Recebe senha atual e nova via POST, valida e atualiza no BD
   ============================================================ */

session_start();

if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Location: ../login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../perfil.php');
    exit();
}

$senhaAtual = isset($_POST['senha_atual']) ? $_POST['senha_atual'] : '';
$senhaNova = isset($_POST['senha_nova']) ? $_POST['senha_nova'] : '';
$senhaConfirmar = isset($_POST['senha_confirmar']) ? $_POST['senha_confirmar'] : '';

if ($senhaAtual === '' || $senhaNova === '' || $senhaConfirmar === '') {
    $_SESSION['mensagem'] = 'Preencha todos os campos de senha.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../perfil.php');
    exit();
}

if (strlen($senhaNova) < 8) {
    $_SESSION['mensagem'] = 'A nova senha deve ter pelo menos 8 caracteres.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../perfil.php');
    exit();
}

if ($senhaNova !== $senhaConfirmar) {
    $_SESSION['mensagem'] = 'As novas senhas nao coincidem.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../perfil.php');
    exit();
}

require_once '../includes/conexao.php';

/* Buscar senha atual do banco */
$sql = "SELECT senha FROM usuarios WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $_SESSION['usuario_id']);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_OBJ);

if (!$usuario || !password_verify($senhaAtual, $usuario->senha)) {
    $_SESSION['mensagem'] = 'Senha atual incorreta.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../perfil.php');
    exit();
}

/* Atualizar senha */
$senhaHash = password_hash($senhaNova, PASSWORD_DEFAULT);
$sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $senhaHash);
$stmt->bindParam(2, $_SESSION['usuario_id']);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Senha alterada com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao alterar senha.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../perfil.php');
exit();
?>
