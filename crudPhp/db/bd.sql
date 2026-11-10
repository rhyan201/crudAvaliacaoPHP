CREATE DATABASE IF NOT EXISTS crudphp;
USE crudphp;

DROP TABLE IF EXISTS avaliacoes;

CREATE TABLE avaliacoes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255),
    descricao VARCHAR(255),
    nota INT(2)
);

INSERT INTO avaliacoes (nome, descricao, nota) VALUES
('Rhyan', 'Peguei 3kg de morango direto do produtor, docinhos e fresquinhos', 10),
('Ana Souza', 'Mangas maduras no ponto certo e bem mais baratas que no mercado', 9),
('Carlos Lima', 'Bananas boas, mas o horário de retirada no sítio é apertado', 7),
('Mariana Alves', 'Adoro comprar do pequeno produtor e ainda evitar desperdício', 10),
('João Pereira', 'Laranjas suculentas, mas vieram um pouco menos que 2kg', 6),
('Beatriz Costa', 'Caixa de goiabas lindas, o produtor foi muito atencioso', 9),
('Lucas Martins', 'Abacates já estavam passados demais, não deu para aproveitar', 3),
('Fernanda Rocha', 'Uvas sem agrotóxico com preço justo, virei cliente fiel', 10),
('Pedro Santos', 'Melancia enorme e doce, valeu muito a pena', 8),
('Juliana Ribeiro', 'Cheguei no horário e as jabuticabas já tinham acabado', 5);
