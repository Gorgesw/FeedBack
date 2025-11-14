-- 1. TABELA: PERGUNTAS (tbpergunta)
CREATE TABLE tbpergunta (
    id SERIAL PRIMARY KEY,
    texto VARCHAR(500) NOT NULL,
    tipo VARCHAR(20) CHECK (tipo IN ('escala', 'aberta')) NOT NULL,
    escala_min SMALLINT DEFAULT 0,
    escala_max SMALLINT DEFAULT 5,
    ordem INTEGER NOT NULL,
    UNIQUE(ordem)
);

-- 2. TABELA: AVALIAÇÃO (tbavaliacao) - agrupa respostas
CREATE TABLE tbavaliacao (
    id SERIAL PRIMARY KEY,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 3. TABELA: RESPOSTAS (tbresposta)
CREATE TABLE tbresposta (
    id SERIAL PRIMARY KEY,
    id_avaliacao INTEGER NOT NULL REFERENCES tbavaliacao(id) ON DELETE CASCADE,
    id_pergunta INTEGER NOT NULL REFERENCES tbpergunta(id) ON DELETE RESTRICT,
    valor SMALLINT CHECK (valor >= 0 AND valor <= 10),
    texto TEXT,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- =============================================
-- DADOS DE EXEMPLO (perguntas com escala 0–5 e 0–10)
-- =============================================
INSERT INTO tbpergunta (texto, tipo, escala_min, escala_max, ordem) VALUES
('Como você avalia o atendimento?', 'escala', 0, 5, 1),
('Qual é a sua satisfação geral com o serviço?', 'escala', 0, 10, 2),
('O que podemos melhorar? (opcional)', 'aberta', 0, 0, 3),
('O ambiente estava limpo e organizado?', 'escala', 0, 5, 4);
