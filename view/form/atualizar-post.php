<?php
    require_once('../view/form/campos-form-post.php');

    $htmlPosts = '<option value="0">Post</option>';
    foreach( $posts as $post ){
        $htmlPosts .= "<option value=\"{$post->id}\">{$post->titulo}</option>";
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

            {$htmlCampos}

            <br><br>
            <button type="submit">Atualizar post</button>
            <button type="button" class="delete">Deletar post</button>
            <input id="metodo" type="hidden" value="atualizar-post" />
        </form>
HTML;
