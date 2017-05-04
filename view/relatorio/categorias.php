<?php
    foreach( $categorias as $categoria ){
        $html .= <<<HTML
            <div class="relatorio">
                <label>{$categoria->rotulo}:</label>
                {$categoria->getPercentAsString()}
            </div>
HTML;
    }

$html = <<<HTML
    <form>
        <h3>Total instalações: {$instalacoes}</h3>
        <br><br>

        {$html}
    </form>
HTML;


