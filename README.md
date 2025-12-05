# Feedback System - README

Sistema simples para gerenciamento de perguntas, desenvolvido em PHP com MVC próprio.

## 📌 Funcionalidades

* Criar perguntas
* Editar perguntas
* Excluir perguntas
* Validação de ordem
* Tipos de resposta:

  * Resposta aberta
  * Escala 0 a 5
  * Escala 0 a 10

## ⚙ Tecnologias

* PHP 8+
* PostgreSQL
* HTML/CSS
* JavaScript 


## 🔍 Validações importantes

* Ordem não pode repetir entre registros
* Em edição, a ordem é comparada ignorando o próprio registro

## 📁 Configuração

*Clone o projeto utilizando o comando git clone https://github.com/Gorgesw/FeedBack


### Banco de dados

Crie a tabela:

```
-- 1. Limpa tabelas (caso existam)
DROP TABLE tbresposta CASCADE;
DROP TABLE tbavaliacao CASCADE;
DROP TABLE tbpergunta CASCADE;

-- 2. TABELA: PERGUNTAS
CREATE TABLE tbpergunta (
    id SERIAL PRIMARY KEY,
    texto VARCHAR(500) NOT NULL,
    tipo VARCHAR(20) CHECK (tipo IN ('escala', 'aberta')) NOT NULL,
    escala_min SMALLINT DEFAULT 0,
    escala_max SMALLINT DEFAULT 5,
    ordem INTEGER NOT NULL UNIQUE
);

-- 3. TABELA: AVALIAÇÃO (agrupa respostas)
CREATE TABLE tbavaliacao (
    id SERIAL PRIMARY KEY,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. TABELA: RESPOSTAS
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

```

### Configurar conexão

Edite `Src/Core/conexaobd.php` com host, usuário, senha e banco.

## ▶ Como rodar

1. Subir servidor local (WAMP/LAMP/XAMPP)
2. Configurar VirtualHost apontando para `/Public`
3. Acessar no navegador:

```
http://localhost:8080/pergunta
```

## 📄 Licença

Projeto livre para estudo.
