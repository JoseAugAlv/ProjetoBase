-- ============================================================
-- PROJETOBASE - ESTRUTURA DO BANCO
-- ============================================================
-- Instalação automática:  php bin/console instalar
-- Manual: crie o banco (o nome em DB_NAME do .env) e importe este arquivo.
-- Dados de teste (SÓ em desenvolvimento): database/dados_teste.sql
-- ============================================================

SET NAMES utf8mb4;

-- ------------------------------------------------------------
-- PERFIL (lookup) - ids fixos usados no código (Models/Perfil.php)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS perfil (
    id_perfil INT PRIMARY KEY AUTO_INCREMENT,
    perfil VARCHAR(20) UNIQUE NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT IGNORE INTO perfil (id_perfil, perfil) VALUES
(1, 'Master'),
(2, 'Admin'),
(3, 'Operador'),
(4, 'Usuario');

-- ------------------------------------------------------------
-- USUARIO
-- token_verificacao guarda o HASH sha256 do token enviado por e-mail
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20),
    data_nascimento DATE,
    ativo BOOLEAN DEFAULT TRUE,
    id_perfil INT NOT NULL DEFAULT 4,
    token_verificacao CHAR(64) NULL,
    email_verificado BOOLEAN DEFAULT FALSE,
    data_verificacao DATETIME NULL,
    google_id VARCHAR(64) NULL UNIQUE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    data_atualizacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (id_perfil) REFERENCES perfil(id_perfil),
    INDEX idx_usuario_token (token_verificacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- LOG_SISTEMA (auditoria - escrito por SecurityHelper::logAuditoria)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS log_sistema (
    id_log INT PRIMARY KEY AUTO_INCREMENT,
    acao VARCHAR(100) NOT NULL,
    tabela_afetada VARCHAR(50),
    registro_id INT,
    detalhes TEXT,
    ip VARCHAR(45),
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    id_usuario INT,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE SET NULL,
    INDEX idx_log_data (data_criacao)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- NOTIFICACAO
-- ------------------------------------------------------------
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
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    INDEX idx_notificacao_usuario (id_usuario, lida)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- RESET_SENHA - token guarda o HASH sha256 do token enviado por e-mail
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS reset_senha (
    id_reset INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    token CHAR(64) NOT NULL,
    expiracao DATETIME NOT NULL,
    usado BOOLEAN DEFAULT FALSE,
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuario(id_usuario) ON DELETE CASCADE,
    INDEX idx_reset_token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- EXEMPLO - tabela de demonstração do CRUD genérico (/exemplo)
-- Pode apagar quando não precisar mais.
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS exemplo (
    id_exemplo INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(150) NOT NULL,
    descricao TEXT,
    status ENUM('ativo', 'inativo', 'pendente') DEFAULT 'ativo',
    data_criacao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
