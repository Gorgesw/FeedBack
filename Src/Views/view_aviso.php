<link rel="stylesheet" href="/assets/aviso.css">
<main>
    <h1>Ação realizada</h1>

    <div class="mensagem-box">
        <p><?= $mensagem ?? 'Operação concluída com sucesso.' ?></p>
    </div>

    <div class="form-actions">
        <a href="/pergunta/listar" class="btn-crud btn-voltar">Voltar</a>
    </div>
</main>
