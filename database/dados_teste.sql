-- ============================================================
-- DADOS DE TESTE - USE SOMENTE EM DESENVOLVIMENTO
-- NUNCA importe em produção: as senhas abaixo são públicas.
-- ============================================================
-- Senha de todos: Teste@123
-- Para produção crie o Master com:  php bin/console criar-master
-- ============================================================

INSERT IGNORE INTO usuario (id_usuario, nome, email, senha, telefone, data_nascimento, id_perfil, email_verificado, ativo) VALUES
(1, 'Master do Sistema', 'master@projetobase.com',   '$2y$10$kZ.5xJVgIjZYv1OokxxkhOMZhFwHfwVgAMtcokOKXVnXq/Yx00KJu', '(11) 99999-9999', '1990-01-01', 1, TRUE,  TRUE),
(2, 'Administrador',     'admin@projetobase.com',    '$2y$10$kZ.5xJVgIjZYv1OokxxkhOMZhFwHfwVgAMtcokOKXVnXq/Yx00KJu', '(11) 88888-8888', '1990-01-01', 2, TRUE,  TRUE),
(3, 'Operador',          'operador@projetobase.com', '$2y$10$kZ.5xJVgIjZYv1OokxxkhOMZhFwHfwVgAMtcokOKXVnXq/Yx00KJu', '(11) 77777-7777', '1990-01-01', 3, TRUE,  TRUE),
(4, 'Usuario Comum',     'usuario@projetobase.com',  '$2y$10$kZ.5xJVgIjZYv1OokxxkhOMZhFwHfwVgAMtcokOKXVnXq/Yx00KJu', '(11) 66666-6666', '2000-01-01', 4, TRUE,  TRUE),
(5, 'Nao Verificado',    'pendente@projetobase.com', '$2y$10$kZ.5xJVgIjZYv1OokxxkhOMZhFwHfwVgAMtcokOKXVnXq/Yx00KJu', '(11) 55555-5555', NULL,         4, FALSE, TRUE),
(6, 'Usuario Inativo',   'inativo@projetobase.com',  '$2y$10$kZ.5xJVgIjZYv1OokxxkhOMZhFwHfwVgAMtcokOKXVnXq/Yx00KJu', '(11) 44444-4444', '1995-01-01', 4, TRUE,  FALSE);

INSERT INTO exemplo (nome, descricao, status) VALUES
('Exemplo 1', 'Descrição do exemplo 1', 'ativo'),
('Exemplo 2', 'Descrição do exemplo 2', 'inativo'),
('Exemplo 3', 'Descrição do exemplo 3', 'pendente');

INSERT INTO notificacao (id_usuario, tipo, titulo, mensagem) VALUES
(1, 'info', 'Bem-vindo!', 'Este é um exemplo de notificação.'),
(4, 'info', 'Bem-vindo!', 'Este é um exemplo de notificação.');
