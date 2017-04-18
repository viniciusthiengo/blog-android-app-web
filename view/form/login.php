<?php
    $html = <<<HTML
        <form id="form-login">
            <label>
                Login
            </label>
            <br>

            <input id="cp-email" type="email" maxlength="100" placeholder="Email" />
            <br>
            <input id="cp-password" type="password" placeholder="Senha" />
            <br><br>

            <button type="submit">Entrar</button>
            <input id="metodo" type="hidden" value="login" />
        </form>
HTML;
