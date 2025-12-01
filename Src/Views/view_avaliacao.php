<link href="https://fonts.googleapis.com/css2?family=Inter:wght@500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="/assets/avaliacao.css">

<main>
    <a href="/pergunta" class="btn-admin">Gerenciar Perguntas</a>
    <h1>Formulário de Avaliação</h1>

    <form method="post" action="/envia_avaliacao">

        <?php
        if (!empty($perguntas) && is_array($perguntas)) {
            foreach ($perguntas as $pergunta) {
                echo "<div class='card'>";
                echo "<p class='pergunta'>{$pergunta['texto']}</p>";

                if ($pergunta['tipo'] === 'escala') {
                    echo "<div class='escala'>";
                    for ($i = 0; $i <= $pergunta['escala_max']; $i++) {
                        echo "<label class='btn'>
                                <input type='radio' name='resposta[{$pergunta['id']}]' value='{$i}'>
                                <span>{$i}</span>
                              </label>";
                    }
                    echo "</div>";
                } elseif ($pergunta['tipo'] === 'aberta') {
                    echo '<textarea class="texto-aberto" name="resposta['.$pergunta['id'].']"></textarea>';
                }
                echo "</div>";
            }
        } else {
            echo "<p class='vazio'>Nenhuma pergunta cadastrada.</p>";
        }
        ?>

        <button type="submit" class="btn-enviar">Enviar Avaliação</button>
    </form>

    <footer class="aviso">
        Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.
    </footer>
</main>