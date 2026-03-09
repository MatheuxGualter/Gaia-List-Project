<?php
$db_host = 'sql103.infinityfree.com';
$db_nome = 'if0_41340420_bd_gaia_list';
$db_usuario = 'if0_41340420';
$db_senha = 'gualter321';

$PDO = new PDO(
    "mysql:host=$db_host;dbname=$db_nome;charset=utf8mb4",
    $db_usuario,
    $db_senha
);

/* Configurar PDO para lancar excecoes em caso de erro */
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
