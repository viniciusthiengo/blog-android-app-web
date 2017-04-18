<?php
    $html = <<<HTML
        <form id="form-atualizar-email-login">
            <label for="cp-password">
                Senha atual (para prosseguir com a atualização)
            </label>
            <input id="cp-password" type="password" />
            <br><br>


            <label for="cp-email">
                Email de login
            </label>
            <input id="cp-email" type="email" maxlength="100" value="{$user->email}" />


            <br><br>
            <button type="submit">Atualizar email</button>
            <input id="metodo" type="hidden" value="atualizar-email-login" />
        </form>
HTML;
