<?php
$tituloPagina = 'Tarefas';
$paginaAtiva = 'tarefas';
require_once 'includes/header_privado.php';
require_once 'includes/conexao.php';

/* Perfil do usuario */
$perfilUsuario = isset($_SESSION['perfil']) ? $_SESSION['perfil'] : 'visualizador';

/* Buscar todas as listas */
$stmt = $PDO->prepare("SELECT id, nome FROM listas ORDER BY nome");
$stmt->execute();
$listas = array();
$listasNomes = array();
$row = $stmt->fetch(PDO::FETCH_OBJ);
while ($row) {
    $listas[] = array('id' => $row->id, 'nome' => $row->nome);
    $listasNomes[$row->id] = $row->nome;
    $row = $stmt->fetch(PDO::FETCH_OBJ);
}

/* Contar comentarios por tarefa (sem GROUP BY) */
$stmt = $PDO->prepare("SELECT tarefa_id FROM comentarios");
$stmt->execute();
$contadorComentarios = array();
$rowC = $stmt->fetch(PDO::FETCH_OBJ);
while ($rowC) {
    if (isset($contadorComentarios[$rowC->tarefa_id])) {
        $contadorComentarios[$rowC->tarefa_id] = $contadorComentarios[$rowC->tarefa_id] + 1;
    } else {
        $contadorComentarios[$rowC->tarefa_id] = 1;
    }
    $rowC = $stmt->fetch(PDO::FETCH_OBJ);
}

/* Filtros */
$filtroStatus = isset($_GET['status']) ? $_GET['status'] : '';
$filtroLista = isset($_GET['lista']) ? $_GET['lista'] : '';

/* Buscar tarefas com filtros */
if ($filtroStatus !== '' && $filtroLista !== '') {
    $sql = "SELECT id, titulo, descricao, status, lista_id, data_criacao FROM tarefas WHERE status = ? AND lista_id = ? ORDER BY data_criacao DESC";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(1, $filtroStatus);
    $stmt->bindParam(2, $filtroLista);
} elseif ($filtroStatus !== '') {
    $sql = "SELECT id, titulo, descricao, status, lista_id, data_criacao FROM tarefas WHERE status = ? ORDER BY data_criacao DESC";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(1, $filtroStatus);
} elseif ($filtroLista !== '') {
    $sql = "SELECT id, titulo, descricao, status, lista_id, data_criacao FROM tarefas WHERE lista_id = ? ORDER BY data_criacao DESC";
    $stmt = $PDO->prepare($sql);
    $stmt->bindParam(1, $filtroLista);
} else {
    $sql = "SELECT id, titulo, descricao, status, lista_id, data_criacao FROM tarefas ORDER BY data_criacao DESC";
    $stmt = $PDO->prepare($sql);
}
$stmt->execute();

$tarefas = array();
$row = $stmt->fetch(PDO::FETCH_OBJ);
while ($row) {
    $nomeLista = isset($listasNomes[$row->lista_id]) ? $listasNomes[$row->lista_id] : 'Sem lista';
    $totalComents = isset($contadorComentarios[$row->id]) ? $contadorComentarios[$row->id] : 0;
    $tarefas[] = array(
        'id' => $row->id,
        'titulo' => $row->titulo,
        'descricao' => $row->descricao !== null ? $row->descricao : '',
        'lista' => $nomeLista,
        'lista_id' => $row->lista_id,
        'status' => $row->status,
        'data_criacao' => date('d/m/Y', strtotime($row->data_criacao)),
        'comentarios' => $totalComents
    );
    $row = $stmt->fetch(PDO::FETCH_OBJ);
}
?>

        <!-- Tarefas -->
        <section class="page-section">
            <div class="container">

                <!-- Cabeçalho da página -->
                <div class="page-header">
                    <div>
                        <h2><i class="bi bi-list-check"></i> Tarefas</h2>
                        <p class="text-muted">Gerencie todas as suas tarefas</p>
                    </div>
                    <?php if ($perfilUsuario === 'editor') : ?>
                    <button type="button" class="btn btn-gaia-primary" data-bs-toggle="modal" data-bs-target="#modalNovaTarefa">
                        <i class="bi bi-plus-lg"></i> Nova Tarefa
                    </button>
                    <?php endif; ?>
                </div>

                <!-- Filtros -->
                <div class="filtros-bar mb-4">
                    <form method="GET" action="tarefas.php" class="row g-2 align-items-end">
                        <div class="col-md-4">
                            <label for="filtroStatus" class="form-label form-label-sm text-muted">Status</label>
                            <select class="form-select form-select-sm" id="filtroStatus" name="status">
                                <option value="">Todos os status</option>
                                <option value="pendente" <?php echo ($filtroStatus === 'pendente') ? 'selected' : ''; ?>>Pendente</option>
                                <option value="andamento" <?php echo ($filtroStatus === 'andamento') ? 'selected' : ''; ?>>Em Andamento</option>
                                <option value="concluida" <?php echo ($filtroStatus === 'concluida') ? 'selected' : ''; ?>>Concluída</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="filtroLista" class="form-label form-label-sm text-muted">Lista</label>
                            <select class="form-select form-select-sm" id="filtroLista" name="lista">
                                <option value="">Todas as listas</option>
                                <?php for ($i = 0; $i < count($listas); $i++) : ?>
                                <option value="<?php echo $listas[$i]['id']; ?>" <?php echo ($filtroLista == $listas[$i]['id']) ? 'selected' : ''; ?>>
                                    <?php echo $listas[$i]['nome']; ?>
                                </option>
                                <?php endfor; ?>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-sm btn-gaia-outline w-100">
                                <i class="bi bi-funnel"></i> Filtrar
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Lista de Tarefas -->
                <div class="row g-3">
                    <?php for ($i = 0; $i < count($tarefas); $i++) : ?>
                    <?php $t = $tarefas[$i]; ?>
                    <div class="col-12">
                        <div class="tarefa-card">
                            <div class="tarefa-card-header">
                                <div>
                                    <h6 class="tarefa-titulo"><?php echo $t['titulo']; ?></h6>
                                    <p class="tarefa-descricao"><?php echo $t['descricao']; ?></p>
                                </div>
                                <?php if ($perfilUsuario === 'editor') : ?>
                                <div class="tarefa-acoes">
                                    <button class="btn btn-sm btn-gaia-outline btn-editar-tarefa" title="Editar"
                                            data-bs-toggle="modal" data-bs-target="#modalEditarTarefa"
                                            data-id="<?php echo $t['id']; ?>"
                                            data-titulo="<?php echo htmlspecialchars($t['titulo']); ?>"
                                            data-descricao="<?php echo htmlspecialchars($t['descricao']); ?>"
                                            data-lista="<?php echo $t['lista_id']; ?>"
                                            data-status="<?php echo $t['status']; ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="acoes/tarefa_excluir.php" method="POST" class="d-inline">
                                        <input type="hidden" name="tarefa_id" value="<?php echo $t['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="tarefa-card-footer">
                                <span class="badge-lista"><?php echo $t['lista']; ?></span>

                                <?php if ($t['status'] === 'pendente') : ?>
                                    <span class="status-badge status-pendente">
                                        <i class="bi bi-clock"></i> Pendente
                                    </span>
                                <?php elseif ($t['status'] === 'andamento') : ?>
                                    <span class="status-badge status-andamento">
                                        <i class="bi bi-arrow-repeat"></i> Em Andamento
                                    </span>
                                <?php else : ?>
                                    <span class="status-badge status-concluida">
                                        <i class="bi bi-check-circle"></i> Concluída
                                    </span>
                                <?php endif; ?>

                                <a href="tarefa_detalhes.php?id=<?php echo $t['id']; ?>" class="tarefa-meta tarefa-meta-link" title="Ver comentários">
                                    <i class="bi bi-chat-dots"></i> <?php echo $t['comentarios']; ?> comentário(s)
                                </a>
                                <span class="tarefa-meta">
                                    <i class="bi bi-calendar3"></i> <?php echo $t['data_criacao']; ?>
                                </span>
                            </div>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>

            </div>
        </section>

        <!-- Modal Nova Tarefa -->
        <div class="modal fade" id="modalNovaTarefa" tabindex="-1" aria-labelledby="modalNovaTarefaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-gaia">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNovaTarefaLabel">
                            <i class="bi bi-plus-circle"></i> Nova Tarefa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form id="formNovaTarefa" action="acoes/tarefa_criar.php" method="POST" novalidate>
                        <div class="modal-body">
                            <!-- Título -->
                            <div class="mb-3">
                                <label for="tarefaTitulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="tarefaTitulo" name="titulo"
                                       placeholder="Nome da tarefa" required>
                                <div class="invalid-feedback-custom"></div>
                            </div>

                            <!-- Descrição -->
                            <div class="mb-3">
                                <label for="tarefaDescricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="tarefaDescricao" name="descricao"
                                          rows="3" placeholder="Descreva a tarefa"></textarea>
                            </div>

                            <!-- Lista -->
                            <div class="mb-3">
                                <label for="tarefaLista" class="form-label">Lista</label>
                                <select class="form-select" id="tarefaLista" name="lista_id" required>
                                    <option value="">Selecione uma lista</option>
                                    <?php for ($i = 0; $i < count($listas); $i++) : ?>
                                    <option value="<?php echo $listas[$i]['id']; ?>"><?php echo $listas[$i]['nome']; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <div class="invalid-feedback-custom"></div>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="tarefaStatus" class="form-label">Status</label>
                                <select class="form-select" id="tarefaStatus" name="status">
                                    <option value="pendente" selected>Pendente</option>
                                    <option value="andamento">Em Andamento</option>
                                    <option value="concluida">Concluída</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-gaia-primary">
                                <i class="bi bi-check-lg"></i> Criar Tarefa
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Tarefa -->
        <div class="modal fade" id="modalEditarTarefa" tabindex="-1" aria-labelledby="modalEditarTarefaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-gaia">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarTarefaLabel">
                            <i class="bi bi-pencil-square"></i> Editar Tarefa
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form id="formEditarTarefa" action="acoes/tarefa_editar.php" method="POST" novalidate>
                        <input type="hidden" id="editarTarefaId" name="tarefa_id" value="">
                        <div class="modal-body">
                            <!-- Título -->
                            <div class="mb-3">
                                <label for="editarTarefaTitulo" class="form-label">Título</label>
                                <input type="text" class="form-control" id="editarTarefaTitulo" name="titulo"
                                       placeholder="Nome da tarefa" required>
                                <div class="invalid-feedback-custom"></div>
                            </div>

                            <!-- Descrição -->
                            <div class="mb-3">
                                <label for="editarTarefaDescricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="editarTarefaDescricao" name="descricao"
                                          rows="3" placeholder="Descreva a tarefa"></textarea>
                            </div>

                            <!-- Lista -->
                            <div class="mb-3">
                                <label for="editarTarefaLista" class="form-label">Lista</label>
                                <select class="form-select" id="editarTarefaLista" name="lista_id" required>
                                    <option value="">Selecione uma lista</option>
                                    <?php for ($i = 0; $i < count($listas); $i++) : ?>
                                    <option value="<?php echo $listas[$i]['id']; ?>"><?php echo $listas[$i]['nome']; ?></option>
                                    <?php endfor; ?>
                                </select>
                                <div class="invalid-feedback-custom"></div>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="editarTarefaStatus" class="form-label">Status</label>
                                <select class="form-select" id="editarTarefaStatus" name="status">
                                    <option value="pendente">Pendente</option>
                                    <option value="andamento">Em Andamento</option>
                                    <option value="concluida">Concluída</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-gaia-primary">
                                <i class="bi bi-check-lg"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php require_once 'includes/footer.php'; ?>
