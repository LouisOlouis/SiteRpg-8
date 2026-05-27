USE SiteRPG;

-- ============================================================
-- 7th INSERT — UPDATE de fichas existentes + novo player Dio
-- ============================================================
-- Referências:
--   Energias: 1=Prana, 2=E.A., 3=Aura
--   Classes: 1=Guerreiro, 2=Paladino, 3=Sniper, 4=Invocador,
--            5=Bardo, 6=Mago, 7=Tank, 8=Healer, 9=Assassino,
--            10=Ladino, 11=Monge, 12=Barbaro, 13=Clerigo,
--            14=Destruidor, 15=Anti-Tank
--
-- Habilidades básicas:
--   1=Recharge, 2=Passo Furtivo, 3=Olho do Falcão,
--   4=Defesa da Tartaruga Leão, 5=Coração de Leão, 6=Soco de Núcleo
-- ============================================================


-- ────────────────────────────────────────────────────────────
-- PLAYER 1 — LUKIS
-- Mudanças: hp, level, velocidade, agilidade, experiencia
-- ────────────────────────────────────────────────────────────

UPDATE player_status SET
    level       = 34,
    hp          = 330,
    velocidade  = 25,
    agilidade   = 32,
    experiencia = 15
WHERE id_player = 1;

-- mente (sanidade levemente diferente da ficha original)
UPDATE player_mente SET
    sanidade    = 92,
    sanidadeMax = 100,
    stress      = 53,
    traumas     = 1,
    rm          = 45
WHERE id_player = 1;


-- ────────────────────────────────────────────────────────────
-- PLAYER 2 — DIO SPIN KEINER (NOVO — não existia no banco)
-- Classe: Receptáculo → não existe; adicionando à tabela classes
-- Técnica do Shikigami → ignorada por agora (sistema especial)
-- ────────────────────────────────────────────────────────────

-- Novos títulos necessários
INSERT INTO titulos (titulo) VALUES
('Receptáculo do Deus do Trovão'); -- id = 39 (assumindo sequência após os 38 existentes)

-- Nova classe
INSERT INTO classes (classe) VALUES
('Receptáculo'); -- TODO: confirmar id gerado e ajustar id_classe abaixo se necessário

-- player_base já existe com id=2 (estava no first_insert com classe Guerreiro)
-- Atualiza classe e efeitos
UPDATE player_base SET
    nome      = 'Dio Spin Keiner',
    id_classe = (SELECT id FROM classes WHERE classe = 'Receptáculo'),
    efeitos   = 'Ao se aproximar de uma maldição começa a incomodá-la, e se pá da kill'
WHERE id = 2;

UPDATE player_dinheiro SET
    dinheiro  = 10175,
    fragmento = 0
WHERE id_player = 2;

UPDATE player_status SET
    level       = 46,
    hp          = 1710,
    forca       = 50,
    velocidade  = 20,
    agilidade   = 30,
    durabilidade= 42,
    combate     = 18,
    experiencia = 27
WHERE id_player = 2;

UPDATE player_energias SET
    iq      = 196,
    stamina = 90,
    energia = 60,
    aura    = 59
WHERE id_player = 2;

UPDATE player_mente SET
    sanidade    = 57,
    sanidadeMax = 90,
    stress      = 80,
    traumas     = 3,
    rm          = 28
WHERE id_player = 2;

-- Títulos do Dio
-- id 1 = Graduado (já vinculado no first_insert)
-- id 4 = Mestre da Careta (já vinculado no first_insert)
-- Adiciona o novo título
INSERT INTO R_player_titulo (id_player, id_titulo)
VALUES (2, (SELECT id FROM titulos WHERE titulo = 'Receptáculo do Deus do Trovão'));

-- Habilidades básicas do Dio
INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level) VALUES
(2, 1, 1),  -- Recharge
(2, 4, 1),  -- Defesa da Tartaruga Leão
(2, 6, 1),  -- Soco de Núcleo
(2, 2, 1);  -- Passo Furtivo

-- Hab. de classe: Golpe Marcial (id=6, pertence ao Guerreiro)
-- Dio tem classe Receptáculo mas usa o golpe marcial do Guerreiro
-- TODO: confirmar se Receptáculo deve ter suas próprias habilidades de classe
INSERT INTO R_player_habilidade_classe (id_player, id_habilidade_classe, level)
VALUES (2, 6, 1); -- Golpe Marcial


-- ────────────────────────────────────────────────────────────
-- PLAYER 3 — DAMIAN JACKSON
-- Sem alterações numéricas. Passivas atualizadas só em texto
-- (descricao da player_tecnicas) — opcional atualizar
-- ────────────────────────────────────────────────────────────

UPDATE player_tecnicas SET
    descricao = 'Técnica baseada em invocação de criaturas sombrias por energia amaldiçoada. Passivas: pode entrar nas sombras da técnica e se movimentar; pode guardar e trazer itens livremente nas sombras; sabe usar técnica reversa.'
WHERE id_player = 3 AND nome = 'Shinigami';


-- ────────────────────────────────────────────────────────────
-- PLAYER 4 — ADRIAN KREUZ
-- Mente zerada (estado especial / morte / evento de campanha)
-- ────────────────────────────────────────────────────────────

UPDATE player_mente SET
    sanidade    = 0,
    sanidadeMax = 0,
    stress      = 0,
    traumas     = 1,
    rm          = 45
WHERE id_player = 4;


-- ────────────────────────────────────────────────────────────
-- PLAYER 5 — AURELIAN TEMPEST
-- Sem mudanças numéricas
-- ────────────────────────────────────────────────────────────

-- (nenhum update necessário)


-- ────────────────────────────────────────────────────────────
-- PLAYER 6 — IKULIAN
-- Status, mente e jutsus atualizados
-- ────────────────────────────────────────────────────────────

UPDATE player_status SET
    level       = 30,
    forca       = 31,
    velocidade  = 25,
    agilidade   = 25,
    experiencia = 20,
    durabilidade= 25,
    combate     = 10
WHERE id_player = 6;

UPDATE player_energias SET
    stamina = 150,
    energia = 230,
    aura    = 20
WHERE id_player = 6;

UPDATE player_mente SET
    sanidade    = 40,
    sanidadeMax = 95,
    stress      = 72,
    traumas     = 1,
    rm          = 12
WHERE id_player = 6;

-- Jutsus atualizados: lightning flash lv3→4, gravity push lv3→4
-- Zeus Javelin desbloqueado: lv1 🔒 → lv2, custo 40 E.A.
-- Assumindo que player_tecnicas de Ikulian é id=7 (conforme tecnicas_jutsus_insert.sql)

UPDATE player_jutsus SET level = 4
WHERE id_tecnica = 7 AND nome = 'Lightning Flash';

UPDATE player_jutsus SET level = 4
WHERE id_tecnica = 7 AND nome = 'Gravity Push';

UPDATE player_jutsus SET
    level = 2,
    custo = 40,
    id_energia_custo = 2
WHERE id_tecnica = 7 AND nome = 'Zeus Javelin';


-- ────────────────────────────────────────────────────────────
-- PLAYER 7 — BACHIRA
-- Sem mudanças numéricas
-- ────────────────────────────────────────────────────────────

-- (nenhum update necessário)


-- ────────────────────────────────────────────────────────────
-- PLAYER 8 — YURI KONSHKINA
-- Sem mudanças numéricas
-- ────────────────────────────────────────────────────────────

-- (nenhum update necessário)


-- ────────────────────────────────────────────────────────────
-- NOVOS PLAYERS — Dom Saurom e Drakkmar
-- Ignorando invocações por agora (faremos depois)
-- Dom Saurom: classe Zero (não existe) → adicionar
-- Drakkmar: classe Dragão (não existe) → adicionar
-- ────────────────────────────────────────────────────────────

INSERT INTO classes (classe) VALUES
('Zero'),   -- TODO: confirmar id gerado
('Dragão'); -- TODO: confirmar id gerado

-- ── DOM SAUROM (id_player será gerado automaticamente = 10)
INSERT INTO player_base (nome, id_classe, efeitos) VALUES
('Dom Saurom S. M. D. H. A. P. H. M.',
 (SELECT id FROM classes WHERE classe = 'Zero'),
 '');

SET @saurom_id = LAST_INSERT_ID();

INSERT INTO player_dinheiro (id_player, dinheiro, fragmento)
VALUES (@saurom_id, 0, 0);


-- ATENÇÃO: LAST_INSERT_ID() acima retornou o id do player_dinheiro.
-- Use o id real do player após rodar. Ajuste @saurom_id manualmente se necessário.
-- TODO: confirmar id de Dom Saurom após insert e ajustar referências abaixo.

INSERT INTO player_status (id_player, level, hp, forca, velocidade, agilidade, durabilidade, combate, experiencia)
VALUES (@saurom_id, 28, 103, 25, 25, 25, 30, 7, 19);

INSERT INTO player_energias (id_player, iq, stamina, energia, aura)
VALUES (@saurom_id, 220, 60, 140, 18);

INSERT INTO player_mente (id_player, sanidade, sanidadeMax, stress, traumas, rm)
VALUES (@saurom_id, 79, 99, 57, 0, 35);

-- Título especial de Dom Saurom (nome completo como título)
INSERT INTO titulos (titulo) VALUES ('Nome Completo: Dom Saurom Solen Miyamoto Drácula Hattori Arc Pendragon Haya Magno');
INSERT INTO R_player_titulo (id_player, id_titulo)
VALUES (@saurom_id, LAST_INSERT_ID());

-- Técnica de Dom Saurom: Segunda Chance
-- Invocações ignoradas por agora — apenas a técnica base do player
INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES (@saurom_id, 'Segunda Chance',
'Liga a alma do usuário com a invocação, trazendo a alma de um falecido antigo por meio de um objeto e colocando-a em um corpo amaldiçoado visível a pessoas normais. A ligação faz com que um tenha metade da alma do outro.');
-- Jutsus de Dom Saurom: definidos nas invocações — faremos depois


-- ── DRAKKMAR C. DRACO (id_player gerado após Dom Saurom)
INSERT INTO player_base (nome, id_classe, efeitos) VALUES
('Drakkmar C. Draco',
 (SELECT id FROM classes WHERE classe = 'Dragão'),
 'A energia dele é KI (engloba prana, force, aura e E.A. em um só). Sem KI o usuário morre. Ele é de outra Era (fraturas).');

SET @drakkmar_id = LAST_INSERT_ID();

INSERT INTO player_dinheiro (id_player, dinheiro, fragmento)
VALUES (@drakkmar_id, 0, 0);

INSERT INTO player_status (id_player, level, hp, forca, velocidade, agilidade, durabilidade, combate, experiencia)
VALUES (@drakkmar_id, 14, 2400, 65, 75, 74, 70, 60, 100);

INSERT INTO player_energias (id_player, iq, stamina, energia, aura)
VALUES (@drakkmar_id, 400, 6000, 1600, 70);

INSERT INTO player_mente (id_player, sanidade, sanidadeMax, stress, traumas, rm)
VALUES (@drakkmar_id, 100, 130, 10, 1, 50);

-- Títulos de Drakkmar
INSERT INTO titulos (titulo) VALUES
('Dragão Verdadeiro'), -- TODO: confirmar ids
('Fujão');

INSERT INTO R_player_titulo (id_player, id_titulo)
SELECT @drakkmar_id, id FROM titulos WHERE titulo IN ('Dragão Verdadeiro', 'Fujão');

-- Técnica de Drakkmar (sem nome de técnica explícito → "Arte Dracônica")
INSERT INTO player_tecnicas (id_player, nome, descricao)
VALUES (@drakkmar_id, 'Arte Dracônica',
'Poderes naturais do Dragão Verdadeiro baseados em KI (energia unificada). Inclui acordos com o Autor e Quetzalcoatl. Benção Divina de Quetzalcoatl: Adaptação de Combate (+1 no dado por turno sem limite enquanto estiver lutando).');

SET @drakkmar_tec = LAST_INSERT_ID();

-- KI = E.A. como aproximação (id=2). TODO: considerar nova entrada na tabela energias para KI
INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao) VALUES
(@drakkmar_tec, 'Fogo Abissal',              30,  2, 14, 'Cone 80m. Dano = 3.6× Fogo base + DoT 3 turnos (10% do dano inicial/turno). Reduz resistência mágica do alvo em 25% por 2 turnos. +0,5% de dano por 10 de IQ.'),
(@drakkmar_tec, 'Mordida Venenosa',          30,  1, 1,  'Físico. Custo: 30 Stamina. Aplica Selo Dracônico (2 turnos): +15% dano recebido do Drakkmar.'),
(@drakkmar_tec, 'Pele de Ferro',             25,  2, 10, 'Reflexão Parcial: reflete 70% do dano mágico recebido ao atacante. +10 durabilidade durante uso.'),
(@drakkmar_tec, 'Sopro Abissal Ultimatum',   180, 2, 14, 'Ultimate. Custo: 180 KI + 120 Stamina. CD: 6 turnos. Canaliza 1 turno; cone 300m: dano = 3.5× Fogo Abissal. Paralisia mental 1 turno (baseada em IQ). Com Essência Dracônica: ×1.25 e paralisia 2 turnos.'),
(@drakkmar_tec, 'Garras Rachadoras',         30,  1, 12, 'Físico. Custo: 30 Stamina. Ataque duplo: segundo golpe ignora 30% armadura. Se 1º golpe leva alvo a <30% HP, 2º causa sangramento 2 turnos.'),
(@drakkmar_tec, 'Rugido do Suserano',        40,  2, 1,  'Suporte/controle. AOE 40m. CD: 4 turnos. -20% precisão inimiga 2 turnos; +10% dano físico aliado 2 turnos. Em Essência Titânica: provoca inimigos 1 turno.'),
(@drakkmar_tec, 'Sangue de Dragão',          100, 2, 1,  'Recuperação. Instant. Restaura 300 HP + 5% KI máximo. Penalidade: -25% taxa de recuperação de KI por 2 turnos.'),
(@drakkmar_tec, 'Escama Reflexiva',          0,   2, 10, 'Passiva. -32% dano recebido. Em Essência Titânica: 42% e +20% resistência a atordoamentos.'),
(@drakkmar_tec, 'Sentido Predador',          0,   2, 1,  'Passiva/crit. +20% chance crítica contra alvos com <50% HP. Ataque Duplo nesse estado: 2º ataque tem 100% acerto crítico.'),
(@drakkmar_tec, 'Vínculo do Autor',          300, 2, 1,  'Lenda. Uso único por combate. 300 KI + 200 Stamina. Ao receber dano letal: fica com 1 HP, cura 25% HP máximo, Imunidade a controle 2 turnos.'),
(@drakkmar_tec, 'Passo Dracônico',           20,  1, 1,  'Mobilidade/ataque. Custo: 20 Stamina. Teleporta até 122m + ataque cortante com prioridade (ignora iniciativa menor). Após Passo Furtivo: stun 1 turno.');

-- Habilidades básicas de Drakkmar
-- "Instinto" e "Acordos" não existem em habilidades_basicas — adicionando
INSERT INTO habilidades_basicas (nome, custo, id_energia_custo) VALUES
('Instinto',  30, 1),   -- Custo: 30 Stamina. TODO: confirmar id gerado
('Acordos',   0,  NULL); -- Passiva. Permite acordos com seres menores. TODO: id

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level) VALUES
(@drakkmar_id, 1, 1),   -- Recharge
(@drakkmar_id, 2, 10),  -- Passo Furtivo lv10
(@drakkmar_id, 3, 10),  -- Olho do Falcão lv10 (Olhos de Falcão)
(@drakkmar_id, 4, 1),   -- Defesa da Tartaruga Leão
(@drakkmar_id, 5, 1),   -- Coração de Leão
(@drakkmar_id, (SELECT id FROM habilidades_basicas WHERE nome = 'Instinto'), 10),
(@drakkmar_id, (SELECT id FROM habilidades_basicas WHERE nome = 'Acordos'), 1);