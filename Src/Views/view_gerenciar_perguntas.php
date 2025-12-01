<link rel="stylesheet" href="/assets/gerenciar_perguntas.css">

<main>
    <div class="header-top">
        <h1>Gerenciar Perguntas</h1>

        <div class="botoes-topo">
            <a href="/" class="btn-crud btn-voltar">Voltar</a>
            <a href="/pergunta/form" class="btn-crud btn-nova">+ Nova Pergunta</a>
        </div>
    </div>

    <?php if (!empty($perguntas)): ?>
        <div class="perguntas-lista">
            <?php foreach ($perguntas as $p): ?>
                <div class="pergunta-card">
                    <div class="pergunta-info">
                        <p>ID:    <?= $p['id'] ?></p>
                        <p>Texto: <?= $p['texto'] ?></p>
                        <p>Tipo:  <?= $p['tipo'] ?></p>
                        <p>Ordem: <?= $p['ordem'] ?></p>
                    </div>
                    <div class="pergunta-acoes">
                        <a href="/pergunta/form?id=<?= $p['id'] ?>" class="btn-crud">Editar</a>
                        <a href="/pergunta/excluir/<?= $p['id'] ?>" class="btn-excluir"
                        >Excluir</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="nenhuma-pergunta">Nenhuma pergunta cadastrada.</p>
    <?php endif; ?>
</main>