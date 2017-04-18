<?php
    $htmlPosts = '<option value="0">Post</option>';
    foreach( $posts as $post ){
        $htmlPosts .= "<option value=\"{$post->id}\">{$post->titulo}</option>";
    }


    $htmlCategorias = '<option value="0">Categoria</option>';
    foreach( $categorias as $categoria ){
        $htmlCategorias .= "<option value=\"{$categoria->id}\">{$categoria->rotulo}</option>";
    }


    $html = <<<HTML
        <form id="form-atualizar-post">
            <label for="cp-post">
                Selecione o post
            </label>
            <select id="cp-post">
                {$htmlPosts}
            </select>
            <br><br>


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


            <br><br>
            <button type="submit">Atualizar post</button>
            <button type="button" class="delete">Deletar post</button>
            <input id="metodo" type="hidden" value="atualizar-post" />
        </form>
HTML;
