-- ============================================================
-- PROJETOBASE - BANCO DE DADOS COMPLETO
-- ============================================================

-- ============================================================
-- CRIA O BANCO DE DADOS
-- ============================================================
CREATE DATABASE IF NOT EXISTS ProjetoBase;
USE ProjetoBase;

-- ============================================================
-- TABELAS LOOKUP / REFERÊNCIA
-- ============================================================

CREATE TABLE IF NOT EXISTS perfil (
    id_perfil INT PRIMARY KEY AUTO_INCREMENT,
    perfil VARCHAR(20) UNIQUE NOT NULL
);

INSERT IGNORE INTO perfil(id_perfil, perfil) VALUES 
(1, 'Master'),
(2, 'Admin'),
(3, 'Operador'),
(4, 'Usuario');

-- ============================================================
-- TABELA CORE: USUÁRIO
-- ============================================================

CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(15),
    data_nascimento DATE,
    ativo BOOLEAN DEFAULT TRUE,
    id_perfil INT NOT NULL DEFAULT 4,
    primeiro_acesso BOOLEAN DEFAULT TRUE,
    data_primeiro_acesso DATETIME,
    token_verificacao VARCHAR(64) NULL,
    email_verificado BOOLEAN DEFAULT FALSE,
    data_verificacao DATETIME NULL,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_perfil) REFERENCES perfil(id_perfil)
);

-- ============================================================
-- LOGS E NOTIFICAÇÕES
-- ============================================================

CREATE TABLE IF NOT EXISTS log_sistema (
    id_log INT PRIMARY KEY AUTO_INCREMENT,
    acao VARCHAR(100) NOT NULL,
    tabela_afetada VARCHAR(50),
    registro_id INT,
    detalhes TEXT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE SET NULL
);

CREATE TABLE IF NOT EXISTS notificacao (
    id_notificacao INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    titulo VARCHAR(150) NOT NULL,
    mensagem TEXT,
    lida BOOLEAN DEFAULT FALSE,
    tabela_origem VARCHAR(50),
    registro_id INT,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_leitura TIMESTAMP NULL,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS reset_senha (
    id_reset INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    expiracao DATETIME NOT NULL,
    usado BOOLEAN DEFAULT FALSE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE
);

CREATE TABLE exemplo (
    id_exemplo INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    status ENUM('ativo', 'inativo', 'pendente') DEFAULT 'ativo',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Dados de exemplo
INSERT INTO exemplo (nome, descricao, status) VALUES
('Exemplo 1', 'Descrição do exemplo 1', 'ativo'),
('Exemplo 2', 'Descrição do exemplo 2', 'inativo'),
('Exemplo 3', 'Descrição do exemplo 3', 'pendente');


-- ============================================================
-- INSERIR USUÁRIOS DE TESTE
-- ============================================================
-- Todas as senhas: 123
-- Hash: $2y$10$SnllgubFRD7R8JZpxkCpxOwXTvW1DARdwXkSxMYBc5qs/eUm8eCiG

-- 1. MASTER (id_perfil = 1)
INSERT IGNORE INTO usuario (id_usuario, nome, email, senha, telefone, data_nascimento, id_perfil, email_verificado, primeiro_acesso, ativo) 
VALUES (1, 'Master do Sistema', 'master@projetobase.com', '$2y$10$SnllgubFRD7R8JZpxkCpxOwXTvW1DARdwXkSxMYBc5qs/eUm8eCiG', '(11) 99999-9999', '1990-01-01', 1, TRUE, FALSE, TRUE);

-- 2. ADMIN (id_perfil = 2)
INSERT IGNORE INTO usuario (id_usuario, nome, email, senha, telefone, data_nascimento, id_perfil, email_verificado, primeiro_acesso, ativo) 
VALUES (2, 'Administrador', 'admin@projetobase.com', '$2y$10$SnllgubFRD7R8JZpxkCpxOwXTvW1DARdwXkSxMYBc5qs/eUm8eCiG', '(11) 88888-8888', '1990-01-01', 2, TRUE, FALSE, TRUE);

-- 3. OPERADOR (id_perfil = 3)
INSERT IGNORE INTO usuario (id_usuario, nome, email, senha, telefone, data_nascimento, id_perfil, email_verificado, primeiro_acesso, ativo) 
VALUES (3, 'Operador', 'operador@projetobase.com', '$2y$10$SnllgubFRD7R8JZpxkCpxOwXTvW1DARdwXkSxMYBc5qs/eUm8eCiG', '(11) 77777-7777', '1990-01-01', 3, TRUE, FALSE, TRUE);

-- 4. USUARIO (id_perfil = 4)
INSERT IGNORE INTO usuario (id_usuario, nome, email, senha, telefone, data_nascimento, id_perfil, email_verificado, primeiro_acesso, ativo) 
VALUES (4, 'Usuario Comum', 'usuario@projetobase.com', '$2y$10$SnllgubFRD7R8JZpxkCpxOwXTvW1DARdwXkSxMYBc5qs/eUm8eCiG', '(11) 66666-6666', '2000-01-01', 4, TRUE, FALSE, TRUE);

-- 5. USUARIO COM PRIMEIRO ACESSO PENDENTE (id_perfil = 4)
INSERT IGNORE INTO usuario (id_usuario, nome, email, senha, telefone, data_nascimento, id_perfil, email_verificado, primeiro_acesso, ativo) 
VALUES (5, 'Pendente Acesso', 'pendente@projetobase.com', '$2y$10$SnllgubFRD7R8JZpxkCpxOwXTvW1DARdwXkSxMYBc5qs/eUm8eCiG', '(11) 55555-5555', NULL, 4, FALSE, TRUE, TRUE);

-- 6. USUARIO INATIVO
INSERT IGNORE INTO usuario (id_usuario, nome, email, senha, telefone, data_nascimento, id_perfil, email_verificado, primeiro_acesso, ativo) 
VALUES (6, 'Usuario Inativo', 'inativo@projetobase.com', '$2y$10$SnllgubFRD7R8JZpxkCpxOwXTvW1DARdwXkSxMYBc5qs/eUm8eCiG', '(11) 44444-4444', '1995-01-01', 4, TRUE, FALSE, FALSE);

-- ============================================================
-- VERIFICAR DADOS INSERIDOS
-- ============================================================
SELECT '=== PERFIS ===' AS '';
SELECT * FROM perfil;

SELECT '=== USUARIOS ===' AS '';
SELECT id_usuario, nome, email, id_perfil, ativo, email_verificado, primeiro_acesso FROM usuario;

SELECT '=== LOGS ===' AS '';
SELECT COUNT(*) as total_logs FROM log_sistema;

SELECT '=== NOTIFICACOES ===' AS '';
SELECT COUNT(*) as total_notificacoes FROM notificacao;

SELECT '=== RESET_SENHA ===' AS '';
SELECT COUNT(*) as total_reset FROM reset_senha;

-- ============================================================
-- SUMÁRIO DOS USUÁRIOS PARA TESTE
-- ============================================================
SELECT '=== SUMÁRIO PARA LOGIN ===' AS '';
SELECT 
    'master@projetobase.com' as email, 
    '123' as senha, 
    'Master' as perfil 
UNION ALL
SELECT 'admin@projetobase.com', '123', 'Admin'
UNION ALL
SELECT 'operador@projetobase.com', '123', 'Operador'
UNION ALL
SELECT 'usuario@projetobase.com', '123', 'Usuario'
UNION ALL
SELECT 'pendente@projetobase.com', '123', 'Usuario (Primeiro Acesso)'
UNION ALL
SELECT 'inativo@projetobase.com', '123', 'Usuario (Inativo)';

UPDATE usuario SET primeiro_acesso = FALSE WHERE primeiro_acesso = TRUE;