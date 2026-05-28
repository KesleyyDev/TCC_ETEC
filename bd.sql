-- Criação do banco de dados para a Marcenaria Nanias
CREATE DATABASE IF NOT EXISTS marcenaria_nanias
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE marcenaria_nanias;

-- ==========================================================
-- 1. TABELA DE USUÁRIOS (Para o painel administrativo / gestao)
-- ==========================================================
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL, -- Senha com hash (ex: password_hash do PHP)
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ==========================================================
-- 2. TABELA DE CATEGORIAS (Para classificar os móveis e materiais)
-- ==========================================================
CREATE TABLE IF NOT EXISTS categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    tipo ENUM('moveis', 'materiais') NOT NULL, -- Define se a categoria é de um móvel pronto ou um tipo de material
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================================
-- 3. TABELA DE PRODUTOS / CATÁLOGO
-- ==========================================================
CREATE TABLE IF NOT EXISTS produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(100) NOT NULL,
    descricao TEXT NOT NULL,
    imagem_url VARCHAR(255) NULL, -- Caminho para a imagem do produto (ex: 'img/produtos/cozinha.jpg')
    categoria_id INT NOT NULL,
    destaque TINYINT(1) DEFAULT 0, -- 1 se o produto for aparecer em destaque na home, 0 se não
    ativo TINYINT(1) DEFAULT 1, -- Para ativar/desativar produtos sem precisar deletar do banco
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_produto_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id) ON DELETE CASCADE
);

-- ==========================================================
-- 4. TABELA DE MENSAGENS / CONTATOS (Para a página de Suporte)
-- ==========================================================
CREATE TABLE IF NOT EXISTS mensagens_contato (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    assunto ENUM('orcamento', 'duvida', 'elogio') NOT NULL,
    mensagem TEXT NOT NULL,
    status ENUM('nova', 'lida', 'respondida') DEFAULT 'nova',
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- ==========================================================
-- INSERÇÃO DE DADOS INICIAIS (SEED) PARA TESTE
-- ==========================================================

-- Usuário Admin Padrão (A senha original é: admin123, hash gerado via password_hash)
INSERT INTO usuarios (nome, email, senha) VALUES 
('Administrador', 'admin@marcenariananias.com.br', '$2y$10$U49L0H/q2/EToK.wz.F4KOnqE.R7i.eB/f2J3bBq1J9nF6dF2Z2/q');

-- Categorias Iniciais
INSERT INTO categorias (nome, tipo) VALUES 
('Cozinhas', 'moveis'),
('Dormitórios', 'moveis'),
('Salas e Home Theater', 'moveis'),
('Banheiros', 'moveis'),
('MDF', 'materiais'),
('MDP', 'materiais'),
('Madeira Maciça', 'materiais'),
('Laminado Melamínico', 'materiais');

-- Exemplo de Produtos no Catálogo
INSERT INTO produtos (titulo, descricao, imagem_url, categoria_id, destaque) VALUES
('Cozinha Planejada Premium', 'MDF Ultra com acabamento em laca fosca e puxadores em perfil de alumínio champagne.', 'img/produtos/cozinha-premium.jpg', 1, 1),
('Dormitório Casal Master', 'Guarda-roupa com portas de correr em espelho bronze e painel ripado iluminado.', 'img/produtos/dormitorio-master.jpg', 2, 1),
('Gabinete de Banheiro Luxo', 'MDF resistente à umidade, gavetões com corrediças ocultas e sistema fecho-toque.', 'img/produtos/banheiro-luxo.jpg', 4, 0);
