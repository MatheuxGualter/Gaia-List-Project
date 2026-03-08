<?php
$tituloPagina = 'Detalhes da Tarefa';
$paginaAtiva = 'tarefas';
require_once 'includes/header_privado.php';
require_once 'includes/conexao.php';

$perfilUsuario = isset($_SESSION['perfil']) ? $_SESSION['perfil'] : 'visualizador';
$usuarioId = $_SESSION['usuario_id'];

/* Verificar se o ID da tarefa foi informado */
$tarefa_id = isset($_GET['id']) ? $_GET['id'] : '';
if ($tarefa_id === '') {
    header('Location: tarefas.php');
    exit();
}

/* Buscar dados da tarefa */
$stmt = $PDO->prepare("SELECT tarefas.id, tarefas.titulo, tarefas.descricao, tarefas.status, tarefas.lista_id, tarefas.data_criacao, listas.nome AS lista_nome FROM tarefas, listas WHERE tarefas.lista_id = listas.id AND tarefas.id = ?");
$stmt->bindParam(1, $tarefa_id);
$stmt->execute();
$tarefa = $stmt->fetch(PDO::FETCH_OBJ);

if (!$tarefa) {
    $_SESSION['mensagem'] = 'Tarefa nao encontrada.';
    $_SESSION['tipo_mensagem'] = 'danger';
    header('Location: tarefas.php');
    exit();
}

/* Buscar comentarios da tarefa com nome do autor */
$stmt = $PDO->prepare("SELECT comentarios.id, comentarios.texto, comentarios.data_criacao, comentarios.usuario_id, usuarios.nome AS autor_nome FROM comentarios, usuarios WHERE comentarios.usuario_id = usuarios.id AND comentarios.tarefa_id = ? ORDER BY comentarios.data_criacao DESC");
$stmt->bindParam(1, $tarefa_id);
$stmt->execute();

$comentarios = array();
$row = $stmt->fetch(PDO::FETCH_OBJ);
while ($row) {
    $comentarios[] = array(
        'id' => $row->id,
        'texto' => $row->texto,
        'autor_nome' => $row->autor_nome,
        'usuario_id' => $row->usuario_id,
        'data_criacao' => date('d/m/Y H:i', strtotime($row->data_criacao))
    );
    $row = $stmt->fetch(PDO::FETCH_OBJ);
}
?>

        <!-- Detalhes da Tarefa -->
        <section class="page-section">
            <div class="container">

                <!-- Voltar -->
                <a href="tarefas.php" class="btn btn-sm btn-gaia-outline mb-4">
                    <i class="bi bi-arrow-left"></i> Voltar para Tarefas
                </a>

                <!-- Card de Detalhes -->
                <div class="detalhe-card">
                    <div class="detalhe-card-header">
                        <div>
                            <h3 class="detalhe-titulo"><?php echo htmlspecialchars($tarefa->titulo); ?></h3>
                            <div class="detalhe-meta">
                                <span class="badge-lista">
                                    <i class="bi bi-folder"></i> <?php echo htmlspecialchars($tarefa->lista_nome); ?>
                                </span>

                                <?php if ($tarefa->status === 'pendente') : ?>
                                    <span class="status-badge status-pendente">
                                        <i class="bi bi-clock"></i> Pendente
                                    </span>
                                <?php elseif ($tarefa->status === 'andamento') : ?>
                                    <span class="status-badge status-andamento">
                                        <i class="bi bi-arrow-repeat"></i> Em Andamento
                                    </span>
                                <?php else : ?>
                                    <span class="status-badge status-concluida">
                                        <i class="bi bi-check-circle"></i> Concluída
                                    </span>
                                <?php endif; ?>

                                <span class="tarefa-meta">
                                    <i class="bi bi-calendar3"></i> <?php echo date('d/m/Y', strtotime($tarefa->data_criacao)); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <?php if ($tarefa->descricao !== null && $tarefa->descricao !== '') : ?>
                    <div class="detalhe-descricao">
                        <p><?php echo htmlspecialchars($tarefa->descricao); ?></p>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Secao de Comentarios -->
                <div class="comentarios-section">
                    <div class="comentarios-header">
                        <h4>
                            <i class="bi bi-chat-dots"></i> Comentários
                            <span class="badge bg-gaia"><?php echo count($comentarios); ?></span>
                        </h4>
                    </div>

                    <!-- Formulario de Novo Comentario (editor e comentador) -->
                    <?php if ($perfilUsuario === 'editor' || $perfilUsuario === 'comentador') : ?>
                    <div class="comentario-form-card">
                        <form action="acoes/comentario_criar.php" method="POST">
                            <input type="hidden" name="tarefa_id" value="<?php echo $tarefa->id; ?>">
                            <div class="mb-3">
                                <label for="comentarioTexto" class="form-label">Adicionar comentário</label>
                                <textarea class="form-control" id="comentarioTexto" name="texto"
                                          rows="3" placeholder="Escreva seu comentário..." required></textarea>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-gaia-primary">
                                    <i class="bi bi-send"></i> Comentar
                                </button>
                            </div>
                        </form>
                    </div>
                    <?php endif; ?>

                    <!-- Lista de Comentarios -->
                    <?php if (count($comentarios) === 0) : ?>
                    <div class="comentario-vazio">
                        <i class="bi bi-chat"></i>
                        <p>Nenhum comentário ainda.</p>
                        <?php if ($perfilUsuario === 'editor' || $perfilUsuario === 'comentador') : ?>
                        <p class="text-muted">Seja o primeiro a comentar!</p>
                        <?php endif; ?>
                    </div>
                    <?php else : ?>
                    <div class="comentarios-lista">
                        <?php for ($i = 0; $i < count($comentarios); $i++) : ?>
                        <?php $c = $comentarios[$i]; ?>
                        <div class="comentario-card">
                            <div class="comentario-card-header">
                                <div class="comentario-autor">
                                    <i class="bi bi-person-circle"></i>
                                    <strong><?php echo htmlspecialchars($c['autor_nome']); ?></strong>
                                    <span class="comentario-data"><?php echo $c['data_criacao']; ?></span>
                                </div>
                                <?php if ($c['usuario_id'] == $usuarioId || $perfilUsuario === 'editor') : ?>
                                <form action="acoes/comentario_excluir.php" method="POST" class="d-inline">
                                    <input type="hidden" name="comentario_id" value="<?php echo $c['id']; ?>">
                                    <input type="hidden" name="tarefa_id" value="<?php echo $tarefa->id; ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir comentário">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                <?php endif; ?>
                            </div>
                            <div class="comentario-texto">
                                <p><?php echo htmlspecialchars($c['texto']); ?></p>
                            </div>
                        </div>
                        <?php endfor; ?>
                    </div>
                    <?php endif; ?>

                </div>

            </div>
        </section>

<?php require_once 'includes/footer.php'; ?>
