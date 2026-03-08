<?php
$tituloPagina = 'Dashboard';
$paginaAtiva = 'dashboard';
require_once 'includes/header_privado.php';
require_once 'includes/conexao.php';

/* Contar tarefas por status */
$stmt = $PDO->prepare("SELECT COUNT(*) AS total FROM tarefas");
$stmt->execute();
$totalTarefas = $stmt->fetch(PDO::FETCH_OBJ)->total;

$status = 'pendente';
$stmt = $PDO->prepare("SELECT COUNT(*) AS total FROM tarefas WHERE status = ?");
$stmt->bindParam(1, $status);
$stmt->execute();
$tarefasPendentes = $stmt->fetch(PDO::FETCH_OBJ)->total;

$status = 'andamento';
$stmt = $PDO->prepare("SELECT COUNT(*) AS total FROM tarefas WHERE status = ?");
$stmt->bindParam(1, $status);
$stmt->execute();
$tarefasAndamento = $stmt->fetch(PDO::FETCH_OBJ)->total;

$status = 'concluida';
$stmt = $PDO->prepare("SELECT COUNT(*) AS total FROM tarefas WHERE status = ?");
$stmt->bindParam(1, $status);
$stmt->execute();
$tarefasConcluidas = $stmt->fetch(PDO::FETCH_OBJ)->total;

$stmt = $PDO->prepare("SELECT COUNT(*) AS total FROM listas");
$stmt->execute();
$totalListas = $stmt->fetch(PDO::FETCH_OBJ)->total;

/* Buscar nomes das listas para lookup */
$stmt = $PDO->prepare("SELECT id, nome FROM listas");
$stmt->execute();
$listasNomes = array();
$row = $stmt->fetch(PDO::FETCH_OBJ);
while ($row) {
    $listasNomes[$row->id] = $row->nome;
    $row = $stmt->fetch(PDO::FETCH_OBJ);
}

/* Tarefas recentes (ultimas 5) */
$stmt = $PDO->prepare("SELECT id, titulo, status, lista_id, data_criacao FROM tarefas ORDER BY data_criacao DESC LIMIT 5");
$stmt->execute();
$tarefasRecentes = array();
$row = $stmt->fetch(PDO::FETCH_OBJ);
while ($row) {
    $nomeLista = isset($listasNomes[$row->lista_id]) ? $listasNomes[$row->lista_id] : 'Sem lista';
    $tarefasRecentes[] = array(
        'id' => $row->id,
        'titulo' => $row->titulo,
        'lista' => $nomeLista,
        'status' => $row->status,
        'data' => date('d/m/Y', strtotime($row->data_criacao))
    );
    $row = $stmt->fetch(PDO::FETCH_OBJ);
}
?>

        <!-- Dashboard -->
        <section class="dashboard-section">
            <div class="container">

                <!-- Cabeçalho -->
                <div class="dashboard-header">
                    <h2><i class="bi bi-speedometer2"></i> Dashboard</h2>
                    <p class="text-muted">Bem-vindo de volta, <?php echo isset($_SESSION['nome']) ? $_SESSION['nome'] : 'Usuário'; ?>!</p>
                </div>

                <!-- Cards Resumo -->
                <div class="row g-3 mb-4">
                    <div class="col-6 col-lg-3">
                        <div class="dash-card">
                            <div class="dash-card-icon dash-icon-total">
                                <i class="bi bi-list-check"></i>
                            </div>
                            <div class="dash-card-info">
                                <span class="dash-card-number"><?php echo $totalTarefas; ?></span>
                                <span class="dash-card-label">Total de Tarefas</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="dash-card">
                            <div class="dash-card-icon dash-icon-pendente">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div class="dash-card-info">
                                <span class="dash-card-number"><?php echo $tarefasPendentes; ?></span>
                                <span class="dash-card-label">Pendentes</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="dash-card">
                            <div class="dash-card-icon dash-icon-andamento">
                                <i class="bi bi-arrow-repeat"></i>
                            </div>
                            <div class="dash-card-info">
                                <span class="dash-card-number"><?php echo $tarefasAndamento; ?></span>
                                <span class="dash-card-label">Em Andamento</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-6 col-lg-3">
                        <div class="dash-card">
                            <div class="dash-card-icon dash-icon-concluida">
                                <i class="bi bi-check-circle"></i>
                            </div>
                            <div class="dash-card-info">
                                <span class="dash-card-number"><?php echo $tarefasConcluidas; ?></span>
                                <span class="dash-card-label">Concluídas</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Atalhos Rápidos (somente editor) -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <a href="tarefas.php" class="dash-shortcut">
                            <i class="bi bi-plus-circle"></i> Nova Tarefa
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="listas.php" class="dash-shortcut">
                            <i class="bi bi-folder-plus"></i> Nova Lista
                        </a>
                    </div>
                </div>

                <!-- Tarefas Recentes -->
                <div class="dash-table-card">
                    <div class="dash-table-header">
                        <h5><i class="bi bi-clock-history"></i> Tarefas Recentes</h5>
                        <a href="tarefas.php" class="btn btn-sm btn-gaia-outline">Ver Todas</a>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover dash-table">
                            <thead>
                                <tr>
                                    <th>Tarefa</th>
                                    <th>Lista</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($tarefasRecentes); $i++) : ?>
                                <?php $tarefa = $tarefasRecentes[$i]; ?>
                                <tr>
                                    <td class="fw-semibold"><?php echo $tarefa['titulo']; ?></td>
                                    <td>
                                        <span class="badge-lista"><?php echo $tarefa['lista']; ?></span>
                                    </td>
                                    <td>
                                        <?php if ($tarefa['status'] === 'pendente') : ?>
                                            <span class="status-badge status-pendente">
                                                <i class="bi bi-clock"></i> Pendente
                                            </span>
                                        <?php elseif ($tarefa['status'] === 'andamento') : ?>
                                            <span class="status-badge status-andamento">
                                                <i class="bi bi-arrow-repeat"></i> Em Andamento
                                            </span>
                                        <?php else : ?>
                                            <span class="status-badge status-concluida">
                                                <i class="bi bi-check-circle"></i> Concluída
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted"><?php echo $tarefa['data']; ?></td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

<?php require_once 'includes/footer.php'; ?>
