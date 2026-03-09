<?php
/*
   GAIA LIST - Buscar Tarefas via AJAX
   Retorna JSON com tarefas que contenham o termo buscado no titulo.
   Requisição: GET ?termo=texto
   Resposta: JSON { "quantidade": X, "tarefas": [...] }
*/

session_start();

/* Verificar se esta logado */
if (!isset($_SESSION['logado']) || $_SESSION['logado'] !== true) {
    header('Content-Type: application/json');
    echo json_encode(array('quantidade' => 0, 'tarefas' => array()));
    exit;
}

require_once '../includes/conexao.php';

/* Pegar o termo de busca */
$termo = isset($_GET['termo']) ? $_GET['termo'] : '';

/* Se o termo estiver vazio, retornar vazio */
if ($termo === '' || strlen($termo) < 2) {
    header('Content-Type: application/json');
    echo json_encode(array('quantidade' => 0, 'tarefas' => array()));
    exit;
}

/* Buscar nomes das listas */
$stmt = $PDO->prepare("SELECT id, nome FROM listas");
$stmt->execute();
$listasNomes = array();
$row = $stmt->fetch(PDO::FETCH_OBJ);
while ($row) {
    $listasNomes[$row->id] = $row->nome;
    $row = $stmt->fetch(PDO::FETCH_OBJ);
}

/* Buscar tarefas que contenham o termo no titulo */
$termoBusca = '%' . $termo . '%';
$sql = "SELECT id, titulo, descricao, status, lista_id, data_criacao FROM tarefas WHERE titulo LIKE ? ORDER BY data_criacao DESC LIMIT 10";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(1, $termoBusca);
$stmt->execute();

$tarefas = array();
$row = $stmt->fetch(PDO::FETCH_OBJ);
while ($row) {
    $nomeLista = isset($listasNomes[$row->lista_id]) ? $listasNomes[$row->lista_id] : 'Sem lista';
    $tarefas[] = array(
        'id' => $row->id,
        'titulo' => $row->titulo,
        'descricao' => ($row->descricao !== null) ? $row->descricao : '',
        'status' => $row->status,
        'lista' => $nomeLista,
        'data_criacao' => date('d/m/Y', strtotime($row->data_criacao))
    );
    $row = $stmt->fetch(PDO::FETCH_OBJ);
}

/* Retornar JSON */
header('Content-Type: application/json');
echo json_encode(array(
    'quantidade' => count($tarefas),
    'tarefas' => $tarefas
));
?>
