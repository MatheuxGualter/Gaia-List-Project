<?php
require_once __DIR__ . '/config.php';

$PDO = new PDO(
    "mysql:host=$db_host;dbname=$db_nome;charset=utf8mb4",
    $db_usuario,
    $db_senha
);

/* Configurar PDO para lancar excecoes em caso de erro */
$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
