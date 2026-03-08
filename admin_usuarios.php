<?php
$tituloPagina = 'Administração de Usuários';
$paginaAtiva = 'admin';
require_once 'includes/header_privado.php';

/* Somente editores podem acessar esta pagina */
if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'editor') {
    header('Location: dashboard.php');
    exit();
}

/* Buscar todos os usuarios do BD */
require_once 'includes/conexao.php';

$stmt = $PDO->prepare("SELECT id, nome, email, perfil, data_cadastro FROM usuarios ORDER BY id");
$stmt->execute();
$usuarios = array();
$row = $stmt->fetch(PDO::FETCH_OBJ);
while ($row) {
    $usuarios[] = array(
        'id' => $row->id,
        'nome' => $row->nome,
        'email' => $row->email,
        'perfil' => $row->perfil,
        'data_cadastro' => date('d/m/Y', strtotime($row->data_cadastro))
    );
    $row = $stmt->fetch(PDO::FETCH_OBJ);
}
?>

        <!-- Admin Usuários -->
        <section class="page-section">
            <div class="container">

                <!-- Cabeçalho -->
                <div class="page-header">
                    <div>
                        <h2><i class="bi bi-gear"></i> Administração de Usuários</h2>
                        <p class="text-muted">Gerencie os usuários do sistema</p>
                    </div>
                </div>

                <!-- Tabela de Usuários -->
                <div class="dash-table-card">
                    <div class="dash-table-header">
                        <h5><i class="bi bi-people"></i> Usuários Cadastrados</h5>
                        <span class="badge bg-gaia"><?php echo count($usuarios); ?> usuários</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover dash-table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Perfil</th>
                                    <th>Cadastro</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php for ($i = 0; $i < count($usuarios); $i++) : ?>
                                <?php $u = $usuarios[$i]; ?>
                                <tr>
                                    <td class="fw-semibold">
                                        <i class="bi bi-person-fill text-muted"></i> <?php echo $u['nome']; ?>
                                    </td>
                                    <td class="text-muted"><?php echo $u['email']; ?></td>
                                    <td>
                                        <?php if ($u['perfil'] === 'editor') : ?>
                                            <span class="status-badge status-concluida">
                                                <i class="bi bi-pencil-square"></i> Editor
                                            </span>
                                        <?php elseif ($u['perfil'] === 'comentador') : ?>
                                            <span class="status-badge status-andamento">
                                                <i class="bi bi-chat-dots"></i> Comentador
                                            </span>
                                        <?php else : ?>
                                            <span class="status-badge status-pendente">
                                                <i class="bi bi-eye"></i> Visualizador
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-muted"><?php echo $u['data_cadastro']; ?></td>
                                    <td>
                                        <div class="d-flex gap-1">
                                            <button class="btn btn-sm btn-gaia-outline btn-editar-usuario" title="Alterar Perfil"
                                                    data-bs-toggle="modal" data-bs-target="#modalEditarUsuario"
                                                    data-id="<?php echo $u['id']; ?>"
                                                    data-perfil="<?php echo $u['perfil']; ?>">
                                                <i class="bi bi-pencil"></i>
                                            </button>
                                            <form action="acoes/admin_excluir.php" method="POST" class="d-inline">
                                                <input type="hidden" name="usuario_id" value="<?php echo $u['id']; ?>">
                                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Excluir Usu&#225;rio">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <?php endfor; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </section>

        <!-- Modal Editar Usuário -->
        <div class="modal fade" id="modalEditarUsuario" tabindex="-1" aria-labelledby="modalEditarUsuarioLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content modal-gaia">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarUsuarioLabel">
                            <i class="bi bi-pencil-square"></i> Alterar Perfil do Usuário
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                    </div>
                    <form id="formEditarUsuario" action="acoes/admin_atualizar.php" method="POST">
                        <input type="hidden" id="editarUsuarioId" name="usuario_id" value="">
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="editarUsuarioPerfil" class="form-label">Perfil de Acesso</label>
                                <select class="form-select" id="editarUsuarioPerfil" name="perfil" required>
                                    <option value="editor">Editor - Permissões completas</option>
                                    <option value="comentador">Comentador - Visualizar e comentar</option>
                                    <option value="visualizador">Visualizador - Somente leitura</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-gaia-primary">
                                <i class="bi bi-check-lg"></i> Salvar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

<?php require_once 'includes/footer.php'; ?>
