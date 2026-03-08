<?php
/* Arquivo temporario para simular sessao de usuario logado
   http://localhost:8000/teste_sessao.php */

session_start();

$_SESSION['nome'] = 'Matheus Resende';
$_SESSION['email'] = 'matheus@email.com';
$_SESSION['perfil'] = 'editor';
$_SESSION['usuario_id'] = 1;

echo '<h2>Sessao simulada com sucesso!</h2>';
echo '<p><strong>Nome:</strong> ' . $_SESSION['nome'] . '</p>';
echo '<p><strong>Email:</strong> ' . $_SESSION['email'] . '</p>';
echo '<p><strong>Perfil:</strong> ' . $_SESSION['perfil'] . '</p>';
echo '<hr>';
echo '<p>Agora acesse as paginas da area privada:</p>';
echo '<ul>';
echo '<li><a href="dashboard.php">Dashboard</a></li>';
echo '<li><a href="tarefas.php">Tarefas</a></li>';
echo '<li><a href="listas.php">Listas</a></li>';
echo '<li><a href="perfil.php">Perfil</a></li>';
echo '<li><a href="admin_usuarios.php">Admin Usuarios</a></li>';
echo '</ul>';
echo '<hr>';
echo '<p><small>Para testar como comentador, mude a linha do perfil para "comentador".</small></p>';
?>
