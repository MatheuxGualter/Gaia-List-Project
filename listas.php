<?php
$tituloPagina = 'Listas';
$paginaAtiva = 'listas';
require_once 'includes/header_privado.php';

/* Dados simulados */
$listas = array(
    array('id' => 1, 'nome' => 'Design', 'descricao' => 'Tarefas relacionadas ao design e UI/UX', 'total_tarefas' => 3, 'concluidas' => 1),
    array('id' => 2, 'nome' => 'Backend', 'descricao' => 'Desenvolvimento do servidor e banco de dados', 'total_tarefas' => 5, 'concluidas' => 2),
    array('id' => 3, 'nome' => 'Testes', 'descricao' => 'Testes e controle de qualidade', 'total_tarefas' => 4, 'concluidas' => 0)
);

$perfilUsuario = isset($_SESSION['perfil']) ? $_SESSION['perfil'] : 'editor';
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
                                    <button class="btn btn-sm btn-gaia-outline" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
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

<?php require_once 'includes/footer.php'; ?>
