<?php
    /*
     * O CÓDIGO ABAIXO É NECESSÁRIO, POIS NO CARREGAMENTO DO
     * FORMULÁRIO DE CIRAÇÃO, LOGO QUE O USUÁRIO SE CONECTA,
     * O PATH DE ACESSO AO ARQUIVO DO FORMULÁRIO É DIFERENTE
     * DE QUANDO O CARREGANDO VIA INVOCAÇÃO AJAX.
     * */
    if( file_exists('view/form/campos-form-post.php') ){
        require_once('view/form/campos-form-post.php');
    }
    else{
        require_once('../view/form/campos-form-post.php');
    }


    $html = <<<HTML
        <form id="form-criar-post">
            {$htmlCampos}

            <br><br>
            <button type="submit">Criar post</button>
            <input id="metodo" type="hidden" value="criar-post" />
        </form>
HTML;
