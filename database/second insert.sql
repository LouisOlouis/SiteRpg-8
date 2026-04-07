USE SiteRPG;

INSERT INTO itens (item, id_raridade, descricao) 
VALUES

--65
("Isqueiro", 1, 'Isqueiro simples'),
('Manopla', 1, ''),
('STG 44', 1, ''),
('Talismã de Explosão', 1, ''),
('Talismã de proteção', 1, ''),
('Faca natalina', 2, ''),
('Soco Ingles Red eye', 3, 'Ao golpear alguem com esse item recupera 1% de vida, recupera 5 stamina por golpe');

INSERT INTO R_player_item (id_player, id_item)
VALUES
(1,66),
(1,67),
(1,68),
(1,69),
(1,70),
(1,71),
(1,72);

INSERT INTO itens (item, id_raridade, descricao) 
VALUES

--72
("Machado Kratos", 3, "Machado Estilo kratos"),
("Anel", 1,""),
("Livro de historia", 1, "Contem informaçoes historicas"),
("Brasão de Graduado", 1, "ganhado quando se forma na escola"),
("Celular", 1, ""),
("Espada foda", 3, "Bem foda")
("Bolsa do vasio", 2, '');

INSERT INTO R_player_item (id_player, id_item)
VALUES
(2,73),--8
(2,74),
(2,75),
(2,76),
(2,77),
(2,78),
(2,79);

INSERT INTO R_item_player_encantamento (id_item_player, id_encantamentos, level)
VALUES
(8,28,1);

INSERT INTO itens (item, id_raridade, descricao) 
VALUES
--79
('Cajado de Madeira', 1, ""),
('Brasao da familia', 2, '')
('Solcrux', 6, 'Machado de Guerra Vermelho com habilidades solares');

INSERT INTO R_player_item (id_player, id_item)
VALUES
(3,80),
(3,81),
(3,77),
(3,76),
(3,74),
(3,82);

INSERT INTO itens (item, id_raridade, descricao) 
VALUES
--82
('Oculos Escuros', 1,'Maneiros'),
('Livro da Sorte', 2,'+7 no dado 3x na sessão'),
('Runa de lealdade', 2,'');
('Mochila X',1, '10 espaços')

INSERT INTO R_player_item (id_player, id_item)
VALUES

(4,83),
(4,77),
(4,76),
(4,70),
(4,84),
(4,85),
(4,86);

INSERT INTO itens (item, id_raridade, descricao) 
VALUES
--86
('Chapeu estiloso', 1, 'Estiloso'),
('Colar Lunar', 2,''),
('Relogio Amaldiçoado', 2, "Relogio imbuido com E.A que aumenta sua propia energia");


INSERT INTO R_player_item (id_player, id_item)
VALUES
(5,81),
(5,77),
(5,76),
(5,87),
(5,88),
(5,89);