-- Script de criação do banco de dados do HelpDesk
CREATE DATABASE IF NOT EXISTS db_chamados
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_chamados;

CREATE TABLE IF NOT EXISTS chamados (
    id           INT UNSIGNED NOT NULL AUTO_INCREMENT,
    titulo       VARCHAR(150) NOT NULL,
    descricao    TEXT         NOT NULL,
    -- ENUM garante a integridade dos valores permitidos no próprio banco
    status       ENUM('Aberto', 'Em Andamento', 'Resolvido') NOT NULL DEFAULT 'Aberto',
    data_criacao DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    INDEX idx_status (status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Dados de exemplo (opcional)
INSERT INTO chamados (titulo, descricao, status) VALUES
('Computador não liga', 'O computador da recepção não apresenta sinal de energia após queda de luz.', 'Aberto'),
('Acesso ao e-mail corporativo', 'Usuário não consegue autenticar no webmail desde a última troca de senha.', 'Em Andamento'),
('Instalação de impressora', 'Instalar driver da impressora do setor financeiro na estação 12.', 'Resolvido');
