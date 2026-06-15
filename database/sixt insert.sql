USE SiteRPG;

-- ============================================================
-- HABILIDADES BÁSICAS
-- ============================================================
-- id 1 = Recharge
-- id 2 = Passo Furtivo
-- id 3 = Olho do Falcão
-- id 4 = Defesa da Tartaruga Leão
-- id 5 = Coração de Leão
-- id 6 = Soco de Núcleo
-- ============================================================

INSERT INTO habilidades_basicas (nome, custo, id_energia_custo)
VALUES
('Recharge',               NULL, NULL),  -- TODO: custo
('Passo Furtivo',          NULL, NULL),  -- TODO: custo
('Olho do Falcão',         NULL, NULL),  -- TODO: custo
('Defesa da Tartaruga Leão', NULL, NULL),-- TODO: custo
('Coração de Leão',        NULL, NULL),  -- TODO: custo
('Soco de Núcleo',         NULL, NULL);  -- TODO: custo


-- ============================================================
-- HABILIDADES DE CLASSE
-- ============================================================
-- Invocador  → id_classe 4
-- Guerreiro  → id_classe 1
-- Destruidor → id_classe 14
-- Sniper     → id_classe 3
-- Healer     → id_classe 8
-- Mago       → id_classe 6
-- ============================================================

INSERT INTO habilidades_classe (id_classe, nome, custo, id_energia_custo, descricao)
VALUES
-- Invocador
(4, 'Regeneração de EA', NULL, 2, '+5 E.A. por turno apenas se o player acertar ataques ou técnicas.'),
(4, 'Resistência Infernal',           NULL, NULL, '+20% resistência a fogo infernal, maldições comuns e corrupção leve.'),
(4, 'Sobrevivência Crítica',          NULL, NULL, '1 vez por dia: ao chegar a 0 HP, continua ativo por 2 turnos antes de cair.'),
(4, 'Invocação do Instinto',          10,   2, 'Invoca um soldado com AK-12 (45 balas) para lutar junto. Nível 2.'),
(4, 'Invocação Mafioso',              40,   2, 'Invoca um mafioso que a cada 5 turnos invoca um capanga, podendo ter até 5 capangas. Nível 2.'),

-- Guerreiro
(1, 'Golpe Marcial', 5, 1, 'Golpe firme e treinado que aumenta a força bruta do ataque. Custo: 5 Stamina. -- TODO: confirmar id_energia (Stamina não é energia no schema)'),

-- Destruidor
(14, 'Impacto Reluzente', 5, 2, 'Faz com que um ataque ganhe um range de explosão de 4 metros.'),

-- Sniper
(3, 'Linha de Tiro Calculada', 10, 1, 'Entra em estado de cálculo balístico total. O próximo disparo ignora interferências do ambiente e recebe bônus de precisão e dano. Exige 1 turno mirando. Custo: 10 Stamina. -- TODO: confirmar id_energia'),

-- Healer
(8, 'Cura',     10, 1, 'Recupera 40 HP ao uso. Custo: 10 Prana.'),
(8, 'Recharge', NULL, NULL, 'Habilidade de classe do Healer. -- TODO: custo e descrição'),

-- Mago
(6, 'Acúmulo de E.A.', NULL, 2, 'Passiva: a cada batalha ganha +5 de E.A.');


-- ============================================================
-- RELAÇÃO PLAYERS × HABILIDADES BÁSICAS
-- ============================================================
-- habilidades_basicas ids:
--   1=Recharge, 2=Passo Furtivo, 3=Olho do Falcão
--   4=Defesa da Tartaruga Leão, 5=Coração de Leão, 6=Soco de Núcleo

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
VALUES
-- Aurelian (5)
(5, 1, 1),  -- Recharge
(5, 2, 1),  -- Passo Furtivo
(5, 3, 1),  -- Olho do Falcão
(5, 4, 1),  -- Defesa da Tartaruga Leão
(5, 5, 1),  -- Coração de Leão

-- Ikulian (6)
(6, 6, 1),  -- Soco de Núcleo
(6, 2, 1),  -- Passo Furtivo

-- Bachira (7)
(7, 1, 1),  -- Recharge
(7, 2, 1),  -- Passo Furtivo

-- Yuri (8)
(8, 6, 1),  -- Soco de Núcleo
(8, 1, 1),  -- Recharge
(8, 3, 1);  -- Olho do Falcão


-- ============================================================
-- RELAÇÃO PLAYERS × HABILIDADES DE CLASSE
-- ============================================================
-- habilidades_classe ids (assumindo inserção em ordem acima):
--   1=Regeneração E.A.       (Invocador)
--   2=Resistência Infernal   (Invocador)
--   3=Sobrevivência Crítica  (Invocador)
--   4=Invocação do Instinto  (Invocador)
--   5=Invocação Mafioso      (Invocador)
--   6=Golpe Marcial          (Guerreiro)
--   7=Impacto Reluzente      (Destruidor)
--   8=Linha de Tiro Calculada(Sniper)
--   9=Cura                   (Healer)
--  10=Recharge               (Healer)
--  11=Acúmulo de E.A.        (Mago)

INSERT INTO R_player_habilidade_classe (id_player, id_habilidade_classe, level)
VALUES
-- Lukis (1) — Invocador
(1, 1, 1),  -- Regeneração E.A.
(1, 2, 1),  -- Resistência Infernal
(1, 3, 1),  -- Sobrevivência Crítica

-- Adrian (4) — Invocador
(4, 4, 2),  -- Invocação do Instinto (lv2)
(4, 5, 2),  -- Invocação Mafioso (lv2)

-- Ikulian (6) — Guerreiro
(6, 6, 1),  -- Golpe Marcial

-- Bachira (7) — Destruidor
(7, 7, 1),  -- Impacto Reluzente

-- Yuri (8) — Sniper
(8, 8, 1),  -- Linha de Tiro Calculada

-- Koishi (9) — Healer
(9, 9, 1),  -- Cura
(9, 10, 1), -- Recharge (classe)

-- Aurelian (5) — Mago
(5, 11, 1); -- Acúmulo de E.A.