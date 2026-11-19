-- Adiciona suporte a login com Google em bancos criados antes desta versão.
ALTER TABLE usuario ADD COLUMN google_id VARCHAR(64) NULL UNIQUE AFTER data_verificacao;
