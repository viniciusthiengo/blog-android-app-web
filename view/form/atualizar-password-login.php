<?php
    $html = <<<HTML
        <form id="form-atualizar-email-login">
            <label for="cp-password">
                Senha atual (para prosseguir com a atualização)
            </label>
            <input id="cp-password" type="password" />
            <br><br>


            <label for="cp-novo-password">
                Nova senha
            </label>
            <input id="cp-novo-password" type="password" />


            <br><br>
            <button type="submit">Atualizar senha</button>
            <input id="metodo" type="hidden" value="atualizar-password-login" />
        </form>
HTML;
