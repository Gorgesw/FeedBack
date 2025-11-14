
<link rel="stylesheet" href="/assets/style.css">

<h1>Formulário de Avaliação</h1>

<form method="post" action="/envia_avaliacao">

    <?php
    if (!empty($perguntas) && is_array($perguntas)) {
        foreach ($perguntas as $pergunta) {
            echo "<div class='pergunta'>";
            echo "<p class='titulo-pergunta'>{$pergunta['texto']}</p>";

            if ($pergunta['tipo'] === 'escala') {
                echo "<div class='escala'>";
                for ($i = 0; $i <= $pergunta['escala_max']; $i++) {

                    echo "
                    <label class='btn-quadrado'>
                        <input type='radio' name='resposta[{$pergunta['id']}]' value='{$i}'>
                        <span>{$i}</span>
                    </label>";
                }
                echo "</div>";
            }


            elseif ($pergunta['tipo'] === 'aberta') {
                echo '<textarea class="texto-aberto" name="resposta[' . $pergunta['id'] . ']"></textarea>';
            }

            echo "</div><hr>";
        }
    } else {
        echo "<p>Nenhuma pergunta cadastrada.</p>";
    }
    ?>

    <button type="submit" class="btn-enviar">Enviar Avaliação</button>
</form>

<footer class="aviso">
    Sua avaliação espontânea é anônima, nenhuma informação pessoal é solicitada ou armazenada.
</footer>
