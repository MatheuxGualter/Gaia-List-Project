<?php
/* ============================================================
   GAIA LIST - Atualizar Perfil
   Recebe nome e email via POST e atualiza no BD
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

$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';

if ($nome === '' || $email === '') {
    $_SESSION['mensagem'] = 'Preencha todos os campos.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../perfil.php');
    exit();
}

if (strlen($nome) < 3) {
    $_SESSION['mensagem'] = 'O nome deve ter pelo menos 3 caracteres.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../perfil.php');
    exit();
}

$emailFiltrado = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$emailFiltrado) {
    $_SESSION['mensagem'] = 'Informe um e-mail valido.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../perfil.php');
    exit();
}

require_once '../includes/conexao.php';

/* Verificar se email ja pertence a outro usuario */
$sql = "SELECT id FROM usuarios WHERE email = ? AND id != ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $emailFiltrado);
$stmt->bindParam(2, $_SESSION['usuario_id']);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $_SESSION['mensagem'] = 'Este e-mail ja esta em uso por outro usuario.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../perfil.php');
    exit();
}

/* Atualizar dados */
$sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $nome);
$stmt->bindParam(2, $emailFiltrado);
$stmt->bindParam(3, $_SESSION['usuario_id']);

if ($stmt->execute()) {
    /* Atualizar dados na sessao */
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $emailFiltrado;
    $_SESSION['mensagem'] = 'Dados atualizados com sucesso!';
    $_SESSION['tipo_mensagem'] = 'success';
} else {
    $_SESSION['mensagem'] = 'Erro ao atualizar dados.';
    $_SESSION['tipo_mensagem'] = 'danger';
}

header('Location: ../perfil.php');
exit();
?>
