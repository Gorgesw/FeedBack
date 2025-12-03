<link rel="stylesheet" href="/assets/manutencao_pergunta.css">

<main>
    
    <h1>
        <?php
        if ($pergunta) {
            echo 'Editar Pergunta';
        } else {
            echo 'Nova Pergunta';
        }
        ?>
    </h1>

    <form method="post" action="/pergunta/salvar" class="form-crud">
    <input type="hidden" name="id" value="<?= $pergunta['id'] ?? '' ?>">
        <div class="form-group">
            <label>Texto da pergunta *</label>
            <input type="text" name="texto" value="<?= $pergunta['texto'] ?? '' ?>" required
                placeholder="Ex: O quanto você recomenda nossa empresa?">
        </div>

        <div class="form-group">
    <label>Tipo da resposta *</label>
    <select name="tipo" id="tipo" required>

        <?php
        $tipo      = $pergunta['tipo'] ?? '';
        $escalaMax = $pergunta['escala_max'] ?? '';
        ?>

        <option value="aberta" 
            <?php if ($tipo === 'aberta') echo 'selected'; ?>>
            Resposta aberta (texto livre)
        </option>

        <option value="escala_5" 
            <?php if ($tipo === 'escala' && $escalaMax == '5') echo 'selected'; ?>>
            Escala 0 a 5
        </option>

        <option value="escala_10" 
            <?php if ($tipo === 'escala' && $escalaMax == '10') echo 'selected'; ?>>
            Escala 0 a 10 
        </option>

    </select>
</div>

        <div class="form-group">
            <label>Ordem de exibição *</label>
            <input type="number" name="ordem" value="<?= $pergunta['ordem'] ?? '' ?>" required min="1"
                placeholder="1, 2, 3...">
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-crud btn-salvar">
                <?= $pergunta ? 'Salvar alterações' : 'Criar pergunta' ?>
            </button>
            <a href="/pergunta" class="btn-crud btn-voltar">Cancelar</a>
        </div>
    </form>
</main>