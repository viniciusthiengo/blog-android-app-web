<?php
    session_start();
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
        $userSystem = new UserSystem();
        $userSystem->setDados_POST();

        $apl = new AplAdmin();
        $resultado = $apl->login( $userSystem );

        echo json_encode( array('resultado'=>$resultado) );
    }


    else if( strcasecmp( $dados['metodo'], 'sair' ) == 0 ){
        unset($_SESSION[User::ID_KEY]);
        session_destroy();

        echo json_encode( array('resultado'=>1) );
    }


    else if( strcasecmp( $dados['metodo'], 'form-atualizar-email-login' ) == 0 ){
        $userSystem = new UserSystem();

        $apl = new AplAdmin();
        $apl->retrieveUserSystem( $userSystem );

        require_once('../view/form/atualizar-email-login.php');
        echo json_encode( array('html'=>$html) );
    }


    else if( strcasecmp( $dados['metodo'], 'atualizar-email-login' ) == 0 ){
        $userSystem = new UserSystem();
        $userSystem->setDados_POST();

        $apl = new AplAdmin();
        $resultado = $apl->atualizarEmail( $userSystem );

        echo json_encode( array('resultado'=>$resultado) );
    }


    else if( strcasecmp( $dados['metodo'], 'form-atualizar-password-login' ) == 0 ){
        require_once('../view/form/atualizar-password-login.php');
        echo json_encode( array('html'=>$html) );
    }


    else if( strcasecmp( $dados['metodo'], 'atualizar-password-login' ) == 0 ){
        $userSystem = new UserSystem();
        $userSystem->setDados_POST();

        $apl = new AplAdmin();
        $resultado = $apl->atualizarPassword( $userSystem );

        echo json_encode( array('resultado'=>$resultado) );
    }

