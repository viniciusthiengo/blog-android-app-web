<?php
    $html = '<option value="0">Categoria</option>';
    foreach( $categorias as $categoria ){
        $html .= "<option value=\"{$categoria->id}\">{$categoria->rotulo}</option>";
    }

    $html = <<<HTML
        <form id="form-criar-post">
            <label for="cp-titulo">
                Título
            </label>
            <input id="cp-titulo" type="text" maxlength="100" />
            <br><br>


            <label for="cp-categoria">
                Categoria
            </label>
            <select id="cp-categoria">
                {$html}
            </select>
            <br><br>


            <label for="cp-sumario">
                Sumário
            </label>
            <textarea id="cp-sumario" rows="4"></textarea>
            <br><br>


            <label for="cp-imagem">
                URI Imagem (URI Web)
            </label>
            <input id="cp-imagem" type="text" maxlength="160" />


            <br><br>
            <button type="submit">Criar post</button>
            <input id="metodo" type="hidden" value="criar-post" />
        </form>
HTML;
