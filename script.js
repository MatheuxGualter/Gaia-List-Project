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

});
