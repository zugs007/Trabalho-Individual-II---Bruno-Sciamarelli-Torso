CREATE DATABASE IF NOT EXISTS pokelar_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pokelar_db;

-- senha admin: admin123
CREATE TABLE IF NOT EXISTS usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    perfil ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- pokemon
CREATE TABLE IF NOT EXISTS pokemons (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    tipo_primario VARCHAR(30) NOT NULL,
    tipo_secundario VARCHAR(30) NULL,
    porte ENUM('pequeno', 'medio', 'grande') NOT NULL,
    idade VARCHAR(50) NOT NULL,
    temperamento VARCHAR(100) NOT NULL,
    local_resgate VARCHAR(150) NOT NULL,
    status ENUM('disponivel', 'em-processo', 'adotado') NOT NULL DEFAULT 'disponivel',
    imagem VARCHAR(255) NOT NULL,
    alt_texto VARCHAR(255) NOT NULL,
    descricao TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- adocoes
CREATE TABLE IF NOT EXISTS adocoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    pokemon_id INT NOT NULL,
    data_visita DATE NOT NULL,
    hora_visita TIME NOT NULL,
    observacoes TEXT NULL,
    status ENUM('em_analise', 'confirmado', 'concluido', 'cancelado') NOT NULL DEFAULT 'em_analise',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (pokemon_id) REFERENCES pokemons(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- inserções default
INSERT INTO usuarios (nome, email, senha, perfil) VALUES 
('Administrador PokéLar', 'admin@pokelar.com', '$2y$10$N9qo8uLOickgx2ZMRZoMyeIjZAgcfl7p92ldGxad68LJZdL17lhWy', 'admin'),
('Ash Ketchum', 'ash@pokelar.com', '$2y$10$qR6FvY9x8Z1w2e3r4t5y6u7i8o9p0a1b2c3d4e5f6g7h8i9j0k1l2', 'usuario');

INSERT INTO pokemons (nome, tipo_primario, tipo_secundario, porte, idade, temperamento, local_resgate, status, imagem, alt_texto, descricao) VALUES
('Bulbasaur', 'planta', 'veneno', 'pequeno', 'Jovem (2 anos)', 'Calmo e afetuoso', 'Floresta de Viridian', 'disponivel', 'img/bulbasaur.png', 'Bulbasaur sorrindo com um bulbo verde nas costas', 'Muito dócil e adora tomar sol no jardim. Ideal para treinadores iniciantes ou famílias com crianças.'),
('Charmander', 'fogo', NULL, 'pequeno', 'Filhote (1 ano)', 'Leal e enérgico', 'Rota 24 (Sob chuva)', 'disponivel', 'img/charmander.png', 'Charmander alegre com a chama da cauda acesa', 'Resgatado em dia de tempestade, hoje está saudável, cheio de energia e adora brincar perto de lareiras.'),
('Squirtle', 'agua', NULL, 'pequeno', 'Jovem (2 anos)', 'Brincalhão e protetor', 'Praia de Vermilion', 'em-processo', 'img/squirtle.png', 'Squirtle acenando com a patinha', 'Adora nadar em tanques e lagos. Atualmente em processo de entrevista com uma nova família.'),
('Pikachu', 'eletrico', NULL, 'pequeno', 'Adulto (3 anos)', 'Curioso e carinhoso', 'Usina de Power Plant', 'disponivel', 'img/pikachu.png', 'Pikachu sorridente com bochechas vermelhas', 'Gosta de ficar nos ombros do tutor. Precisa de brinquedos para descarregar o excesso de eletricidade acumulada.'),
('Eevee', 'normal', NULL, 'pequeno', 'Filhote (8 meses)', 'Adaptável e muito dócil', 'Cidade de Celadon', 'disponivel', 'img/eevee.png', 'Eevee sentado olhando para frente', 'Muito carinhoso e interativo. Adapta-se facilmente a apartamentos e convivência com outros Pokémon.'),
('Snorlax', 'normal', NULL, 'grande', 'Adulto (6 anos)', 'Pacato e dorminhoco', 'Rota 12 (Bloqueando passagem)', 'disponivel', 'img/snorlax.png', 'Snorlax dormindo de barriga para cima', 'Necessita de um quintal espaçoso e rotina diária de alimentação supervisionada por nutricionista veterinário.');