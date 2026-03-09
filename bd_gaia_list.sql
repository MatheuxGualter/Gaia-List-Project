-- ============================================================
-- TABELA: usuarios
-- Armazena os dados dos usuarios do sistema
-- ============================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('editor', 'comentador', 'visualizador') NOT NULL DEFAULT 'visualizador',
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- ============================================================
-- TABELA: listas
-- Armazena as listas de tarefas criadas pelos editores
-- ============================================================
CREATE TABLE IF NOT EXISTS listas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    usuario_id INT NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- ============================================================
-- TABELA: tarefas
-- Armazena as tarefas vinculadas a uma lista
-- ============================================================
CREATE TABLE IF NOT EXISTS tarefas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    descricao TEXT,
    status ENUM('pendente', 'andamento', 'concluida') NOT NULL DEFAULT 'pendente',
    lista_id INT NOT NULL,
    usuario_id INT NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (lista_id) REFERENCES listas(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- ============================================================
-- TABELA: comentarios
-- Armazena os comentarios feitos em tarefas
-- ============================================================
CREATE TABLE IF NOT EXISTS comentarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    texto TEXT NOT NULL,
    tarefa_id INT NOT NULL,
    usuario_id INT NOT NULL,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (tarefa_id) REFERENCES tarefas(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- ============================================================
-- DADOS FICTICIOS DE EXEMPLO
-- Senha de todos os usuarios: 12345678
-- Hash gerado com password_hash('12345678', PASSWORD_DEFAULT)
-- ============================================================

-- Usuarios (integrantes do grupo)
INSERT INTO usuarios (nome, email, senha, perfil) VALUES
('Matheus Gualter', 'matheus@email.com', '$2y$12$9IUh/YO37XRdR3f/SZ.g/ueXk0PxD.NjUMTrhwdI.4yr7a19hUY5G', 'editor'),
('Pedro Emilio', 'pedro@email.com', '$2y$12$9IUh/YO37XRdR3f/SZ.g/ueXk0PxD.NjUMTrhwdI.4yr7a19hUY5G', 'editor'),
('Fabricio', 'fabricio@email.com', '$2y$12$9IUh/YO37XRdR3f/SZ.g/ueXk0PxD.NjUMTrhwdI.4yr7a19hUY5G', 'comentador'),
('Joao Gabriel', 'joaogabriel@email.com', '$2y$12$9IUh/YO37XRdR3f/SZ.g/ueXk0PxD.NjUMTrhwdI.4yr7a19hUY5G', 'comentador'),
('Joao Guilherme', 'joaoguilherme@email.com', '$2y$12$9IUh/YO37XRdR3f/SZ.g/ueXk0PxD.NjUMTrhwdI.4yr7a19hUY5G', 'visualizador');

-- Listas (criadas por Matheus - id 1 e Pedro - id 2)
INSERT INTO listas (nome, descricao, usuario_id) VALUES
('Design', 'Tarefas relacionadas ao design e UI/UX do projeto', 1),
('Backend', 'Desenvolvimento do servidor e banco de dados', 1),
('Testes', 'Testes e controle de qualidade', 2),
('Documentacao', 'Documentacao e manuais do projeto', 2);

-- Tarefas
INSERT INTO tarefas (titulo, descricao, status, lista_id, usuario_id) VALUES
('Criar wireframe da pagina inicial', 'Desenhar o layout completo da home page com todas as secoes.', 'concluida', 1, 1),
('Definir paleta de cores', 'Escolher as cores principais e secundarias do projeto.', 'concluida', 1, 1),
('Criar icones personalizados', 'Desenhar icones para as funcionalidades principais.', 'andamento', 1, 3),
('Implementar autenticacao de usuarios', 'Sistema de login e cadastro com PHP e sessoes.', 'andamento', 2, 1),
('Configurar banco de dados MySQL', 'Criar tabelas de usuarios, tarefas, listas e comentarios.', 'concluida', 2, 2),
('Criar API de tarefas', 'Endpoints para CRUD de tarefas.', 'pendente', 2, 2),
('Escrever testes de autenticacao', 'Testar fluxo de login, cadastro e logout.', 'pendente', 3, 4),
('Testar formularios de cadastro', 'Validar campos obrigatorios e formatos.', 'pendente', 3, 5),
('Revisar documentacao do projeto', 'Atualizar README e comentarios no codigo.', 'andamento', 4, 1),
('Criar manual do usuario', 'Escrever guia de uso do sistema para novos usuarios.', 'pendente', 4, 2);

-- Comentarios
INSERT INTO comentarios (texto, tarefa_id, usuario_id) VALUES
('O wireframe ficou otimo! Aprovado pela equipe.', 1, 3),
('Sugiro adicionar uma secao de depoimentos na home.', 1, 4),
('A paleta roxa ficou muito elegante.', 2, 3),
('Precisamos definir o fluxo de recuperacao de senha.', 4, 4),
('Tabelas criadas com sucesso, testei com dados de exemplo.', 5, 3),
('A documentacao precisa incluir os endpoints da API.', 9, 4),
('Vou revisar a secao de instalacao do README.', 9, 5);
