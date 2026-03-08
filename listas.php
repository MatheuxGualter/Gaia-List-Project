<?php
$tituloPagina = 'Listas';
$paginaAtiva = 'listas';
require_once 'includes/header_privado.php';

/* Dados reais do banco */
require_once 'includes/conexao.php';

$perfilUsuario = isset($_SESSION['perfil']) ? $_SESSION['perfil'] : 'visualizador';

/* Buscar todas as listas */
$stmt = $PDO->prepare("SELECT id, nome, descricao FROM listas ORDER BY id");
$stmt->execute();

$listas = array();
$row = $stmt->fetch(PDO::FETCH_OBJ);
while ($row) {
    $listas[] = array(
        'id' => $row->id,
        'nome' => $row->nome,
        'descricao' => $row->descricao !== null ? $row->descricao : ''
    );
    $row = $stmt->fetch(PDO::FETCH_OBJ);
}

/* Contar tarefas por lista (sem GROUP BY) */
$stmt = $PDO->prepare("SELECT lista_id, status FROM tarefas");
$stmt->execute();
$contadorTotal = array();
$contadorConcluidas = array();
$rowT = $stmt->fetch(PDO::FETCH_OBJ);
while ($rowT) {
    if (isset($contadorTotal[$rowT->lista_id])) {
        $contadorTotal[$rowT->lista_id] = $contadorTotal[$rowT->lista_id] + 1;
    } else {
        $contadorTotal[$rowT->lista_id] = 1;
    }
    if ($rowT->status === 'concluida') {
        if (isset($contadorConcluidas[$rowT->lista_id])) {
            $contadorConcluidas[$rowT->lista_id] = $contadorConcluidas[$rowT->lista_id] + 1;
        } else {
            $contadorConcluidas[$rowT->lista_id] = 1;
        }
    }
    $rowT = $stmt->fetch(PDO::FETCH_OBJ);
}

/* Adicionar contagem ao array de listas */
for ($i = 0; $i < count($listas); $i++) {
    $lid = $listas[$i]['id'];
    $listas[$i]['total_tarefas'] = isset($contadorTotal[$lid]) ? $contadorTotal[$lid] : 0;
    $listas[$i]['concluidas'] = isset($contadorConcluidas[$lid]) ? $contadorConcluidas[$lid] : 0;
}
?>

        <!-- Listas -->
        <section class="page-section">
            <div class="container">

                <!-- Cabeçalho -->
                <div class="page-header">
                    <div>
                        <h2><i class="bi bi-folder"></i> Listas</h2>
                        <p class="text-muted">Organize suas tarefas em listas</p>
                    </div>
                    <?php if ($perfilUsuario === 'editor') : ?>
                    <button type="button" class="btn btn-gaia-primary" data-bs-toggle="modal" data-bs-target="#modalNovaLista">
                        <i class="bi bi-plus-lg"></i> Nova Lista
                    </button>
                    <?php endif; ?>
                </div>

                <!-- Cards de Listas -->
                <div class="row g-4">
                    <?php for ($i = 0; $i < count($listas); $i++) : ?>
                    <?php $lista = $listas[$i]; ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="lista-card">
                            <div class="lista-card-header">
                                <h5>
                                    <i class="bi bi-folder-fill"></i> <?php echo $lista['nome']; ?>
                                </h5>
                                <?php if ($perfilUsuario === 'editor') : ?>
                                <div class="lista-acoes">
                                    <button class="btn btn-sm btn-gaia-outline btn-editar-lista" title="Editar"
                                            data-bs-toggle="modal" data-bs-target="#modalEditarLista"
                                            data-id="<?php echo $lista['id']; ?>"
                                            data-nome="<?php echo htmlspecialchars($lista['nome']); ?>"
                                            data-descricao="<?php echo htmlspecialchars($lista['descricao']); ?>">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <form action="acoes/lista_excluir.php" method="POST" class="d-inline">
                                        <input type="hidden" name="lista_id" value="<?php echo $lista['id']; ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                <?php endif; ?>
                            </div>
                            <p class="lista-descricao"><?php echo $lista['descricao']; ?></p>
                            <div class="lista-stats">
                                <span class="lista-stat">
                                    <i class="bi bi-list-check"></i> <?php echo $lista['total_tarefas']; ?> tarefas
                                </span>
                                <span class="lista-stat">
                                    <i class="bi bi-check-circle"></i> <?php echo $lista['concluidas']; ?> concluídas
                                </span>
                            </div>
                            <a href="tarefas.php?lista=<?php echo $lista['id']; ?>" class="btn btn-sm btn-gaia-outline w-100 mt-3">
                                <i class="bi bi-eye"></i> Ver Tarefas
                            </a>
                        </div>
                    </div>
                    <?php endfor; ?>
                </div>

            </div>
        </section>

        <!-- Modal Nova Lista -->
        <div class="modal fade" id="modalNovaLista" tabindex="-1" aria-labelledby="modalNovaListaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-gaia">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalNovaListaLabel">
                            <i class="bi bi-folder-plus"></i> Nova Lista
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form id="formNovaLista" action="acoes/lista_criar.php" method="POST">
                        <div class="modal-body">
                            <!-- Nome -->
                            <div class="mb-3">
                                <label for="listaNome" class="form-label">Nome da Lista</label>
                                <input type="text" class="form-control" id="listaNome" name="nome"
                                       placeholder="Ex: Design, Backend..." required>
                                <div class="invalid-feedback-custom"></div>
                            </div>

                            <!-- Descrição -->
                            <div class="mb-3">
                                <label for="listaDescricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="listaDescricao" name="descricao"
                                          rows="3" placeholder="Descreva o objetivo desta lista"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-gaia-primary">
                                <i class="bi bi-check-lg"></i> Criar Lista
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Editar Lista -->
        <div class="modal fade" id="modalEditarLista" tabindex="-1" aria-labelledby="modalEditarListaLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-gaia">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarListaLabel">
                            <i class="bi bi-pencil-square"></i> Editar Lista
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form id="formEditarLista" action="acoes/lista_editar.php" method="POST">
                        <input type="hidden" id="editarListaId" name="lista_id" value="">
                        <div class="modal-body">
                            <!-- Nome -->
                            <div class="mb-3">
                                <label for="editarListaNome" class="form-label">Nome da Lista</label>
                                <input type="text" class="form-control" id="editarListaNome" name="nome"
                                       placeholder="Ex: Design, Backend..." required>
                                <div class="invalid-feedback-custom"></div>
                            </div>

                            <!-- Descrição -->
                            <div class="mb-3">
                                <label for="editarListaDescricao" class="form-label">Descrição</label>
                                <textarea class="form-control" id="editarListaDescricao" name="descricao"
                                          rows="3" placeholder="Descreva o objetivo desta lista"></textarea>
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
