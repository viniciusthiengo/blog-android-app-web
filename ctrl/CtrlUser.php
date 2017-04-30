<?php
    require_once('../autoload.php');

    /*
     * Caso queira encontrar alguns erros em sua aplicação backend,
     * descomente a linha abaixo.
     * */
    //ini_set('display_errors', 1);


    /*
     * A superglobal GET é para quando estiver realizando testes pelo navegador
     * para não precisar configurar toda a APP para simples testes no backend.
     * */
    $dados = isset($_POST['metodo']) ? $_POST : $_GET;
    $_POST = $dados; /* Para obter dados dentro dos objetos, somente $_POST é utilizado */

    header('Content-Type: application/json; charset=utf-8');


    if( strcasecmp( $dados['metodo'], 'login' ) == 0 ){
        $user = new User();
        $user->setDados_POST();

        $apl = new AplUser();
        $apl->login( $user );

        echo json_encode( $user );
    }


    else if( strcasecmp( $dados['metodo'], 'registrar-token-notificacao' ) == 0 ){
        $user = new User();
        $user->setDados_POST();

        $apl = new AplUser();
        $resultado = $apl->saveToken( $user );

        $obj = new stdClass();
        $obj->resultado = $resultado;
        echo json_encode( $obj );
    }

