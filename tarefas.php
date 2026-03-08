<?php
$tituloPagina = 'Tarefas';
$paginaAtiva = 'tarefas';
require_once 'includes/header_privado.php';

/* Dados simulados */
$listas = array(
    array('id' => 1, 'nome' => 'Design'),
    array('id' => 2, 'nome' => 'Backend'),
    array('id' => 3, 'nome' => 'Testes')
);

$tarefas = array(
    array('id' => 1, 'titulo' => 'Criar wireframe da página inicial', 'descricao' => 'Desenhar o layout completo da home page com todas as seções.', 'lista' => 'Design', 'status' => 'concluida', 'data_criacao' => '05/03/2026', 'comentarios' => 2),
    array('id' => 2, 'titulo' => 'Implementar autenticação de usuários', 'descricao' => 'Sistema de login e cadastro com PHP e sessões.', 'lista' => 'Backend', 'status' => 'andamento', 'data_criacao' => '06/03/2026', 'comentarios' => 1),
    array('id' => 3, 'titulo' => 'Configurar banco de dados MySQL', 'descricao' => 'Criar tabelas de usuários, tarefas, listas e comentários.', 'lista' => 'Backend', 'status' => 'andamento', 'data_criacao' => '06/03/2026', 'comentarios' => 0),
    array('id' => 4, 'titulo' => 'Escrever testes unitários', 'descricao' => 'Testar funções de CRUD e autenticação.', 'lista' => 'Testes', 'status' => 'pendente', 'data_criacao' => '06/03/2026', 'comentarios' => 0),
    array('id' => 5, 'titulo' => 'Revisar documentação do projeto', 'descricao' => 'Atualizar README e comentários no código.', 'lista' => 'Testes', 'status' => 'pendente', 'data_criacao' => '05/03/2026', 'comentarios' => 3)
);

$filtroStatus = isset($_GET['status']) ? $_GET['status'] : '';
$filtroLista = isset($_GET['lista']) ? $_GET['lista'] : '';

/* Perfil simulado — será substituido por $_SESSION na Etapa 4 */
$perfilUsuario = isset($_SESSION['perfil']) ? $_SESSION['perfil'] : 'editor';
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
                                    <button class="btn btn-sm btn-gaia-outline" title="Editar">
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger" title="Excluir">
                                        <i class="bi bi-trash"></i>
                                    </button>
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

                                <span class="tarefa-meta">
                                    <i class="bi bi-chat-dots"></i> <?php echo $t['comentarios']; ?>
                                </span>
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
                    <form id="formNovaTarefa" action="acoes/tarefa_criar.php" method="POST">
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

<?php require_once 'includes/footer.php'; ?>
