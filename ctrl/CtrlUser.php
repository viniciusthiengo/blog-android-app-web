<?php
    /*
     * Caso queira encontrar alguns erros em sua aplicação backend,
     * descomente a linha abaixo.
     * */
    //ini_set('display_errors', 1);
    //session_start();
    require_once('../autoload.php');


    /*
     * A superglobal GET é para quando estiver realizando testes pelo navegador
     * para não precisar configurar toda a APP para simples testes no backend.
     * */
    $dados = isset($_POST['metodo']) ? $_POST : $_GET;


    if( strcasecmp( $dados['metodo'], 'login' ) == 0 ){
        $user = new User();
        $user->setDados_POST();

        $apl = new AplUser();
        $apl->login( $user );

        header('Content-Type: application/json; charset=utf-8');
        echo json_encode( $user );
    }

