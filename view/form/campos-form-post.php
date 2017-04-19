<?php
    $htmlCategorias = '<option value="0">Categoria</option>';
    foreach( $categorias as $categoria ){
        $htmlCategorias .= "<option value=\"{$categoria->id}\">{$categoria->rotulo}</option>";
    }


    $htmlCampos = <<<HTML
        <label for="cp-titulo">
            Título
        </label>
        <input id="cp-titulo" type="text" maxlength="100" />
        <br><br>


        <label for="cp-categoria">
            Categoria
        </label>
        <select id="cp-categoria">
            {$htmlCategorias}
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
HTML;
