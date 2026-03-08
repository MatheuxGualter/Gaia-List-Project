<?php
/* Teste de conexao com o banco de dados pelo navegador */
require_once 'includes/conexao.php';
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teste BD - Gaia List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h1 class="mb-4">Teste de Conexao com o Banco de Dados</h1>

        <!-- Teste 1: Conexao -->
        <div class="alert alert-success">
            <strong>Conexao PDO:</strong> OK
        </div>

        <!-- Teste 2: Usuarios -->
        <h3>Usuarios</h3>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Perfil</th>
                    <th>Data Cadastro</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $PDO->prepare("SELECT id, nome, email, perfil, data_cadastro FROM usuarios");
                $stmt->execute();
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    echo "<td>" . $rs->id . "</td>";
                    echo "<td>" . htmlspecialchars($rs->nome) . "</td>";
                    echo "<td>" . htmlspecialchars($rs->email) . "</td>";
                    echo "<td><span class='badge bg-primary'>" . htmlspecialchars($rs->perfil) . "</span></td>";
                    echo "<td>" . $rs->data_cadastro . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Teste 3: Listas -->
        <h3>Listas</h3>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Criada por</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $PDO->prepare("SELECT listas.id, listas.nome, usuarios.nome AS criador FROM listas, usuarios WHERE listas.usuario_id = usuarios.id");
                $stmt->execute();
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    echo "<td>" . $rs->id . "</td>";
                    echo "<td>" . htmlspecialchars($rs->nome) . "</td>";
                    echo "<td>" . htmlspecialchars($rs->criador) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Teste 4: Tarefas -->
        <h3>Tarefas</h3>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Status</th>
                    <th>Lista</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $PDO->prepare("SELECT tarefas.id, tarefas.titulo, tarefas.status, listas.nome AS lista FROM tarefas, listas WHERE tarefas.lista_id = listas.id");
                $stmt->execute();
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    echo "<td>" . $rs->id . "</td>";
                    echo "<td>" . htmlspecialchars($rs->titulo) . "</td>";
                    echo "<td>" . htmlspecialchars($rs->status) . "</td>";
                    echo "<td>" . htmlspecialchars($rs->lista) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Teste 5: Comentarios -->
        <h3>Comentarios</h3>
        <table class="table table-striped table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Texto</th>
                    <th>Tarefa</th>
                    <th>Autor</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $stmt = $PDO->prepare("SELECT comentarios.id, comentarios.texto, tarefas.titulo AS tarefa, usuarios.nome AS autor FROM comentarios, tarefas, usuarios WHERE comentarios.tarefa_id = tarefas.id AND comentarios.usuario_id = usuarios.id");
                $stmt->execute();
                while ($rs = $stmt->fetch(PDO::FETCH_OBJ)) {
                    echo "<tr>";
                    echo "<td>" . $rs->id . "</td>";
                    echo "<td>" . htmlspecialchars($rs->texto) . "</td>";
                    echo "<td>" . htmlspecialchars($rs->tarefa) . "</td>";
                    echo "<td>" . htmlspecialchars($rs->autor) . "</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>

        <hr>
        <p class="text-muted">Arquivo de teste.</p>
    </div>
</body>
</html>
