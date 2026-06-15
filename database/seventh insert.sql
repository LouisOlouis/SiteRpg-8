USE SiteRPG;

-- ============================================================
-- SEVENTH UPDATE - Atualização geral das fichas F001-F009
--                  + Inserção dos novos players F010 e F011
-- ============================================================
-- ATENÇÃO: execute na ordem. Não mexa nas invocações ainda.
-- ============================================================


-- ============================================================
-- 1. NOVAS CLASSES
-- ============================================================
-- ids continuam após 15 (Anti-Tank):
--   16 = Receptáculo
--   17 = Demônio
--   18 = Zero
--   19 = Dragão

INSERT INTO classes (classe) VALUES
('Receptaculo'),   -- id 16
('Demonio'),       -- id 17
('Zero'),          -- id 18
('Dragao');        -- id 19


-- ============================================================
-- 2. NOVA ENERGIA
-- ============================================================
-- ids existentes: 1=Prana, 2=E.A., 3=Aura
--   4 = KI

INSERT INTO energias (nome) VALUES
('KI');  -- id 4


-- ============================================================
-- 3. NOVOS TÍTULOS
-- ============================================================
-- Continuando após id 38 (O Problema):
--   39 = Receptáculo do Deus do Trovão
--   40 = Mini-Adolf
--   41 = Abandonado por Deus
--   42 = Dragão Verdadeiro
--   43 = Fujão
--   44 = Nome completo (Dom Saurom)

INSERT INTO titulos (titulo) VALUES
('Receptaculo do Trovao'),    -- id 39
('Mini-Adolf'),               -- id 40
('Abandonado por Deus'),      -- id 41
('Dragao Verdadeiro'),        -- id 42
('Fujao'),                    -- id 43
('Nome Completo');            -- id 44
-- OBS: o título completo de Dom Saurom é longo demais para VARCHAR(25).
-- TODO: considerar aumentar o campo titulo para VARCHAR(100) ou TEXT.


-- ============================================================
-- 4. ATUALIZAÇÃO DOS PLAYERS EXISTENTES (F001-F009)
-- ============================================================

-- ------------------------------------------------------------
-- F001 - LUKIS (id 1)
-- ------------------------------------------------------------
UPDATE player_status SET
    level        = 38,
    hp           = 450,
    forca        = 34,
    velocidade   = 25,
    agilidade    = 32,
    durabilidade = 55,
    combate      = 13,
    experiencia  = 15
WHERE id_player = 1;

UPDATE player_energias SET
    energia  = 180,
    stamina  = 120,
    iq       = 135,
    aura     = 14
WHERE id_player = 1;

UPDATE player_mente SET
    sanidade    = 92,
    sanidadeMax = 100,
    stress      = 53,
    traumas     = 1,
    rm          = 45
WHERE id_player = 1;

-- ------------------------------------------------------------
-- F002 - DIO SPIN KEINER (id 2)
-- ------------------------------------------------------------
-- Classe muda para Receptáculo (id 16)
UPDATE player_base SET
    id_classe = 16,
    efeitos   = 'Se aproximar de curse a incomoda e pode dar kill'
WHERE id = 2;

UPDATE player_status SET
    level        = 46,
    hp           = 1710,
    forca        = 50,
    velocidade   = 20,
    agilidade    = 30,
    durabilidade = 42,
    combate      = 18,
    experiencia  = 27
WHERE id_player = 2;

UPDATE player_energias SET
    energia  = 60,
    stamina  = 90,
    iq       = 196,
    aura     = 59
WHERE id_player = 2;

UPDATE player_mente SET
    sanidade    = 57,
    sanidadeMax = 90,
    stress      = 80,
    traumas     = 3,
    rm          = 28
WHERE id_player = 2;

UPDATE player_dinheiro SET dinheiro = 10175 WHERE id_player = 2;

-- Título novo: Receptáculo do Deus do Trovão (id 39)
-- Título Mestre da Careta já existe (id 4) e já estava inserido no first_insert
-- Verificar se já não foi inserido antes de rodar:
INSERT INTO R_player_titulo (id_player, id_titulo) VALUES
(2, 39);   -- Receptáculo do Trovão
-- OBS: (2,4) Mestre da Careta já existe no first_insert.sql

-- ------------------------------------------------------------
-- F003 - DAMIAN JACKSON (id 3)
-- ------------------------------------------------------------
UPDATE player_status SET
    level        = 45,
    hp           = 780,
    forca        = 25,
    velocidade   = 15,
    agilidade    = 14,
    durabilidade = 41,
    combate      = 14,
    experiencia  = 25
WHERE id_player = 3;

UPDATE player_energias SET
    energia  = 220,
    stamina  = 165,
    iq       = 190,
    aura     = 30
WHERE id_player = 3;

UPDATE player_mente SET
    sanidade    = 90,
    sanidadeMax = 100,
    stress      = 39,
    traumas     = 0,
    rm          = 18
WHERE id_player = 3;

UPDATE player_dinheiro SET dinheiro = 478244 WHERE id_player = 3;

-- Novos itens de Damian
INSERT INTO itens (item, id_raridade, descricao) VALUES
('Lanca Gravity',            3, 'Lança imbuída com força gravitacional.'),
('Espada Multipla Sombra',   4, 'Espada que se replica pelas sombras.'),
('Mingun',                   3, 'Metralhadora de alta cadência.');

-- Damian recebe: Lança Gravity, Espada Múltipla de Sombra, 3x Mingun (na bolsa do vazio)
-- OBS: os ids dos itens acima dependem do MAX(id) atual da tabela itens.
-- Assumindo continuação após id 97 (última faca de Koishi):
--   98 = Lança Gravity
--   99 = Espada Múltipla de Sombra
--   100 = Mingun
INSERT INTO R_player_item (id_player, id_item) VALUES
(3, 98),   -- Lança Gravity
(3, 99),   -- Espada Múltipla de Sombra
(3, 100),  -- Mingun 1
(3, 100),  -- Mingun 2
(3, 100);  -- Mingun 3

-- ------------------------------------------------------------
-- F004 - ADRIAN KREUZ (id 4)
-- ------------------------------------------------------------
-- Classe muda para Demônio (id 17)
UPDATE player_base SET
    id_classe = 17,
    efeitos   = 'Maligno'
WHERE id = 4;

UPDATE player_status SET
    level        = 30,
    hp           = 1000,
    forca        = 30,
    velocidade   = 30,
    agilidade    = 30,
    durabilidade = 30,
    combate      = 16,
    experiencia  = 20
WHERE id_player = 4;

UPDATE player_energias SET
    energia  = 1250,
    stamina  = 150,
    iq       = 140,
    aura     = 30
WHERE id_player = 4;

UPDATE player_mente SET
    sanidade    = 0,
    sanidadeMax = 0,
    stress      = 0,
    traumas     = 1,
    rm          = 50
WHERE id_player = 4;

UPDATE player_dinheiro SET dinheiro = 0 WHERE id_player = 4;

-- Título novo: Abandonado por Deus (id 41)
INSERT INTO R_player_titulo (id_player, id_titulo) VALUES
(4, 41);

-- Novo item: Armadura rúnica com encantamentos
INSERT INTO itens (item, id_raridade, descricao) VALUES
('Armadura Runica', 3, 'Armadura com Runa de Protecao III (+3 durabilidade) e Talisma de Visao II.');
-- id 101 = Armadura Rúnica

INSERT INTO R_player_item (id_player, id_item) VALUES
(4, 101);

-- Estilo de luta Capoeira (id 4) para Adrian
-- OBS: Adrian tinha Capoeira mencionado na ficha mas no forth_insert só tinha id_estiloluta 1 (Sem Estilo).
-- Adicionando Capoeira (id 4) e Pro-Player (id 3):
INSERT INTO R_player_estiloluta (id_player, id_estiloluta) VALUES
(4, 3),  -- Pro-Player
(4, 4);  -- Capoeira

-- ------------------------------------------------------------
-- F005 - AURELIAN TEMPEST (id 5)
-- ------------------------------------------------------------
UPDATE player_status SET
    level        = 34,
    hp           = 226,
    forca        = 2,
    velocidade   = 60,
    agilidade    = 31,
    durabilidade = 24,
    combate      = 9,
    experiencia  = 23
WHERE id_player = 5;

UPDATE player_energias SET
    energia  = 200,
    stamina  = 85,
    iq       = 160,
    aura     = 20
WHERE id_player = 5;

UPDATE player_mente SET
    sanidade    = 70,
    sanidadeMax = 90,
    stress      = 49,
    traumas     = 2,
    rm          = 10
WHERE id_player = 5;

-- Novos itens de Aurelian
INSERT INTO itens (item, id_raridade, descricao) VALUES
('Cajado Personalidade',      3, 'Cajado com personalidade propria. HP: 120.'),
('Talisma de Subjulgacao',    4, 'Talisma nivel 4 de subjulgacao.'),
('Talisma Destroi Cidade',    5, 'Talisma nivel 7. Poder de destruicao em area de cidade.');
-- ids: 102 = Cajado Personalidade, 103 = Talisma Subjulgacao, 104 = Talisma Destroi Cidade

INSERT INTO R_player_item (id_player, id_item) VALUES
(5, 102),   -- Cajado Personalidade
(5, 103),   -- Talismã Subjulgação 1
(5, 103),   -- Talismã Subjulgação 2
(5, 104);   -- Talismã Destroi Cidade

-- ------------------------------------------------------------
-- F006 - IKULIAN (id 6)
-- ------------------------------------------------------------
UPDATE player_status SET
    level        = 37,
    hp           = 315,
    forca        = 35,
    velocidade   = 30,
    agilidade    = 30,
    durabilidade = 30,
    combate      = 12,
    experiencia  = 23
WHERE id_player = 6;

UPDATE player_energias SET
    energia  = 255,
    stamina  = 160,
    iq       = 130,
    aura     = 23
WHERE id_player = 6;

UPDATE player_mente SET
    sanidade    = 40,
    sanidadeMax = 95,
    stress      = 72,
    traumas     = 1,
    rm          = 15
WHERE id_player = 6;

-- Zeus Javelin desbloqueado: lvl 3, custo 40 E.A.
-- id_tecnica 7 = técnica de Ikulian (fifth_insert.sql)
UPDATE player_jutsus SET
    custo   = 40,
    level   = 3,
    descricao = '-- TODO: adicionar descrição detalhada'
WHERE id_tecnica = 7 AND nome = 'Zeus Javelin';

-- Vimeinun Myrsky: agora lvl 2, custo ainda NULL (missão pendente)
UPDATE player_jutsus SET
    level = 2
WHERE id_tecnica = 7 AND nome = 'Vimeinun Myrsky';

-- Novos itens de Ikulian
INSERT INTO itens (item, id_raridade, descricao) VALUES
('Espada de Luz',  4, 'Espada imbuída com energia luminosa.'),
('Espada de Fogo', 4, 'Espada imbuída com chamas.'),
('Tormenta Rubra', 4, 'Arma de energia vermelha tempestuosa.');
-- ids: 105 = Espada de Luz, 106 = Espada de Fogo, 107 = Tormenta Rubra

INSERT INTO R_player_item (id_player, id_item) VALUES
(6, 105),   -- Espada de Luz
(6, 106),   -- Espada de Fogo
(6, 107);   -- Tormenta Rubra

-- ------------------------------------------------------------
-- F007 - BACHIRA (id 7)
-- ------------------------------------------------------------
UPDATE player_base SET
    efeitos = 'Destruct (Impede de criar buffs proprios)'
WHERE id = 7;

UPDATE player_status SET
    level        = 36,
    hp           = 295,
    forca        = 25,
    velocidade   = 25,
    agilidade    = 20,
    durabilidade = 24,
    combate      = 10,
    experiencia  = 19
WHERE id_player = 7;

UPDATE player_energias SET
    energia  = 290,
    stamina  = 125,
    iq       = 130,
    aura     = 20
WHERE id_player = 7;

UPDATE player_mente SET
    sanidade    = 47,
    sanidadeMax = 90,
    stress      = 60,
    traumas     = 0,
    rm          = 45
WHERE id_player = 7;

-- Título novo: Mini-Adolf (id 40)
INSERT INTO R_player_titulo (id_player, id_titulo) VALUES
(7, 40);

-- ------------------------------------------------------------
-- F008 - YURI KONSHKINA (id 8)
-- ------------------------------------------------------------
UPDATE player_status SET
    level        = 20,
    hp           = 145,
    forca        = 15,
    velocidade   = 13,
    agilidade    = 13,
    durabilidade = 13,
    combate      = 10,
    experiencia  = 9
WHERE id_player = 8;

UPDATE player_energias SET
    energia  = 110,
    stamina  = 90,
    iq       = 125,
    aura     = 14
WHERE id_player = 8;

UPDATE player_mente SET
    sanidade    = 110,
    sanidadeMax = 110,
    stress      = 30,
    traumas     = 0,
    rm          = 15
WHERE id_player = 8;

UPDATE player_dinheiro SET dinheiro = 5080 WHERE id_player = 8;

-- Encantamentos de Yuri (body - vestimentas)
-- Poseidon (id 35 no encantamentos), Espectro de Chamas (id 24), Enigma (id 31)
-- já estão em R_player_encantamento do forth_insert: (8,35,3),(8,24,3),(8,31,7) ✓

-- ------------------------------------------------------------
-- F009 - KOISHI KOMEIJI (id 9)
-- ------------------------------------------------------------
-- Status praticamente iguais, apenas confirmar:
UPDATE player_status SET
    level        = 1,
    hp           = 105,
    forca        = 1,
    velocidade   = 1,
    agilidade    = 1,
    durabilidade = 2,
    combate      = 1,
    experiencia  = 3
WHERE id_player = 9;

UPDATE player_energias SET
    energia  = 25,
    stamina  = 25,
    iq       = 105,
    aura     = 1
WHERE id_player = 9;

UPDATE player_mente SET
    sanidade    = 100,
    sanidadeMax = 100,
    stress      = 10,
    traumas     = 0,
    rm          = 15
WHERE id_player = 9;


-- ============================================================
-- 5. NOVOS PLAYERS
-- ============================================================

-- ------------------------------------------------------------
-- F010 - DOM SAUROM (id 10)
-- Classe: Zero (id 18)
-- ------------------------------------------------------------

INSERT INTO player_base (nome, id_classe, efeitos) VALUES
('Dom Saurom S.M.D.H.A.P.H.M.', 18, NULL);
-- id 10

INSERT INTO player_dinheiro (id_player, dinheiro, fragmento) VALUES
(10, 0, 0);

INSERT INTO player_status (id_player, level, hp, forca, velocidade, agilidade, durabilidade, combate, experiencia) VALUES
(10, 28, 103, 25, 25, 25, 30, 7, 19);

INSERT INTO player_energias (id_player, iq, stamina, energia, aura) VALUES
(10, 220, 60, 140, 18);

INSERT INTO player_mente (id_player, sanidade, sanidadeMax, stress, traumas, rm) VALUES
(10, 79, 99, 57, 0, 35);

-- Título de Dom Saurom: "Nome Completo" (id 44)
INSERT INTO R_player_titulo (id_player, id_titulo) VALUES
(10, 44);

-- Itens de Dom Saurom
INSERT INTO itens (item, id_raridade, descricao) VALUES
('Brasao Solen',  2, 'Brasão da família Solen.'),
('Runa Roxa',     2, 'Ressonancia Lunar N.II: ataques noturnos ganham dano de energia lunar; durante o dia, neutro. Nao encantada.'),
('Runa Verde',    2, 'Rede de Niquel N.IV: projeta rede que reduz velocidade inimiga pela metade por 2 turnos. Nao encantada.');
-- ids: 108 = Brasão Solen, 109 = Runa Roxa, 110 = Runa Verde

INSERT INTO R_player_item (id_player, id_item) VALUES
(10, 108),   -- Brasão Solen
(10,  77),   -- Celular (id 77, já existia)
(10, 109),   -- Runa Roxa (não encantada/não usada)
(10, 110);   -- Runa Verde (não encantada/não usada)

-- Técnica e jutsus de Dom Saurom
-- Técnica: Segunda Chance (id_tecnica = 11)
INSERT INTO player_tecnicas (id_player, nome, descricao) VALUES
(10, 'Segunda Chance', 'Liga a alma do usuario com uma invocacao, trazendo a alma de um falecido por meio de um objeto e colocando-a em um corpo amaldicado. A invocacao e literalmente a pessoa falecida (e a alma). A ligacao: cada um tem metade da alma do outro.');

-- Dom Saurom não tem jutsus próprios listados (poderes são via invocações)
-- TODO: adicionar jutsus quando definidos

-- Habilidades básicas de Dom Saurom: nenhuma listada ainda
-- TODO: confirmar com o mestre


-- ------------------------------------------------------------
-- F011 - DRAKKMAR C. DRACO (id 11)
-- Classe: Dragão (id 19)
-- Energia: KI (id 4)
-- ------------------------------------------------------------

INSERT INTO player_base (nome, id_classe, efeitos) VALUES
('Drakkmar C. Draco', 19, 'KI');
-- id 11

INSERT INTO player_dinheiro (id_player, dinheiro, fragmento) VALUES
(11, 0, 0);

INSERT INTO player_status (id_player, level, hp, forca, velocidade, agilidade, durabilidade, combate, experiencia) VALUES
(11, 14, 2400, 65, 75, 74, 70, 60, 100);

INSERT INTO player_energias (id_player, iq, stamina, energia, aura) VALUES
(11, 400, 6000, 1600, 70);
-- OBS: energia aqui representa KI (id_energia referenciaria id 4 nos jutsus)

INSERT INTO player_mente (id_player, sanidade, sanidadeMax, stress, traumas, rm) VALUES
(11, 100, 130, 10, 1, 50);

-- Títulos de Drakkmar
INSERT INTO R_player_titulo (id_player, id_titulo) VALUES
(11, 42),   -- Dragão Verdadeiro
(11, 43);   -- Fujão

-- Drakkmar não tem itens listados ("só a roupa") — nenhum INSERT de item

-- Técnica e jutsus de Drakkmar
-- id_tecnica = 12
INSERT INTO player_tecnicas (id_player, nome, descricao) VALUES
(11, 'Tecnica Dragao', 'Poderes dracônicos de Drakkmar C. Draco. Energia usada: KI.');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao) VALUES
(12, 'Fogo Abissal',
     30, 4, 14,
     'Magico. Cone 80m. Dano = 3.6x Fogo base + DoT 3 turnos (10% do dano inicial/turno). Reduz RM magica do alvo em 25% por 2 turnos. +0,5% dano por 10 de IQ.'),
(12, 'Mordida Venenosa',
     30, NULL, 14,
     'Fisico. Custo: 30 Stamina. Veneno padrao + Selo Draconico (2 turnos): dano recebido do Drakkmar +15%.'),
(12, 'Pele de Ferro',
     25, 4, 10,
     'Reflexao Parcial: reflete 70% do dano magico de volta ao atacante enquanto ativa. +10 durabilidade durante uso.'),
(12, 'Sopro Abissal Ultimatum',
     180, 4, 14,
     'Ultimate. Magico. Custo: 180 KI + 120 Stamina. CD: 6 turnos. Canaliza 1 turno, cone 300m. Dano = 3.5x Fogo Abissal. Paralisia mental 1 turno (baseada no IQ). Se Essencia Draconíca ativa: dano x1.25 e paralisia 2 turnos.'),
(12, 'Garras Rachadoras',
     30, NULL, 12,
     'Fisico. Custo: 30 Stamina. Dois golpes; segundo ignora 30% armadura. Se primeiro derruba alvo a <30% HP, causa sangramento 2 turnos.'),
(12, 'Rugido do Suserano',
     40, 4, 14,
     'Suporte/controle. AOE 40m. CD: 4 turnos. Reduz precisao inimiga 20% por 2 turnos e dano fisico aliado +10% por 2 turnos. Em Essencia Titanica: tambem provoca inimigos 1 turno.'),
(12, 'Sangue de Dragao',
     100, 4, 14,
     'Recuperacao. Instant. Restaura 300 HP + 5% do KI maximo. Reduz taxa de recuperacao de KI em 25% por 2 turnos.'),
(12, 'Passo Draconico',
     20, NULL, 14,
     'Mobilidade/ataque. Custo: 20 Stamina. Teleporta ate 122m e faz ataque cortante com prioridade (ignora iniciativa menor). Se usado apos Passo Furtivo: stun 1 turno.');

-- Passivas de Drakkmar (inseridas como jutsus com custo NULL para indicar passiva)
INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao) VALUES
(12, 'Escama Reflexiva',
     NULL, NULL, 10,
     'Passiva. Reduz dano recebido em 32%. Em Essencia Titanica: 42% e +20% resistencia a atordoamentos.'),
(12, 'Sentido Predador',
     NULL, NULL, 14,
     'Passiva/crit. +20% chance critica contra alvos com <50% HP. Em Ataque Duplo nesse estado: segundo ataque tem 100% critico.'),
(12, 'Vinculo do Autor',
     300, 4, 14,
     'Lenda. Uso unico por combate. Custo: 300 KI + 200 Stamina. Ao receber dano letal: fica com 1 HP, cura 25% HP maximo, Imunidade a controle 2 turnos.');

-- Habilidades básicas de Drakkmar
-- Recharge (id 1), Passo Furtivo (id 2), Coração de Leão (id 5), Defesa Tartaruga Leão (id 4), Olhos de Falcão (id 3)
INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level) VALUES
(11, 1, 1),   -- Recharge
(11, 2, 10),  -- Passo Furtivo (lvl 10)
(11, 3, 1),   -- Olhos de Falcão
(11, 4, 1),   -- Defesa da Tartaruga Leão
(11, 5, 1);   -- Coração de Leão

-- Habilidade extra: Instinto e Acordos — não existem nas tabelas atuais
-- TODO: adicionar 'Instinto' e 'Acordos' em habilidades_basicas se o mestre quiser
-- INSERT INTO habilidades_basicas (nome, custo, id_energia_custo) VALUES ('Instinto', 30, NULL), ('Acordos', NULL, NULL);
-- E então inserir em R_player_habilidades_basicas para Drakkmar (id 11)


-- ============================================================
-- 6. TALENTOS DOS NOVOS PLAYERS
-- ============================================================

-- Dom Saurom: talento não definido ainda
-- TODO: inserir quando o mestre definir

-- Drakkmar: bênção da Quetzalcoatl e acordos como talento
INSERT INTO player_talentos (id_player, nome, descricao) VALUES
(11, 'Bencao Quetzalcoatl',
     'Adaptacao de combate: enquanto lutando, ganha +1 no dado por turno sem limites. Funciona ate ser interrompida por autoridade, lei absoluta ou algo mais poderoso.'),
(11, 'Acordos',
     'Pode fazer acordos com seres menores: Humanos, Maldicoes, Cancrios, Quints, Sints, Onis, Demi-Humanos, Elfos, Gigantes, Meio-draconianos, Anoes, Orcs, Demonios de baixo nivel.'),
(11, 'Acordo com Autor',
     'Acordo feito com o Autor. Ativa Vinculo do Autor em combate.'),
(11, 'Acordo Quetzalcoatl',
     'Acordo feito com Quetzalcoatl.');


-- ============================================================
-- 7. NOVAS HABILIDADES DE CLASSE
-- ============================================================
-- Para Receptáculo (Dio) — classe id 16
-- Para Demônio (Adrian) — classe id 17 (já tem as invocações da classe antiga;
--   as invocações do Demônio são as mesmas mas com sabor diferente, manter)
-- Para Zero e Dragão — TODO quando definidas

-- Habilidades de classe do Receptáculo (Dio)
-- A ficha menciona: Golpe Marcial (já existe id 6 para Guerreiro)
-- e poderes de Shikigami/Maldição que são jutsus, não habilidades de classe
-- TODO: confirmar se o Receptáculo tem habilidades de classe próprias

-- Habilidade de classe do Dragão (Drakkmar)
-- Ficha diz "Não tem mais classe depois da transição de Era"
-- Nenhum insert necessário

-- ============================================================
-- FIM DO SEVENTH UPDATE
-- ============================================================
-- PENDÊNCIAS MARCADAS COM TODO:
-- 1. VARCHAR(25) em titulos muito curto para o nome completo de Dom Saurom
-- 2. Instinto e Acordos como habilidades básicas do Drakkmar
-- 3. Habilidades de classe do Receptáculo (Dio)
-- 4. Jutsus de Dom Saurom quando definidos
-- 5. Talento de Dom Saurom quando definido
-- 6. Habilidades de classe para Zero e Dragão quando definidas
-- 7. As invocações de Dom Saurom (Miyamoto, Dom Pedro II, Vlad, Hattori, Joan of Arc,
--    Rei Arthur, Simo Häyhä, Alexandre o Grande) — aguardando ordem do mestre
-- 8. Custo real de Vimeinun Myrsky do Ikulian (missão pendente)
-- ============================================================