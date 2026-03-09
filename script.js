document.addEventListener('DOMContentLoaded', function () {

    /* --- Validacao do Formulario de Login --- */
    var formLogin = document.getElementById('formLogin');
    if (formLogin) {
        formLogin.addEventListener('submit', function (e) {
            var valido = true;

            var email = document.getElementById('loginEmail');
            var senha = document.getElementById('loginSenha');

            /* Limpar estados anteriores */
            limparValidacao(email);
            limparValidacao(senha);

            /* Validar email */
            if (email.value.length === 0) {
                mostrarErro(email, 'Por favor, informe seu e-mail.');
                valido = false;
            } else if (email.value.indexOf('@') === -1 || email.value.indexOf('.') === -1) {
                mostrarErro(email, 'Por favor, informe um e-mail valido.');
                valido = false;
            } else {
                mostrarSucesso(email);
            }

            /* Validar senha */
            if (senha.value.length === 0) {
                mostrarErro(senha, 'Por favor, informe sua senha.');
                valido = false;
            } else {
                mostrarSucesso(senha);
            }

            if (!valido) {
                e.preventDefault();
            }
        });
    }

    /* --- Validacao do Formulario de Cadastro --- */
    var formCadastro = document.getElementById('formCadastro');
    if (formCadastro) {
        formCadastro.addEventListener('submit', function (e) {
            var valido = true;

            var nome = document.getElementById('cadastroNome');
            var email = document.getElementById('cadastroEmail');
            var senha = document.getElementById('cadastroSenha');
            var confirmarSenha = document.getElementById('cadastroConfirmarSenha');
            var perfil = document.getElementById('cadastroPerfil');

            /* Limpar estados anteriores */
            limparValidacao(nome);
            limparValidacao(email);
            limparValidacao(senha);
            limparValidacao(confirmarSenha);
            limparValidacao(perfil);

            /* Validar nome */
            if (nome.value.length === 0) {
                mostrarErro(nome, 'Por favor, informe seu nome.');
                valido = false;
            } else if (nome.value.length < 3) {
                mostrarErro(nome, 'O nome deve ter pelo menos 3 caracteres.');
                valido = false;
            } else {
                mostrarSucesso(nome);
            }

            /* Validar email */
            if (email.value.length === 0) {
                mostrarErro(email, 'Por favor, informe seu e-mail.');
                valido = false;
            } else if (email.value.indexOf('@') === -1 || email.value.indexOf('.') === -1) {
                mostrarErro(email, 'Por favor, informe um e-mail valido.');
                valido = false;
            } else {
                mostrarSucesso(email);
            }

            /* Validar senha */
            if (senha.value.length === 0) {
                mostrarErro(senha, 'Por favor, informe uma senha.');
                valido = false;
            } else if (senha.value.length < 8) {
                mostrarErro(senha, 'A senha deve ter pelo menos 8 caracteres.');
                valido = false;
            } else {
                mostrarSucesso(senha);
            }

            /* Validar confirmacao de senha */
            if (confirmarSenha.value.length === 0) {
                mostrarErro(confirmarSenha, 'Por favor, confirme sua senha.');
                valido = false;
            } else if (confirmarSenha.value !== senha.value) {
                mostrarErro(confirmarSenha, 'As senhas nao coincidem.');
                valido = false;
            } else {
                mostrarSucesso(confirmarSenha);
            }

            /* Validar perfil */
            if (perfil.value === '') {
                mostrarErro(perfil, 'Por favor, selecione um perfil.');
                valido = false;
            } else {
                mostrarSucesso(perfil);
            }

            if (!valido) {
                e.preventDefault();
            }
        });
    }

    /* --- Funcoes Auxiliares --- */

    function mostrarErro(campo, mensagem) {
        /* Adicionar classe de erro ao campo */
        var classes = campo.className;
        if (classes.indexOf('is-invalid-custom') === -1) {
            campo.className = classes + ' is-invalid-custom';
        }
        /* Remover classe de sucesso se existir */
        campo.className = removerTexto(campo.className, ' is-valid-custom');

        /* Encontrar ou criar o elemento de feedback */
        var container = campo.parentNode;
        var feedback = container.querySelector('.invalid-feedback-custom');
        if (!feedback) {
            feedback = document.createElement('div');
            feedback.className = 'invalid-feedback-custom';
            container.appendChild(feedback);
        }
        feedback.textContent = mensagem;
        feedback.className = 'invalid-feedback-custom show';
    }

    function mostrarSucesso(campo) {
        var classes = campo.className;
        /* Adicionar classe de sucesso */
        if (classes.indexOf('is-valid-custom') === -1) {
            campo.className = classes + ' is-valid-custom';
        }
        /* Remover classe de erro se existir */
        campo.className = removerTexto(campo.className, ' is-invalid-custom');

        /* Esconder feedback de erro se existir */
        var container = campo.parentNode;
        var feedback = container.querySelector('.invalid-feedback-custom');
        if (feedback) {
            feedback.className = 'invalid-feedback-custom';
        }
    }

    function removerTexto(texto, trecho) {
        var pos = texto.indexOf(trecho);
        if (pos === -1) {
            return texto;
        }
        return texto.substr(0, pos) + texto.substr(pos + trecho.length);
    }

    function limparValidacao(campo) {
        campo.className = removerTexto(campo.className, ' is-invalid-custom');
        campo.className = removerTexto(campo.className, ' is-valid-custom');

        var container = campo.parentNode;
        var feedback = container.querySelector('.invalid-feedback-custom');
        if (feedback) {
            feedback.className = 'invalid-feedback-custom';
        }
    }

    /* --- Validacao Nova Tarefa --- */
    var formNovaTarefa = document.getElementById('formNovaTarefa');
    if (formNovaTarefa) {
        formNovaTarefa.addEventListener('submit', function (e) {
            var valido = true;
            var titulo = document.getElementById('tarefaTitulo');
            var lista = document.getElementById('tarefaLista');

            limparValidacao(titulo);
            limparValidacao(lista);

            if (titulo.value.length === 0) {
                mostrarErro(titulo, 'Informe o titulo da tarefa.');
                valido = false;
            } else if (titulo.value.length < 3) {
                mostrarErro(titulo, 'O titulo deve ter pelo menos 3 caracteres.');
                valido = false;
            } else {
                mostrarSucesso(titulo);
            }

            if (lista.value === '') {
                mostrarErro(lista, 'Selecione uma lista.');
                valido = false;
            } else {
                mostrarSucesso(lista);
            }

            if (!valido) {
                e.preventDefault();
            }
        });
    }

    /* --- Validacao Nova Lista --- */
    var formNovaLista = document.getElementById('formNovaLista');
    if (formNovaLista) {
        formNovaLista.addEventListener('submit', function (e) {
            var valido = true;
            var nome = document.getElementById('listaNome');

            limparValidacao(nome);

            if (nome.value.length === 0) {
                mostrarErro(nome, 'Informe o nome da lista.');
                valido = false;
            } else if (nome.value.length < 2) {
                mostrarErro(nome, 'O nome deve ter pelo menos 2 caracteres.');
                valido = false;
            } else {
                mostrarSucesso(nome);
            }

            if (!valido) {
                e.preventDefault();
            }
        });
    }

    /* --- Validacao Editar Perfil --- */
    var formEditarPerfil = document.getElementById('formEditarPerfil');
    if (formEditarPerfil) {
        formEditarPerfil.addEventListener('submit', function (e) {
            var valido = true;
            var nome = document.getElementById('perfilNome');
            var email = document.getElementById('perfilEmail');

            limparValidacao(nome);
            limparValidacao(email);

            if (nome.value.length === 0) {
                mostrarErro(nome, 'Informe seu nome.');
                valido = false;
            } else if (nome.value.length < 3) {
                mostrarErro(nome, 'O nome deve ter pelo menos 3 caracteres.');
                valido = false;
            } else {
                mostrarSucesso(nome);
            }

            if (email.value.length === 0) {
                mostrarErro(email, 'Informe seu e-mail.');
                valido = false;
            } else if (email.value.indexOf('@') === -1 || email.value.indexOf('.') === -1) {
                mostrarErro(email, 'Informe um e-mail valido.');
                valido = false;
            } else {
                mostrarSucesso(email);
            }

            if (!valido) {
                e.preventDefault();
            }
        });
    }

    /* --- Validacao Alterar Senha --- */
    var formAlterarSenha = document.getElementById('formAlterarSenha');
    if (formAlterarSenha) {
        formAlterarSenha.addEventListener('submit', function (e) {
            var valido = true;
            var senhaAtual = document.getElementById('senhaAtual');
            var senhaNova = document.getElementById('senhaNova');
            var senhaConfirmar = document.getElementById('senhaConfirmar');

            limparValidacao(senhaAtual);
            limparValidacao(senhaNova);
            limparValidacao(senhaConfirmar);

            if (senhaAtual.value.length === 0) {
                mostrarErro(senhaAtual, 'Informe sua senha atual.');
                valido = false;
            } else {
                mostrarSucesso(senhaAtual);
            }

            if (senhaNova.value.length === 0) {
                mostrarErro(senhaNova, 'Informe a nova senha.');
                valido = false;
            } else if (senhaNova.value.length < 8) {
                mostrarErro(senhaNova, 'A senha deve ter pelo menos 8 caracteres.');
                valido = false;
            } else {
                mostrarSucesso(senhaNova);
            }

            if (senhaConfirmar.value.length === 0) {
                mostrarErro(senhaConfirmar, 'Confirme a nova senha.');
                valido = false;
            } else if (senhaConfirmar.value !== senhaNova.value) {
                mostrarErro(senhaConfirmar, 'As senhas nao coincidem.');
                valido = false;
            } else {
                mostrarSucesso(senhaConfirmar);
            }

            if (!valido) {
                e.preventDefault();
            }
        });
    }

    /* --- Populacao do Modal Editar Tarefa --- */
    var btnsEditarTarefa = document.querySelectorAll('.btn-editar-tarefa');
    for (var i = 0; i < btnsEditarTarefa.length; i++) {
        btnsEditarTarefa[i].addEventListener('click', function () {
            var btn = this;
            document.getElementById('editarTarefaId').value = btn.getAttribute('data-id');
            document.getElementById('editarTarefaTitulo').value = btn.getAttribute('data-titulo');
            document.getElementById('editarTarefaDescricao').value = btn.getAttribute('data-descricao');
            document.getElementById('editarTarefaLista').value = btn.getAttribute('data-lista');
            document.getElementById('editarTarefaStatus').value = btn.getAttribute('data-status');
        });
    }

    /* --- Validacao Editar Tarefa --- */
    var formEditarTarefa = document.getElementById('formEditarTarefa');
    if (formEditarTarefa) {
        formEditarTarefa.addEventListener('submit', function (e) {
            var valido = true;
            var titulo = document.getElementById('editarTarefaTitulo');
            var lista = document.getElementById('editarTarefaLista');

            limparValidacao(titulo);
            limparValidacao(lista);

            if (titulo.value.length === 0) {
                mostrarErro(titulo, 'Informe o titulo da tarefa.');
                valido = false;
            } else if (titulo.value.length < 3) {
                mostrarErro(titulo, 'O titulo deve ter pelo menos 3 caracteres.');
                valido = false;
            } else {
                mostrarSucesso(titulo);
            }

            if (lista.value === '') {
                mostrarErro(lista, 'Selecione uma lista.');
                valido = false;
            } else {
                mostrarSucesso(lista);
            }

            if (!valido) {
                e.preventDefault();
            }
        });
    }

    /* --- Populacao do Modal Editar Lista --- */
    var btnsEditarLista = document.querySelectorAll('.btn-editar-lista');
    for (var j = 0; j < btnsEditarLista.length; j++) {
        btnsEditarLista[j].addEventListener('click', function () {
            var btn = this;
            document.getElementById('editarListaId').value = btn.getAttribute('data-id');
            document.getElementById('editarListaNome').value = btn.getAttribute('data-nome');
            document.getElementById('editarListaDescricao').value = btn.getAttribute('data-descricao');
        });
    }

    /* --- Validacao Editar Lista --- */
    var formEditarLista = document.getElementById('formEditarLista');
    if (formEditarLista) {
        formEditarLista.addEventListener('submit', function (e) {
            var valido = true;
            var nome = document.getElementById('editarListaNome');

            limparValidacao(nome);

            if (nome.value.length === 0) {
                mostrarErro(nome, 'Informe o nome da lista.');
                valido = false;
            } else if (nome.value.length < 2) {
                mostrarErro(nome, 'O nome deve ter pelo menos 2 caracteres.');
                valido = false;
            } else {
                mostrarSucesso(nome);
            }

            if (!valido) {
                e.preventDefault();
            }
        });
    }

    /* --- Populacao do Modal Editar Usuario (Admin) --- */
    var btnsEditarUsuario = document.querySelectorAll('.btn-editar-usuario');
    for (var k = 0; k < btnsEditarUsuario.length; k++) {
        btnsEditarUsuario[k].addEventListener('click', function () {
            var btn = this;
            document.getElementById('editarUsuarioId').value = btn.getAttribute('data-id');
            document.getElementById('editarUsuarioPerfil').value = btn.getAttribute('data-perfil');
        });
    }

    /* ========================================
       Busca AJAX de Tarefas (Fetch API)
    ======================================== */
    var btnBuscaAjax = document.getElementById('btnBuscaAjax');
    var campoBusca = document.getElementById('buscaTarefa');

    if (btnBuscaAjax && campoBusca) {
        btnBuscaAjax.addEventListener('click', function () {
            var termo = campoBusca.value;
            var divMensagem = document.getElementById('buscaAjaxMensagem');
            var divResultados = document.getElementById('buscaAjaxResultados');

            /* Limpar resultados anteriores */
            divMensagem.removeAttribute('hidden');
            divResultados.removeAttribute('hidden');
            divResultados.innerHTML = '';

            /* Validar termo */
            if (termo.length < 2) {
                divMensagem.className = 'alert alert-warning mt-2';
                divMensagem.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Digite pelo menos 2 caracteres para buscar.';
                divResultados.setAttribute('hidden', '');
                return;
            }

            /* Mostrar carregando */
            divMensagem.className = 'alert alert-info mt-2';
            divMensagem.innerHTML = '<i class="bi bi-hourglass-split"></i> Buscando...';

            /* Requisição AJAX via Fetch API */
            fetch('api/buscar_tarefas.php?termo=' + encodeURIComponent(termo))
                .then(function (resposta) {
                    if (!resposta.ok) {
                        divMensagem.className = 'alert alert-danger mt-2';
                        divMensagem.innerHTML = '<i class="bi bi-x-circle"></i> Erro ao buscar tarefas (código ' + resposta.status + '). Tente novamente.';
                        divResultados.setAttribute('hidden', '');
                        return null;
                    }
                    return resposta.json();
                })
                .then(function (dados) {
                    if (!dados) {
                        return;
                    }
                    if (dados.quantidade > 0) {
                        divMensagem.className = 'alert alert-success mt-2';
                        divMensagem.innerHTML = '<i class="bi bi-check-circle"></i> Foram encontradas ' + dados.quantidade + ' tarefa(s) para "<strong>' + termo + '</strong>".';

                        /* Montar cards de resultado */
                        var html = '';
                        for (var i = 0; i < dados.tarefas.length; i++) {
                            var t = dados.tarefas[i];

                            var statusClasse = 'status-pendente';
                            var statusTexto = 'Pendente';
                            var statusIcone = 'bi-clock';
                            if (t.status === 'andamento') {
                                statusClasse = 'status-andamento';
                                statusTexto = 'Em Andamento';
                                statusIcone = 'bi-arrow-repeat';
                            } else if (t.status === 'concluida') {
                                statusClasse = 'status-concluida';
                                statusTexto = 'Concluída';
                                statusIcone = 'bi-check-circle';
                            }

                            html = html + '<div class="busca-resultado-card">';
                            html = html + '<div class="busca-resultado-header">';
                            html = html + '<a href="tarefa_detalhes.php?id=' + t.id + '" class="busca-resultado-titulo">' + t.titulo + '</a>';
                            html = html + '<span class="status-badge ' + statusClasse + '"><i class="bi ' + statusIcone + '"></i> ' + statusTexto + '</span>';
                            html = html + '</div>';
                            if (t.descricao !== '') {
                                html = html + '<p class="busca-resultado-descricao">' + t.descricao + '</p>';
                            }
                            html = html + '<div class="busca-resultado-meta">';
                            html = html + '<span class="badge-lista">' + t.lista + '</span>';
                            html = html + '<span class="tarefa-meta"><i class="bi bi-calendar3"></i> ' + t.data_criacao + '</span>';
                            html = html + '</div>';
                            html = html + '</div>';
                        }
                        divResultados.innerHTML = html;
                    } else {
                        divMensagem.className = 'alert alert-danger mt-2';
                        divMensagem.innerHTML = '<i class="bi bi-x-circle"></i> Nenhuma tarefa encontrada para "<strong>' + termo + '</strong>".';
                        divResultados.setAttribute('hidden', '');
                    }
                })
                .then(null, function () {
                    divMensagem.className = 'alert alert-danger mt-2';
                    divMensagem.innerHTML = '<i class="bi bi-exclamation-triangle"></i> Erro de conexão ao buscar tarefas. Verifique sua internet e tente novamente.';
                    divResultados.setAttribute('hidden', '');
                });
        });

        /* Permitir buscar com Enter */
        campoBusca.addEventListener('keydown', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                btnBuscaAjax.click();
            }
        });
    }

    /* ========================================
       Confirmação - Excluir Conta
    ======================================== */
    var formExcluirConta = document.getElementById('formExcluirConta');
    if (formExcluirConta) {
        formExcluirConta.addEventListener('submit', function (e) {
            var confirmacao = confirm('Tem certeza que deseja excluir sua conta? Esta ação é irreversível!');
            if (!confirmacao) {
                e.preventDefault();
            }
        });
    }

    /* ========================================
       Linhas Clicáveis (Dashboard)
    ======================================== */
    var linhasClicaveis = document.querySelectorAll('[data-href]');
    for (var idx = 0; idx < linhasClicaveis.length; idx++) {
        linhasClicaveis[idx].addEventListener('click', function () {
            window.location = this.getAttribute('data-href');
        });
    }

});
