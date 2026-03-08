<?php
/* ============================================================
   GAIA LIST - Processar Cadastro
   Recebe dados via POST, valida, criptografa senha e insere no BD
   ============================================================ */

session_start();

/* Apenas aceitar metodo POST */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../cadastro.php');
    exit();
}

/* Receber dados do formulario */
$nome = isset($_POST['nome']) ? trim($_POST['nome']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : '';
$confirmar_senha = isset($_POST['confirmar_senha']) ? $_POST['confirmar_senha'] : '';
$perfil = isset($_POST['perfil']) ? $_POST['perfil'] : '';

/* Validacao no servidor */
if ($nome === '' || $email === '' || $senha === '' || $confirmar_senha === '' || $perfil === '') {
    $_SESSION['mensagem'] = 'Preencha todos os campos.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../cadastro.php');
    exit();
}

if (strlen($nome) < 3) {
    $_SESSION['mensagem'] = 'O nome deve ter pelo menos 3 caracteres.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../cadastro.php');
    exit();
}

/* Validar formato do email */
$emailFiltrado = filter_var($email, FILTER_VALIDATE_EMAIL);
if (!$emailFiltrado) {
    $_SESSION['mensagem'] = 'Informe um e-mail valido.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../cadastro.php');
    exit();
}

if (strlen($senha) < 8) {
    $_SESSION['mensagem'] = 'A senha deve ter pelo menos 8 caracteres.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../cadastro.php');
    exit();
}

if ($senha !== $confirmar_senha) {
    $_SESSION['mensagem'] = 'As senhas nao coincidem.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../cadastro.php');
    exit();
}

/* Validar perfil */
$perfis_validos = array('editor', 'comentador', 'visualizador');
if (!in_array($perfil, $perfis_validos)) {
    $_SESSION['mensagem'] = 'Selecione um perfil valido.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../cadastro.php');
    exit();
}

/* Conectar ao banco de dados */
require_once '../includes/conexao.php';

/* Verificar se o email ja esta cadastrado */
$sql = "SELECT id FROM usuarios WHERE email = ?";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $emailFiltrado);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    $_SESSION['mensagem'] = 'Este e-mail ja esta cadastrado.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../cadastro.php');
    exit();
}

/* Criptografar a senha */
$senhaHash = password_hash($senha, PASSWORD_DEFAULT);

/* Inserir novo usuario no banco */
$sql = "INSERT INTO usuarios (nome, email, senha, perfil) VALUES (?, ?, ?, ?)";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $nome);
$stmt->bindParam(2, $emailFiltrado);
$stmt->bindParam(3, $senhaHash);
$stmt->bindParam(4, $perfil);

if ($stmt->execute()) {
    $_SESSION['mensagem'] = 'Conta criada com sucesso! Faca login para acessar.';
    $_SESSION['tipo_mensagem'] = 'success';
    header('Location: ../login.php');
    exit();
} else {
    $_SESSION['mensagem'] = 'Erro ao criar conta. Tente novamente.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: ../cadastro.php');
    exit();
}
?>
