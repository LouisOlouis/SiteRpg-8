USE SiteRPG;

-- ============================================================
-- 7th INSERT — versão corrigida, sem subqueries em VALUES
-- Todos os IDs são hardcodados com referência comentada
-- ============================================================
-- MAPA DE IDs (acumulado de todos os inserts anteriores)
--
-- CLASSES:
--   1=Guerreiro  2=Paladino   3=Sniper    4=Invocador  5=Bardo
--   6=Mago       7=Tank       8=Healer    9=Assassino  10=Ladino
--   11=Monge     12=Barbaro   13=Clerigo  14=Destruidor 15=Anti-Tank
--   16=Receptáculo (novo)  17=Zero (novo)  18=Dragão (novo)
--
-- ENERGIAS:  1=Prana  2=E.A.  3=Aura
--
-- TÍTULOS (novos, após os 38 do first_insert):
--   39=Receptáculo do Deus do Trovão
--   40=Nome Completo Dom Saurom (longo)
--   41=Dragão Verdadeiro
--   42=Fujão
--
-- HABILIDADES BÁSICAS:
--   1=Recharge  2=Passo Furtivo  3=Olho do Falcão
--   4=Defesa da Tartaruga Leão   5=Coração de Leão  6=Soco de Núcleo
--   7=Instinto (novo)  8=Acordos (novo)
--
-- HABILIDADES DE CLASSE:
--   1=Regeneração E.A.  2=Resistência Infernal  3=Sobrevivência Crítica
--   4=Invocação do Instinto  5=Invocação Mafioso  6=Golpe Marcial
--   7=Impacto Reluzente  8=Linha de Tiro Calculada
--   9=Cura  10=Recharge(Healer)  11=Acúmulo de E.A.
--
-- PLAYER_TECNICAS:
--   1=Jutsu Corrompido(1)  2=Shinigami(3)  3=Guerra(4)  4=Infernal(4)
--   5=Técnica Base(5)  6=Jutsus Gulados(5)  7=Técnica Base(6)
--   8=Técnica Base(7)  9=Técnica Base(8)  10=Técnica Base(9)
--   11=Segunda Chance(10/Dom Saurom)  12=Arte Dracônica(11/Drakkmar)
--
-- PLAYERS:
--   1=Lukis  2=Dio  3=Damian  4=Adrian  5=Aurelian
--   6=Ikulian  7=Bachira  8=Yuri  9=Koishi
--   10=Dom Saurom (novo)  11=Drakkmar (novo)
-- ============================================================


-- ────────────────────────────────────────────────────────────
-- STEP 1: NOVAS CLASSES (só insere se não existir)
-- ────────────────────────────────────────────────────────────

INSERT INTO classes (classe)
SELECT 'Receptáculo' WHERE NOT EXISTS (SELECT 1 FROM classes WHERE classe = 'Receptáculo');

INSERT INTO classes (classe)
SELECT 'Zero' WHERE NOT EXISTS (SELECT 1 FROM classes WHERE classe = 'Zero');

INSERT INTO classes (classe)
SELECT 'Dragão' WHERE NOT EXISTS (SELECT 1 FROM classes WHERE classe = 'Dragão');


-- ────────────────────────────────────────────────────────────
-- STEP 2: NOVOS TÍTULOS
-- ────────────────────────────────────────────────────────────

INSERT INTO titulos (titulo)
SELECT 'Receptáculo do Deus do Trovão'
WHERE NOT EXISTS (SELECT 1 FROM titulos WHERE titulo = 'Receptáculo do Deus do Trovão');

INSERT INTO titulos (titulo)
SELECT 'Nome Completo: Dom Saurom Solen Miyamoto Drácula Hattori Arc Pendragon Haya Magno'
WHERE NOT EXISTS (SELECT 1 FROM titulos WHERE titulo LIKE 'Nome Completo%');

INSERT INTO titulos (titulo)
SELECT 'Dragão Verdadeiro'
WHERE NOT EXISTS (SELECT 1 FROM titulos WHERE titulo = 'Dragão Verdadeiro');

INSERT INTO titulos (titulo)
SELECT 'Fujão'
WHERE NOT EXISTS (SELECT 1 FROM titulos WHERE titulo = 'Fujão');


-- ────────────────────────────────────────────────────────────
-- STEP 3: NOVAS HABILIDADES BÁSICAS
-- ────────────────────────────────────────────────────────────

INSERT INTO habilidades_basicas (nome, custo, id_energia_custo)
SELECT 'Instinto', 30, 1
WHERE NOT EXISTS (SELECT 1 FROM habilidades_basicas WHERE nome = 'Instinto');

INSERT INTO habilidades_basicas (nome, custo, id_energia_custo)
SELECT 'Acordos', 0, NULL
WHERE NOT EXISTS (SELECT 1 FROM habilidades_basicas WHERE nome = 'Acordos');


-- ────────────────────────────────────────────────────────────
-- STEP 4: NOVOS ITENS
-- ────────────────────────────────────────────────────────────

INSERT INTO itens (item, id_raridade, descricao)
SELECT 'Lança Gravity', 3, 'Lança imbuída com propriedades gravitacionais.'
WHERE NOT EXISTS (SELECT 1 FROM itens WHERE item = 'Lança Gravity');

INSERT INTO itens (item, id_raridade, descricao)
SELECT 'Espada Múltipla de Sombra', 3, 'Espada que pode se multiplicar nas sombras.'
WHERE NOT EXISTS (SELECT 1 FROM itens WHERE item = 'Espada Múltipla de Sombra');

INSERT INTO itens (item, id_raridade, descricao)
SELECT '3 Miniguns', 2, 'Três miniguns para uso em combate.'
WHERE NOT EXISTS (SELECT 1 FROM itens WHERE item = '3 Miniguns');

INSERT INTO itens (item, id_raridade, descricao)
SELECT 'Espada de Luz', 3, 'Espada imbuída com energia de luz.'
WHERE NOT EXISTS (SELECT 1 FROM itens WHERE item = 'Espada de Luz');

INSERT INTO itens (item, id_raridade, descricao)
SELECT 'Espada de Fogo', 3, 'Espada imbuída com chamas.'
WHERE NOT EXISTS (SELECT 1 FROM itens WHERE item = 'Espada de Fogo');

INSERT INTO itens (item, id_raridade, descricao)
SELECT 'Tormenta Rubra', 4, '-- TODO: adicionar descrição detalhada'
WHERE NOT EXISTS (SELECT 1 FROM itens WHERE item = 'Tormenta Rubra');

INSERT INTO itens (item, id_raridade, descricao)
SELECT 'Brasão Solen', 1, 'Brasão da família Solen.'
WHERE NOT EXISTS (SELECT 1 FROM itens WHERE item = 'Brasão Solen');

INSERT INTO itens (item, id_raridade, descricao)
SELECT 'Runa Roxa', 2, 'Runa com Ressonância Lunar II — não aplicada/encantada.'
WHERE NOT EXISTS (SELECT 1 FROM itens WHERE item = 'Runa Roxa');

INSERT INTO itens (item, id_raridade, descricao)
SELECT 'Runa Verde', 2, 'Runa com Rede de Níquel IV — não aplicada/encantada.'
WHERE NOT EXISTS (SELECT 1 FROM itens WHERE item = 'Runa Verde');


-- ============================================================
-- A PARTIR DAQUI: usa variáveis para todos os IDs dinâmicos
-- ============================================================

-- Carrega IDs de classes novas
SET @id_receptaculo = (SELECT id FROM classes WHERE classe = 'Receptáculo');
SET @id_zero        = (SELECT id FROM classes WHERE classe = 'Zero');
SET @id_dragao      = (SELECT id FROM classes WHERE classe = 'Dragão');

-- Carrega IDs de títulos novos
SET @tit_receptaculo = (SELECT id FROM titulos WHERE titulo = 'Receptáculo do Deus do Trovão');
SET @tit_saurom      = (SELECT id FROM titulos WHERE titulo LIKE 'Nome Completo%');
SET @tit_dragao_v    = (SELECT id FROM titulos WHERE titulo = 'Dragão Verdadeiro');
SET @tit_fujao       = (SELECT id FROM titulos WHERE titulo = 'Fujão');

-- Carrega IDs de habilidades básicas novas
SET @hab_instinto = (SELECT id FROM habilidades_basicas WHERE nome = 'Instinto');
SET @hab_acordos  = (SELECT id FROM habilidades_basicas WHERE nome = 'Acordos');

-- Carrega IDs de itens novos
SET @item_lanca_gravity    = (SELECT id FROM itens WHERE item = 'Lança Gravity');
SET @item_espada_sombra    = (SELECT id FROM itens WHERE item = 'Espada Múltipla de Sombra');
SET @item_miniguns         = (SELECT id FROM itens WHERE item = '3 Miniguns');
SET @item_espada_luz       = (SELECT id FROM itens WHERE item = 'Espada de Luz');
SET @item_espada_fogo      = (SELECT id FROM itens WHERE item = 'Espada de Fogo');
SET @item_tormenta         = (SELECT id FROM itens WHERE item = 'Tormenta Rubra');
SET @item_brasao_solen     = (SELECT id FROM itens WHERE item = 'Brasão Solen');
SET @item_runa_roxa        = (SELECT id FROM itens WHERE item = 'Runa Roxa');
SET @item_runa_verde       = (SELECT id FROM itens WHERE item = 'Runa Verde');
SET @item_celular          = (SELECT id FROM itens WHERE item = 'Celular');


-- ────────────────────────────────────────────────────────────
-- STEP 5: UPDATES DE PLAYERS EXISTENTES
-- ────────────────────────────────────────────────────────────

-- ── LUKIS (id=1): hp, level, velocidade, agilidade, experiencia ──

UPDATE player_status SET
    level       = 34,
    hp          = 330,
    velocidade  = 25,
    agilidade   = 32,
    experiencia = 15
WHERE id_player = 1;

UPDATE player_mente SET
    sanidade    = 92,
    sanidadeMax = 100,
    stress      = 53,
    traumas     = 1,
    rm          = 45
WHERE id_player = 1;


-- ── DIO SPIN KEINER (id=2): atualiza tudo ──

UPDATE player_base SET
    nome      = 'Dio Spin Keiner',
    id_classe = @id_receptaculo,
    efeitos   = 'Ao se aproximar de uma maldição começa a incomodá-la, e se pá da kill'
WHERE id = 2;

UPDATE player_dinheiro SET dinheiro = 10175, fragmento = 0 WHERE id_player = 2;

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

-- Títulos do Dio: Graduado(1) e Mestre da Careta(4) já existem no first_insert
-- Adiciona Receptáculo do Deus do Trovão (só se não existir)
INSERT INTO R_player_titulo (id_player, id_titulo)
SELECT 2, @tit_receptaculo
WHERE NOT EXISTS (
    SELECT 1 FROM R_player_titulo WHERE id_player = 2 AND id_titulo = @tit_receptaculo
);

-- Estilo de luta: Pro-Player (id=3)
INSERT INTO R_player_estiloluta (id_player, id_estiloluta)
SELECT 2, 3
WHERE NOT EXISTS (
    SELECT 1 FROM R_player_estiloluta WHERE id_player = 2 AND id_estiloluta = 3
);

-- Habilidades básicas do Dio
INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT 2, 1, 1 WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = 2 AND id_habilidade_basica = 1);  -- Recharge

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT 2, 4, 1 WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = 2 AND id_habilidade_basica = 4);  -- Defesa da Tartaruga Leão

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT 2, 6, 1 WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = 2 AND id_habilidade_basica = 6);  -- Soco de Núcleo

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT 2, 2, 1 WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = 2 AND id_habilidade_basica = 2);  -- Passo Furtivo

-- Habilidade de classe: Golpe Marcial (id=6)
INSERT INTO R_player_habilidade_classe (id_player, id_habilidade_classe, level)
SELECT 2, 6, 1
WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidade_classe WHERE id_player = 2 AND id_habilidade_classe = 6);

-- Talentos do Dio
INSERT INTO player_talentos (id_player, nome, descricao)
SELECT 2, 'Aprende Rápido', 'Aprende rapidamente novas técnicas e habilidades.'
WHERE NOT EXISTS (SELECT 1 FROM player_talentos WHERE id_player = 2 AND nome = 'Aprende Rápido');

INSERT INTO player_talentos (id_player, nome, descricao)
SELECT 2, 'Bênção Divina do Trovão',
'Manipular Raios/Eletricidade conforme sua vontade sem restrição, apenas custo. Acordo com a semi-deusa Freya: o jogador é guiado e recebe conselhos e ajuda, mas em troca se torna servo de Freya e deve obedecer suas ordens.'
WHERE NOT EXISTS (SELECT 1 FROM player_talentos WHERE id_player = 2 AND nome = 'Bênção Divina do Trovão');


-- ── DAMIAN (id=3): atualiza descrição da técnica ──

UPDATE player_tecnicas SET
    descricao = 'Técnica baseada em invocação de criaturas sombrias por energia amaldiçoada. Passivas: pode entrar e se mover nas sombras; pode guardar e trazer itens livremente pelas sombras; sabe usar técnica reversa.'
WHERE id_player = 3 AND nome = 'Shinigami';

-- Itens novos do Damian
INSERT INTO R_player_item (id_player, id_item)
SELECT 3, @item_lanca_gravity
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = 3 AND id_item = @item_lanca_gravity);

INSERT INTO R_player_item (id_player, id_item)
SELECT 3, @item_espada_sombra
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = 3 AND id_item = @item_espada_sombra);

INSERT INTO R_player_item (id_player, id_item)
SELECT 3, @item_miniguns
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = 3 AND id_item = @item_miniguns);


-- ── ADRIAN (id=4): mente zerada (evento de campanha) ──

UPDATE player_mente SET
    sanidade    = 0,
    sanidadeMax = 0,
    stress      = 0,
    traumas     = 1,
    rm          = 45
WHERE id_player = 4;


-- ── IKULIAN (id=6): status, mente, jutsus e itens ──

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

-- Jutsus atualizados de Ikulian (id_tecnica=7)
UPDATE player_jutsus SET level = 4 WHERE id_tecnica = 7 AND nome = 'Lightning Flash';
UPDATE player_jutsus SET level = 4 WHERE id_tecnica = 7 AND nome = 'Gravity Push';
UPDATE player_jutsus SET level = 2, custo = 40, id_energia_custo = 2
WHERE id_tecnica = 7 AND nome = 'Zeus Javelin';

-- Itens novos de Ikulian
INSERT INTO R_player_item (id_player, id_item)
SELECT 6, @item_espada_luz
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = 6 AND id_item = @item_espada_luz);

INSERT INTO R_player_item (id_player, id_item)
SELECT 6, @item_espada_fogo
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = 6 AND id_item = @item_espada_fogo);

INSERT INTO R_player_item (id_player, id_item)
SELECT 6, @item_tormenta
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = 6 AND id_item = @item_tormenta);


-- ────────────────────────────────────────────────────────────
-- STEP 6: NOVO PLAYER — DOM SAUROM (id=10)
-- ────────────────────────────────────────────────────────────

INSERT INTO player_base (nome, id_classe, efeitos)
SELECT 'Dom Saurom S. M. D. H. A. P. H. M.', @id_zero, ''
WHERE NOT EXISTS (SELECT 1 FROM player_base WHERE nome = 'Dom Saurom S. M. D. H. A. P. H. M.');

SET @saurom_id = (SELECT id FROM player_base WHERE nome = 'Dom Saurom S. M. D. H. A. P. H. M.');

INSERT INTO player_dinheiro (id_player, dinheiro, fragmento)
SELECT @saurom_id, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM player_dinheiro WHERE id_player = @saurom_id);

INSERT INTO player_status (id_player, level, hp, forca, velocidade, agilidade, durabilidade, combate, experiencia)
SELECT @saurom_id, 28, 103, 25, 25, 25, 30, 7, 19
WHERE NOT EXISTS (SELECT 1 FROM player_status WHERE id_player = @saurom_id);

INSERT INTO player_energias (id_player, iq, stamina, energia, aura)
SELECT @saurom_id, 220, 60, 140, 18
WHERE NOT EXISTS (SELECT 1 FROM player_energias WHERE id_player = @saurom_id);

INSERT INTO player_mente (id_player, sanidade, sanidadeMax, stress, traumas, rm)
SELECT @saurom_id, 79, 99, 57, 0, 35
WHERE NOT EXISTS (SELECT 1 FROM player_mente WHERE id_player = @saurom_id);

-- Título de Dom Saurom
INSERT INTO R_player_titulo (id_player, id_titulo)
SELECT @saurom_id, @tit_saurom
WHERE NOT EXISTS (SELECT 1 FROM R_player_titulo WHERE id_player = @saurom_id AND id_titulo = @tit_saurom);

-- Itens de Dom Saurom
INSERT INTO R_player_item (id_player, id_item)
SELECT @saurom_id, @item_brasao_solen
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = @saurom_id AND id_item = @item_brasao_solen);

INSERT INTO R_player_item (id_player, id_item)
SELECT @saurom_id, @item_celular
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = @saurom_id AND id_item = @item_celular);

INSERT INTO R_player_item (id_player, id_item)
SELECT @saurom_id, @item_runa_roxa
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = @saurom_id AND id_item = @item_runa_roxa);

INSERT INTO R_player_item (id_player, id_item)
SELECT @saurom_id, @item_runa_verde
WHERE NOT EXISTS (SELECT 1 FROM R_player_item WHERE id_player = @saurom_id AND id_item = @item_runa_verde);

-- Técnica de Dom Saurom (jutsus são das invocações — faremos depois)
INSERT INTO player_tecnicas (id_player, nome, descricao)
SELECT @saurom_id, 'Segunda Chance',
'Liga a alma do usuário com a invocação, trazendo a alma de um falecido antigo por meio de um objeto e colocando-a em um corpo amaldiçoado visível a pessoas normais. Um tem metade da alma do outro.'
WHERE NOT EXISTS (SELECT 1 FROM player_tecnicas WHERE id_player = @saurom_id AND nome = 'Segunda Chance');


-- ────────────────────────────────────────────────────────────
-- STEP 7: NOVO PLAYER — DRAKKMAR C. DRACO (id=11)
-- ────────────────────────────────────────────────────────────

INSERT INTO player_base (nome, id_classe, efeitos)
SELECT 'Drakkmar C. Draco', @id_dragao,
'A energia dele é KI (engloba prana, force, aura e E.A. em um só). Sem KI o usuário morre. Ele é de outra Era (fraturas).'
WHERE NOT EXISTS (SELECT 1 FROM player_base WHERE nome = 'Drakkmar C. Draco');

SET @drakkmar_id = (SELECT id FROM player_base WHERE nome = 'Drakkmar C. Draco');

INSERT INTO player_dinheiro (id_player, dinheiro, fragmento)
SELECT @drakkmar_id, 0, 0
WHERE NOT EXISTS (SELECT 1 FROM player_dinheiro WHERE id_player = @drakkmar_id);

INSERT INTO player_status (id_player, level, hp, forca, velocidade, agilidade, durabilidade, combate, experiencia)
SELECT @drakkmar_id, 14, 2400, 65, 75, 74, 70, 60, 100
WHERE NOT EXISTS (SELECT 1 FROM player_status WHERE id_player = @drakkmar_id);

INSERT INTO player_energias (id_player, iq, stamina, energia, aura)
SELECT @drakkmar_id, 400, 6000, 1600, 70
WHERE NOT EXISTS (SELECT 1 FROM player_energias WHERE id_player = @drakkmar_id);

INSERT INTO player_mente (id_player, sanidade, sanidadeMax, stress, traumas, rm)
SELECT @drakkmar_id, 100, 130, 10, 1, 50
WHERE NOT EXISTS (SELECT 1 FROM player_mente WHERE id_player = @drakkmar_id);

-- Títulos de Drakkmar
INSERT INTO R_player_titulo (id_player, id_titulo)
SELECT @drakkmar_id, @tit_dragao_v
WHERE NOT EXISTS (SELECT 1 FROM R_player_titulo WHERE id_player = @drakkmar_id AND id_titulo = @tit_dragao_v);

INSERT INTO R_player_titulo (id_player, id_titulo)
SELECT @drakkmar_id, @tit_fujao
WHERE NOT EXISTS (SELECT 1 FROM R_player_titulo WHERE id_player = @drakkmar_id AND id_titulo = @tit_fujao);

-- Talentos de Drakkmar
INSERT INTO player_talentos (id_player, nome, descricao)
SELECT @drakkmar_id, 'Acordo com o Autor', 'Acordo feito com o Autor. Efeito: ao receber dano letal, ativa Vínculo do Autor (uso único por combate).'
WHERE NOT EXISTS (SELECT 1 FROM player_talentos WHERE id_player = @drakkmar_id AND nome = 'Acordo com o Autor');

INSERT INTO player_talentos (id_player, nome, descricao)
SELECT @drakkmar_id, 'Acordo com Quetzalcoatl', 'Acordo feito com Quetzalcoatl.'
WHERE NOT EXISTS (SELECT 1 FROM player_talentos WHERE id_player = @drakkmar_id AND nome = 'Acordo com Quetzalcoatl');

INSERT INTO player_talentos (id_player, nome, descricao)
SELECT @drakkmar_id, 'Benção de Quetzalcoatl',
'Adaptação de Combate: enquanto lutando ganha +1 no dado por turno sem limite. Funciona até ser interrompida por autoridade, lei absoluta ou algo mais poderoso.'
WHERE NOT EXISTS (SELECT 1 FROM player_talentos WHERE id_player = @drakkmar_id AND nome = 'Benção de Quetzalcoatl');

-- Técnica de Drakkmar
INSERT INTO player_tecnicas (id_player, nome, descricao)
SELECT @drakkmar_id, 'Arte Dracônica',
'Poderes naturais do Dragão Verdadeiro baseados em KI (energia unificada). KI engloba prana, force, aura e E.A. Inclui acordos com o Autor e Quetzalcoatl.'
WHERE NOT EXISTS (SELECT 1 FROM player_tecnicas WHERE id_player = @drakkmar_id AND nome = 'Arte Dracônica');

SET @drakkmar_tec = (SELECT id FROM player_tecnicas WHERE id_player = @drakkmar_id AND nome = 'Arte Dracônica');

-- Jutsus de Drakkmar (KI aproximado como E.A. id=2 onde aplicável; Stamina como Prana id=1)
INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Fogo Abissal', 30, 2, 14,
'Cone 80m. Dano = 3.6× Fogo base + DoT 3 turnos (10%/turno). -25% resistência mágica do alvo por 2 turnos. +0,5% dano por 10 de IQ.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Fogo Abissal');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Mordida Venenosa', 30, 1, 1,
'Físico. Custo: 30 Stamina. Aplica Selo Dracônico (2 turnos): +15% dano recebido do Drakkmar.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Mordida Venenosa');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Pele de Ferro', 25, 2, 10,
'Reflexão Parcial: reflete 70% do dano mágico recebido ao atacante. +10 durabilidade durante uso.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Pele de Ferro');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Sopro Abissal Ultimatum', 180, 2, 14,
'Ultimate. 180 KI + 120 Stamina. CD: 6 turnos. Canaliza 1 turno; cone 300m: dano = 3.5× Fogo Abissal. Paralisia mental 1 turno. Com Essência Dracônica: ×1.25 e paralisia 2 turnos.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Sopro Abissal Ultimatum');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Garras Rachadoras', 30, 1, 12,
'Físico. 30 Stamina. Ataque duplo: 2º golpe ignora 30% armadura. Se 1º leva alvo a <30% HP, 2º causa sangramento por 2 turnos.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Garras Rachadoras');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Rugido do Suserano', 40, 2, 1,
'Suporte/controle. AOE 40m. CD: 4 turnos. -20% precisão inimiga 2 turnos; +10% dano físico aliado 2 turnos. Em Essência Titânica: provoca inimigos 1 turno.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Rugido do Suserano');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Sangue de Dragão', 100, 2, 1,
'Recuperação. Instant. Restaura 300 HP + 5% KI máximo. Penalidade: -25% taxa de recuperação de KI por 2 turnos.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Sangue de Dragão');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Escama Reflexiva', 0, 2, 10,
'Passiva. -32% dano recebido. Em Essência Titânica: 42% e +20% resistência a atordoamentos.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Escama Reflexiva');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Sentido Predador', 0, 2, 1,
'Passiva/crit. +20% chance crítica contra alvos com <50% HP. Ataque Duplo nesse estado: 2º ataque tem 100% de acerto crítico.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Sentido Predador');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Vínculo do Autor', 300, 2, 1,
'Lenda. Uso único por combate. 300 KI + 200 Stamina. Ao receber dano letal: fica com 1 HP, cura 25% HP máximo, Imunidade a controle por 2 turnos.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Vínculo do Autor');

INSERT INTO player_jutsus (id_tecnica, nome, custo, id_energia_custo, level, descricao)
SELECT @drakkmar_tec, 'Passo Dracônico', 20, 1, 1,
'Mobilidade/ataque. 20 Stamina. Teleporta até 122m + ataque cortante com prioridade. Após Passo Furtivo: stun 1 turno.'
WHERE NOT EXISTS (SELECT 1 FROM player_jutsus WHERE id_tecnica = @drakkmar_tec AND nome = 'Passo Dracônico');

-- Habilidades básicas de Drakkmar
INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT @drakkmar_id, 1, 1
WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = @drakkmar_id AND id_habilidade_basica = 1);

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT @drakkmar_id, 2, 10
WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = @drakkmar_id AND id_habilidade_basica = 2);

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT @drakkmar_id, 3, 10
WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = @drakkmar_id AND id_habilidade_basica = 3);

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT @drakkmar_id, 4, 1
WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = @drakkmar_id AND id_habilidade_basica = 4);

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT @drakkmar_id, 5, 1
WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = @drakkmar_id AND id_habilidade_basica = 5);

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT @drakkmar_id, @hab_instinto, 10
WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = @drakkmar_id AND id_habilidade_basica = @hab_instinto);

INSERT INTO R_player_habilidades_basicas (id_player, id_habilidade_basica, level)
SELECT @drakkmar_id, @hab_acordos, 1
WHERE NOT EXISTS (SELECT 1 FROM R_player_habilidades_basicas WHERE id_player = @drakkmar_id AND id_habilidade_basica = @hab_acordos);