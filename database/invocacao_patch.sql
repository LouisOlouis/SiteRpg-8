USE SiteRPG;

-- ============================================================
-- PATCH: adiciona coluna id_player em invocacao_base
-- (necessário para vincular invocação ao player dono)
-- ============================================================

ALTER TABLE invocacao_base
    ADD COLUMN id_player INT AFTER id,
    ADD CONSTRAINT fk_invocacao_player
        FOREIGN KEY (id_player) REFERENCES player_base(id);

-- ============================================================
-- PATCH: R_invocacao_encantamento — adiciona coluna level
-- (o fichaview de players mostra level do encantamento;
--  para manter consistência, adicionamos na tabela de invocação)
-- ============================================================

ALTER TABLE R_invocacao_encantamento
    ADD COLUMN level INT DEFAULT 1 AFTER id_encantamentos;
