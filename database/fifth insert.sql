USE SiteRPG;

-- ============================================================
-- TÉCNICAS E JUTSUS - PLAYERS
-- ============================================================
-- Referências de energia:
--   id 1 = Prana
--   id 2 = Energia Amaldiçoada (E.A.)
--   id 3 = Aura
--
-- ATENÇÃO: os id_tecnica nos inserts de jutsus assumem que
-- player_tecnicas está vazia. Se já houver dados, ajuste o
-- offset rodando: SELECT MAX(id) FROM player_tecnicas;
-- ============================================================


-- ------------------------------------------------------------
-- PLAYER 1 - LUKIS
-- id_tecnica = 1
-- ------------------------------------------------------------

INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES
(1, 'Jutsu Corrompido', 'Técnica baseada em energia amaldiçoada corrompida.');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(1, 'Raio Negro',         40,   2, 3, '-- TODO: adicionar descrição detalhada'),
(1, 'Reversão',           30,   2, 3, '-- TODO: adicionar descrição detalhada'),
(1, 'Defesa Corrompida',  40,   2, 3, '-- TODO: adicionar descrição detalhada'),
(1, 'Flecha Fragmentada', 50,   2, 3, '-- TODO: adicionar descrição detalhada'),
(1, 'Zona Morta',         70,   2, 1, '-- TODO: adicionar descrição detalhada');


-- ------------------------------------------------------------
-- PLAYER 3 - DAMIAN JACKSON
-- id_tecnica = 2
-- ------------------------------------------------------------

INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES
(3, 'Shinigami', 'Técnica baseada em invocação de criaturas sombrias por energia amaldiçoada. Passivas: pode entrar nas sombras da técnica e se movimentar; sabe usar técnica reversa.');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(2, 'Coelhos Vermelhos',   10,  2, 7, '-- TODO: adicionar descrição detalhada'),
(2, 'Sapo Voador',         30,  2, 7, '-- TODO: adicionar descrição detalhada'),
(2, 'Corvos Amaldiçoados', 30,  2, 7, '-- TODO: adicionar descrição detalhada'),
(2, 'Cães Sombrios',       40,  2, 7, '-- TODO: adicionar descrição detalhada'),
(2, 'Anaconda Venenosa',   60,  2, 7, '-- TODO: adicionar descrição detalhada'),
(2, 'Impacto do Elefante', 80,  2, 7, '-- TODO: adicionar descrição detalhada'),
(2, 'Rei das Sombras',     150, 2, 4, '-- TODO: adicionar descrição detalhada');


-- ------------------------------------------------------------
-- PLAYER 4 - ADRIAN KREUZ
-- Técnica 1: Guerra    → id_tecnica = 3
-- Técnica 2: Infernal  → id_tecnica = 4
-- TODO: classe "Câncrio" não existe em classes; criar e atualizar id_classe se necessário
-- ------------------------------------------------------------

INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES
(4, 'Guerra',   'Técnica de comando e suporte em campo de batalha.'),
(4, 'Infernal', 'Técnica baseada em fogo infernal e energia amaldiçoada.');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(3, 'Limpeza de Área',     10,   2, 4, '-- TODO: adicionar descrição detalhada'),
(3, 'Liderança Superior',  10,   2, 4, '-- TODO: adicionar descrição detalhada'),
(3, 'Proteção Superior',   10,   2, 4, '-- TODO: adicionar descrição detalhada'),
(3, 'Ataque Preciso',      20,   2, 3, '-- TODO: adicionar descrição detalhada'),
(3, 'Reagrupar',           15,   2, 3, '-- TODO: adicionar descrição detalhada'),
(3, 'Muro de Berlin',      40,   2, 3, '-- TODO: adicionar descrição detalhada'),
(3, 'Cerco',               NULL, 2, 0, 'Bloqueado.');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(4, 'Fagulha Cardinal',    50,   2, 4, '-- TODO: adicionar descrição detalhada'),
(4, 'Lâmina do Crepitar',  70,   2, 4, '-- TODO: adicionar descrição detalhada'),
(4, 'Vórtice da Fornalha', 80,   2, 4, '-- TODO: adicionar descrição detalhada'),
(4, 'Fissura Crepitante',  120,  2, 2, '-- TODO: adicionar descrição detalhada'),
(4, 'Coroa do Sol Parto',  100,  2, 2, '-- TODO: adicionar descrição detalhada'),
(4, 'Apoteose Fugaa',      NULL, 2, 0, 'Ultimate. Custo: 100% da E.A. disponível + custo em HP. CD: muito longo. Alcance: domínio 300–500 metros. -- TODO: descrição detalhada');


-- ------------------------------------------------------------
-- PLAYER 5 - AURELIAN TEMPEST
-- Técnica 1: Técnica Base    → id_tecnica = 5
-- Técnica 2: Jutsus Gulados  → id_tecnica = 6
-- TODO: Cura Energética tem custo misto (Stamina + Energia) — schema só suporta um tipo
-- ------------------------------------------------------------

INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES
(5, 'Técnica Base',   'Jutsus originais de Aurelian Tempest.'),
(5, 'Jutsus Gulados', 'Poderes absorvidos através do jutsu Gula (ao comer parte do alvo, o usuário absorve um poder dele).');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(5, 'Gula',               20,  2, 3, 'Ao comer uma parte do alvo, ganha um poder dele. -- TODO: descrição detalhada'),
(5, 'Grande Sábio',       40,  2, 7, '-- TODO: adicionar descrição detalhada'),
(5, 'Barreira do Infinito',30, 2, 3, 'HP da barreira: 200. -- TODO: descrição detalhada'),
(5, 'Chuva da Morte',     40,  2, 3, '-- TODO: adicionar descrição detalhada'),
(5, 'Cura Energética',    20,  1, 3, 'Custo: 20 Stamina + energia absorvida. -- TODO: revisar custo misto no schema'),
(5, 'Invocação Caótica',  100, 2, 1, '-- TODO: adicionar descrição detalhada'),
(5, 'Expansão do Vazio',  150, 2, 1, 'Refino 1. -- TODO: adicionar descrição detalhada');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(6, 'Ilimitado',          70, 2, 7, 'Gulado. -- TODO: adicionar descrição detalhada'),
(6, 'Jackpot',            75, 2, 5, 'Gulado. -- TODO: adicionar descrição detalhada'),
(6, 'Tsuno',              35, 2, 1, 'Gulado. -- TODO: adicionar descrição detalhada'),
(6, 'Desmantelar',        25, 2, 2, 'Gulado. -- TODO: adicionar descrição detalhada'),
(6, 'Besta Mítica Âmbar', 80, 2, 2, 'Gulado. -- TODO: adicionar descrição detalhada');


-- ------------------------------------------------------------
-- PLAYER 6 - IKULIAN
-- id_tecnica = 7
-- Zeus Javelin e Vimeinun Myrsky estão 🔒
-- TODO: verificar nome real da técnica
-- ------------------------------------------------------------

INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES
(6, 'Técnica Base', '-- TODO: verificar nome real da técnica de Ikulian');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(7, 'Tachyon Blade',      10,   2, 4, '-- TODO: adicionar descrição detalhada'),
(7, 'Elétron Speed/Dash', 10,   2, 4, '-- TODO: adicionar descrição detalhada'),
(7, 'Electric Control',   10,   2, 4, '-- TODO: adicionar descrição detalhada'),
(7, 'Lightning Flash',    20,   2, 3, '-- TODO: adicionar descrição detalhada'),
(7, 'Gravity Push',       25,   2, 3, '-- TODO: adicionar descrição detalhada'),
(7, 'Zeus Javelin',       NULL, 2, 0, 'Bloqueado.'),
(7, 'Vimeinun Myrsky',    NULL, 2, 0, 'Bloqueado.');


-- ------------------------------------------------------------
-- PLAYER 7 - BACHIRA
-- id_tecnica = 8
-- Santuário Vazio está 🔒
-- TODO: verificar nome real da técnica
-- ------------------------------------------------------------

INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES
(7, 'Técnica Base', '-- TODO: verificar nome real da técnica de Bachira');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(8, 'Ilimitado',           30,   2, 7, '-- TODO: adicionar descrição detalhada'),
(8, 'Jackpot',             35,   2, 3, '-- TODO: adicionar descrição detalhada'),
(8, 'Tsuno',               35,   2, 3, '-- TODO: adicionar descrição detalhada'),
(8, 'Desmantelar',         25,   2, 4, '-- TODO: adicionar descrição detalhada'),
(8, 'Besta Mítica Âmbar',  80,   2, 4, '-- TODO: adicionar descrição detalhada'),
(8, 'Kokusen',             30,   2, 3, 'Recupera 50% de E.A. Pode ser usado 3 vezes seguidas. -- TODO: descrição detalhada'),
(8, 'Santuário Vazio',     NULL, 2, 0, 'Bloqueado.');


-- ------------------------------------------------------------
-- PLAYER 8 - YURI KONSHKINA
-- id_tecnica = 9
-- Kaleva Swap e Expansão estão 🔒
-- TODO: verificar nome real da técnica
-- ------------------------------------------------------------

INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES
(8, 'Técnica Base', '-- TODO: verificar nome real da técnica de Yuri Konshkina');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(9, 'Buscadora de Cabeças', 5,    2, 5, '-- TODO: adicionar descrição detalhada'),
(9, 'Marca da Caçadora',    10,   2, 5, '-- TODO: adicionar descrição detalhada'),
(9, 'Clone Lunar',          5,    2, 5, 'Custo: 5 E.A. por clone. -- TODO: descrição detalhada'),
(9, 'Ilusão Ofensiva',      20,   2, 5, '-- TODO: adicionar descrição detalhada'),
(9, 'Disfarce Lunar',       20,   2, 5, '-- TODO: adicionar descrição detalhada'),
(9, 'Kaleva Swap',          NULL, 2, 0, 'Bloqueado.'),
(9, 'Expansão',             NULL, 2, 0, 'Bloqueado.');


-- ------------------------------------------------------------
-- PLAYER 9 - KOISHI KOMEIJI
-- id_tecnica = 10
-- Energia: Prana (id 1)
-- Quase todos os jutsus estão 🔒
-- TODO: verificar nome real da técnica
-- ------------------------------------------------------------

INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES
(9, 'Técnica Base', '-- TODO: verificar nome real da técnica de Koishi Komeiji');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
VALUES
(10, 'Contra-Fluxo Instintivo',          10,   1, 1, '-- TODO: adicionar descrição detalhada'),
(10, 'Sincronia Subconsciente',           NULL, 1, 0, 'Bloqueado.'),
(10, 'Mary',                              NULL, 1, 0, 'Bloqueado.'),
(10, 'Puro Instinto',                     NULL, 1, 0, 'Bloqueado.'),
(10, 'Reorganização do Campo',            NULL, 1, 0, 'Bloqueado.'),
(10, 'Efeito Placebo',                    NULL, 1, 0, 'Bloqueado.'),
(10, 'Expansão de Domínio: Right Behind', NULL, 1, 0, 'Bloqueado.');