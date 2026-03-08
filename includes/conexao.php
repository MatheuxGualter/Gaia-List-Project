<?php
/* ============================================================
   GAIA LIST - Conexao com o Banco de Dados (PDO)
   FACOM32603 - Desenvolvimento Web I - UFU
   ============================================================ */

$db_host = 'localhost';
$db_nome = 'bd_gaia_list';
$db_usuario = 'root';
$db_senha = '';

$PDO = new PDO(
    "mysql:host=$db_host;dbname=$db_nome;charset=utf8mb4",
    $db_usuario,
    $db_senha
);

/* Configurar PDO para lancar excecoes em caso de erro */
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
