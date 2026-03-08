<?php
/* ============================================================
   GAIA LIST - Conexao com o Banco de Dados (PDO)
   FACOM32603 - Desenvolvimento Web I - UFU
   ============================================================ */

$host = 'localhost';
$dbname = 'bd_gaia_list';
$usuario = 'root';
$senha = '';

try {
    $PDO = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $usuario,
        $senha
    );
    /* Configurar PDO para lancar excecoes em caso de erro */
    $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar com o banco de dados: " . $e->getMessage();
    exit();
}
?>
