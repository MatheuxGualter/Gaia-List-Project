<?php
/* ============================================================
   GAIA LIST - Processar Login
   Recebe email e senha via POST, valida no BD e inicia sessao
   ============================================================ */

session_start();

/* Apenas aceitar metodo POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../login.php');
    exit();
}

/* Receber dados do formulario */
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';

/* Validacao basica no servidor */
if ($email === '' || $senha === '') {
    $_SESSION['mensagem'] = 'Preencha todos os campos.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../login.php');
    exit();
}

/* Conectar ao banco de dados */
require_once '../includes/conexao.php';

/* Buscar usuario pelo email */
$sql = "SELECT id, nome, email, senha, perfil FROM usuarios WHERE email = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $email);
$stmt->execute();
$usuario = $stmt->fetch(PDO::FETCH_OBJ);

/* Verificar se o usuario existe e a senha esta correta */
if ($usuario && password_verify($senha, $usuario->senha)) {
    /* Login bem-sucedido: salvar dados na sessao */
    $_SESSION['logado'] = true;
    $_SESSION['usuario_id'] = $usuario->id;
    $_SESSION['nome'] = $usuario->nome;
    $_SESSION['email'] = $usuario->email;
    $_SESSION['perfil'] = $usuario->perfil;

    header('Location: ../dashboard.php');
    exit();
} else {
    /* Login falhou */
    $_SESSION['mensagem'] = 'E-mail ou senha incorretos.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../login.php');
    exit();
}
?>
